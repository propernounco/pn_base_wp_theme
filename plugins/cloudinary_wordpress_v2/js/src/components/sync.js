/* global window wp */

const Sync = {
	progress: document.getElementById( 'progress-wrapper' ),
	submitButton: document.getElementById( 'submit' ),
	stopButton: document.getElementById( 'stop-sync' ),
	progressCount: document.getElementById( 'sync-progress' ),
	barSyncCount: document.getElementById( 'sync-total' ),
	completed: document.getElementById( 'completed-notice' ),
	show: 'inline-block',
	hide: 'none',
	getStatus: function getStatus() {
		var self = this,
			resourceType = [],
			url = cloudinaryApi.restUrl + 'cloudinary/v1/attachments',
			params;

		wp.ajax.send( {
			url: url,
			type: 'GET',
			beforeSend: function( request ) {
				request.setRequestHeader( 'X-WP-Nonce', cloudinaryApi.nonce );
			},
		} ).done( function( data ) {
			if ( data.done < data.total ) {
				setTimeout( Sync.getStatus, 2000 );
			}
			Sync._updateUI( data );
		} );
	},
	stopSync: function stopSync() {
		var self = this,
			url = cloudinaryApi.restUrl + 'cloudinary/v1/sync';

		wp.ajax.send( {
			url: url,
			data: {
				stop: true,
			},
			beforeSend: function( request ) {
				request.setRequestHeader( 'X-WP-Nonce', cloudinaryApi.nonce );
			},
		} ).done( function( data ) {
			Sync._updateUI( data );
		} );
	},
	pushAttachments: function pushAttachments() {
		var self = this,
			url = cloudinaryApi.restUrl + 'cloudinary/v1/sync';

		wp.ajax.send( {
			url: url,
			beforeSend: function( request ) {
				request.setRequestHeader( 'X-WP-Nonce', cloudinaryApi.nonce );
			},
		} );
	},
	_updateUI: function _updateUI( data ) {
		if ( data.percent < 100 && typeof data.started !== 'undefined' ) {
			this.submitButton.style.display = this.hide;
			this.stopButton.style.display = this.show;
		}
		else if ( data.percent >= 100 && typeof data.started !== 'undefined' ) {
			this.submitButton.style.display = this.hide;
			this.stopButton.style.display = this.show;
		}
		else if ( data.pending > 0 ) {
			this.submitButton.style.display = this.show;
			this.stopButton.style.display = this.hide;
		}
		else if ( data.processing > 0 ) {
			this.stopButton.style.display = this.show;
		}
		else {
			this.stopButton.style.display = this.hide;
		}

		if ( data.percent < 100 ) {
			this.barSyncCount.innerText = data.total;
			this.progressCount.innerText = data.done;
			this.progress.style.display = this.show;
		}
		else {
			this.completed.style.display = this.show;
			this.progress.style.display = this.hide;
		}
	},
	_start: function _start( e ) {
		e.preventDefault();
		Sync.stopButton.style.display = Sync.show;
		Sync.submitButton.style.display = Sync.hide;
		Sync.pushAttachments();
	},
	_reset: function _reset( e ) {
		Sync.submitButton.style.display = Sync.hide;
		Sync.getStatus();
	},
	_init: function( fn ) {

		if ( typeof cloudinaryApi !== 'undefined' ) {
			if ( document.attachEvent ? document.readyState === 'complete' : document.readyState !== 'loading' ) {
				fn();
			}
			else {
				document.addEventListener( 'DOMContentLoaded', fn );
			}
		}
	},
};

export default Sync;

// Init.
Sync._init( function() {
	Sync._reset();
	Sync.submitButton.addEventListener( 'click', Sync._start );
	Sync.stopButton.addEventListener( 'click', Sync.stopSync );
} );
