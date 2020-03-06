/* global window wp wpAjax */

const Terms_Order = {
	template: '',
	tags: jQuery( '#cld-tax-items' ),
	tagDelimiter: (window.tagsSuggestL10n && window.tagsSuggestL10n.tagDelimiter) || ',',
	_init: function() {

		// Check that we found the tax-items.
		if ( !this.tags.length ) {
			return;
		}
		// Init sortables.
		this._sortable();

		let self = this;
		// Setup ajax overrides.
		if ( typeof wpAjax !== 'undefined' ) {
			wpAjax.procesParseAjaxResponse = wpAjax.parseAjaxResponse;
			wpAjax.parseAjaxResponse = function( response, settings_response, element ) {
				let new_response = wpAjax.procesParseAjaxResponse( response, settings_response, element );
				if ( !new_response.errors && new_response.responses[ 0 ] ) {
					if ( jQuery( '[data-taxonomy="' + new_response.responses[ 0 ].what + '"]' ).length ) {
						let data = jQuery( new_response.responses[ 0 ].data ),
							text = data.find( 'label' ).last().text().trim();
						self._pushItem( new_response.responses[ 0 ].what, text );
					}
				}
				return new_response;
			};
		}

		if ( typeof window.tagBox !== 'undefined' ) {
			window.tagBox.processflushTags = window.tagBox.flushTags;
			window.tagBox.flushTags = function( el, a, f ) {

				if ( typeof f === 'undefined' ) {
					var taxonomy = el.prop( 'id' ),
						text,
						list,
						newtag = $( 'input.newtag', el );

					a = a || false;

					text = a ? $( a ).text() : newtag.val();
					list = window.tagBox.clean( text ).split( self.tagDelimiter );

					for (var i in list) {
						var tag = taxonomy + ':' + list[ i ];
						if ( !jQuery( '[data-item="' + tag + '"]' ).length ) {
							self._pushItem( tag, list[ i ] );
						}
					}
				}
				return this.processflushTags( el, a, f );
			};

			window.tagBox.processTags = window.tagBox.parseTags;
			window.tagBox.parseTags = function( el ) {

				let id = el.id,
					num = id.split( '-check-num-' )[ 1 ],
					taxonomy = id.split( '-check-num-' )[ 0 ],
					taxbox = $( el ).closest( '.tagsdiv' ),
					thetags = taxbox.find( '.the-tags' ),
					current_tags = window.tagBox.clean( thetags.val() ).split( self.tagDelimiter ),
					remove_tag = current_tags[ num ],
					remove_sortable = jQuery( '[data-item="' + taxonomy + ':' + remove_tag + '"]' );

				remove_sortable.remove();
				this.processTags( el );
			};
		}

		jQuery( 'body' ).on( 'change', '.selectit input', function() {
			let clicked = jQuery( this ),
				text = clicked.parent().text().trim(),
				id = clicked.val(),
				checked = clicked.is( ':checked' );

			if ( true === checked ) {

				self._pushItem( id, text );
			}
			else {
				self.tags.find( '[data-item="' + id + '"]' ).remove();
			}

		} );

	},
	_createItem: function( id, name ) {
		let li = jQuery( '<li/>' ),
			input = jQuery( '<input/>' ),
			icon = jQuery( '<span/>' );

		li.addClass( 'cld-tax-order-list-item' ).attr( 'data-item', id );
		input.addClass( 'cld-tax-order-list-item-input' ).attr( 'type', 'hidden' ).attr( 'name', 'cld_tax_order[]' ).val( id );
		icon.addClass( 'dashicons dashicons-menu cld-tax-order-list-item-handle' );

		li.append( icon ).append( name ).append( input ); // phpcs:ignore WordPressVIPMinimum.JS.HTMLExecutingFunctions.append
		return li;
	},
	_pushItem: function( id, text ) {
		let item = this._createItem( id, text );
		this.tags.append( item ); // phpcs:ignore WordPressVIPMinimum.JS.HTMLExecutingFunctions.append
	},
	_sortable: function() {

		let items = jQuery( '.cld-tax-order-list' );
		items.sortable( {
			connectWith: '.cld-tax-order',
			axis: 'y',
			handle: '.cld-tax-order-list-item-handle',
			placeholder: 'cld-tax-order-list-item-placeholder',
			forcePlaceholderSize: true,
			helper: 'clone',
		} );
	}
};

export default Terms_Order;

// Init.
if ( typeof window.CLDN !== 'undefined' ) {
	Terms_Order._init();
}

// Gutenberg.
if ( wp.data && wp.data.select( 'core/editor' ) ) {
	let order_set = {};
	wp.data.subscribe( function() {

		let taxonomies = wp.data.select( 'core' ).getTaxonomies();

		if ( taxonomies ) {
			for (let t in taxonomies) {
				let set = wp.data.select( 'core/editor' ).getEditedPostAttribute( taxonomies[ t ].rest_base );
				order_set[ taxonomies[ t ].slug ] = set;
			}
		}

	} );

	let el = wp.element.createElement;

	let CustomizeTaxonomySelector = function( OriginalComponent ) {

		class customHandler extends OriginalComponent {

			makeItem( item ) {
				let row = this.makeElement( item );
				let box = jQuery( '#cld-tax-items' );
				box.append( row ); // phpcs:ignore WordPressVIPMinimum.JS.HTMLExecutingFunctions.append
			}

			findOrCreateTerm( termName ) {
				let self = this;
				termName = super.findOrCreateTerm( termName );
				termName.then( ( item ) => self.makeItem( item ) );
				return termName;
			}

			onChange( event ) {
				super.onChange( event );
				let item = this.pickItem( event );
				if ( item ) {
					if ( order_set[ this.props.slug ].indexOf( item.id ) >= 0 ) {
						this.makeItem( item );
					}
					else {
						let element = jQuery( '[data-item="' + item.id + '"]' );
						if ( element.length ) {
							element.remove();
						}
					}
				}
			}

			pickItem( event ) {
				if ( typeof event === 'object' ) {
					if ( event.target ) {
						for (let p in this.state.availableTerms) {
							if ( this.state.availableTerms[ p ].id === parseInt( event.target.value ) ) {
								return this.state.availableTerms[ p ];
							}
						}
					}
				}
				else if ( typeof event === 'number' ) {
					for (let p in this.state.availableTerms) {
						if ( this.state.availableTerms[ p ].id === event ) {
							return this.state.availableTerms[ p ];
						}
					}
				}
				else {
					let text;
					// add or remove.
					if ( event.length > this.state.selectedTerms.length ) {
						// Added.
						for (let o in event) {
							if ( this.state.selectedTerms.indexOf( event[ o ] ) === -1 ) {
								text = event[ o ];
							}
						}
					}
					else {
						// removed.
						for (let o in this.state.selectedTerms) {
							if ( event.indexOf( this.state.selectedTerms[ o ] ) === -1 ) {
								text = this.state.selectedTerms[ o ];
							}
						}
					}

					for (let p in this.state.availableTerms) {
						if ( this.state.availableTerms[ p ].name === text ) {
							return this.state.availableTerms[ p ];
						}
					}

				}

			}

			makeElement( item ) {
				let li = jQuery( '<li/>' ),
					input = jQuery( '<input/>' ),
					icon = jQuery( '<span/>' );

				li.addClass( 'cld-tax-order-list-item' ).attr( 'data-item', item.id );
				input.addClass( 'cld-tax-order-list-item-input' ).attr( 'type', 'hidden' ).attr( 'name', 'cld_tax_order[]' ).val( item.id );
				icon.addClass( 'dashicons dashicons-menu cld-tax-order-list-item-handle' );

				li.append( icon ).append( item.name ).append( input ); // phpcs:ignore WordPressVIPMinimum.JS.HTMLExecutingFunctions.append
				return li;
			}
		}

		return function( props ) {

			return el(
				customHandler,
				props
			);
		};

	};

	wp.hooks.addFilter(
		'editor.PostTaxonomyType',
		'cld',
		CustomizeTaxonomySelector
	);
}
