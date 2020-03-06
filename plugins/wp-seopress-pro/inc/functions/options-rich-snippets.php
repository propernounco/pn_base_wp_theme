<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//Rich Snippets
//=================================================================================================
//Rich Snippets JSON-LD

//Check if Type !='' or !='none'
$_seopress_pro_rich_snippets_type = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_type',true);

if (seopress_rich_snippets_enable_option() =='1') { //Is RS enable
	//Articles
	//=========================================================================================
	//Type
	function seopress_rich_snippets_articles_type_option() {
		$_seopress_pro_rich_snippets_article_type = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_article_type',true);
		if ($_seopress_pro_rich_snippets_article_type != '') {
			return $_seopress_pro_rich_snippets_article_type;
		} else { //Default
			return 'NewsArticle';
		}
	}
	//Title
	function seopress_rich_snippets_articles_title_option() {
		$_seopress_pro_rich_snippets_article_title = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_article_title',true);
		if ($_seopress_pro_rich_snippets_article_title != '') {
			return $_seopress_pro_rich_snippets_article_title;
		} else { //Default
			return the_title_attribute('echo=0');
		}
	}
	//Img
	function seopress_rich_snippets_articles_img_option() {
		$_seopress_pro_rich_snippets_article_img = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_article_img',true);
		if ($_seopress_pro_rich_snippets_article_img != '') {
			return $_seopress_pro_rich_snippets_article_img;
		} elseif (has_post_thumbnail(get_the_ID())) {//Post thumbnail
			$_seopress_pro_rich_snippets_article_img = get_the_post_thumbnail_url(get_the_ID(),'large');
			return $_seopress_pro_rich_snippets_article_img;
		} 
	}
	//Img Width
	function seopress_rich_snippets_articles_img_width_option() {
		$_seopress_pro_rich_snippets_article_img_width = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_article_img_width',true);
		if ($_seopress_pro_rich_snippets_article_img_width != '') {
			return $_seopress_pro_rich_snippets_article_img_width;
		} elseif (has_post_thumbnail(get_the_ID())) {//Post thumbnail
			$_seopress_pro_rich_snippets_article_img_width = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
			return $_seopress_pro_rich_snippets_article_img_width[1];
		}
	}
	//Img Height
	function seopress_rich_snippets_articles_img_height_option() {
		$_seopress_pro_rich_snippets_article_img_height = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_article_img_height',true);
		if ($_seopress_pro_rich_snippets_article_img_height != '') {
			return $_seopress_pro_rich_snippets_article_img_height;
		} elseif (has_post_thumbnail(get_the_ID())) {//Post thumbnail
			$_seopress_pro_rich_snippets_article_img_height = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
			return $_seopress_pro_rich_snippets_article_img_height[2];
		}
	}
	//Canonical
	function seopress_rich_snippets_articles_canonical_option() {
		$_seopress_robots_canonical = get_post_meta(get_the_ID(),'_seopress_robots_canonical',true);
		if ($_seopress_robots_canonical != '') {
			return $_seopress_robots_canonical;
		} else {
			global $wp;
			return home_url(add_query_arg(array(), $wp->request));
		}
	};
	//Person name
	function seopress_rich_snippets_articles_publisher_option() {
		$seopress_rich_snippets_articles_publisher_option = get_option("seopress_social_option_name");
		if ( ! empty ( $seopress_rich_snippets_articles_publisher_option ) ) {
			foreach ($seopress_rich_snippets_articles_publisher_option as $key => $seopress_rich_snippets_articles_publisher_value)
				$options[$key] = $seopress_rich_snippets_articles_publisher_value;
			 if (isset($seopress_rich_snippets_articles_publisher_option['seopress_social_knowledge_name'])) { 
			 	return $seopress_rich_snippets_articles_publisher_option['seopress_social_knowledge_name'];
			 }
		}
	}
	//Logo
	function seopress_rich_snippets_articles_publisher_logo_option() {
		$seopress_rich_snippets_articles_publisher_logo_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_rich_snippets_articles_publisher_logo_option ) ) {
			foreach ($seopress_rich_snippets_articles_publisher_logo_option as $key => $seopress_rich_snippets_articles_publisher_logo_value)
				$options[$key] = $seopress_rich_snippets_articles_publisher_logo_value;
			 if (isset($seopress_rich_snippets_articles_publisher_logo_option['seopress_rich_snippets_publisher_logo'])) { 
			 	return $seopress_rich_snippets_articles_publisher_logo_option['seopress_rich_snippets_publisher_logo'];
			 }
		}
	}
	//Logo width
	function seopress_rich_snippets_articles_publisher_logo_width_option() {
		$seopress_rich_snippets_articles_publisher_logo_width_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_rich_snippets_articles_publisher_logo_width_option ) ) {
			foreach ($seopress_rich_snippets_articles_publisher_logo_width_option as $key => $seopress_rich_snippets_articles_publisher_logo_width_value)
				$options[$key] = $seopress_rich_snippets_articles_publisher_logo_width_value;
			 if (isset($seopress_rich_snippets_articles_publisher_logo_width_option['seopress_rich_snippets_publisher_logo_width'])) { 
			 	return $seopress_rich_snippets_articles_publisher_logo_width_option['seopress_rich_snippets_publisher_logo_width'];
			 }
		}
	}
	//Logo height
	function seopress_rich_snippets_articles_publisher_logo_height_option() {
		$seopress_rich_snippets_articles_publisher_logo_height_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_rich_snippets_articles_publisher_logo_height_option ) ) {
			foreach ($seopress_rich_snippets_articles_publisher_logo_height_option as $key => $seopress_rich_snippets_articles_publisher_logo_height_value)
				$options[$key] = $seopress_rich_snippets_articles_publisher_logo_height_value;
			 if (isset($seopress_rich_snippets_articles_publisher_logo_height_option['seopress_rich_snippets_publisher_logo_height'])) { 
			 	return $seopress_rich_snippets_articles_publisher_logo_height_option['seopress_rich_snippets_publisher_logo_height'];
			 }
		}
	}
	//Articles JSON-LD
	if ($_seopress_pro_rich_snippets_type =='articles') {
		function seopress_rich_snippets_articles_option() {
			$html = '<script type="application/ld+json">';
			$html .= '{
				    "@context": "'.seopress_check_ssl().'schema.org",';
					if (seopress_rich_snippets_articles_type_option() !='') {
						$html .= '"@type": '.json_encode(seopress_rich_snippets_articles_type_option()).',';
					}
					if (seopress_rich_snippets_articles_canonical_option() !='') {
						$html .= '"mainEntityOfPage": {
							"@type": "WebPage",
							"@id": '.json_encode(seopress_rich_snippets_articles_canonical_option()).'
						},';
					}
					if (seopress_rich_snippets_articles_title_option() !='') {
						$html .= '"headline": '.json_encode(seopress_rich_snippets_articles_title_option()).',';
					}
					if (seopress_rich_snippets_articles_img_option() !='') {
						$html .= '"image": {
							"@type": "ImageObject",
							"url": '.json_encode(seopress_rich_snippets_articles_img_option()).',
							"height": '.json_encode(seopress_rich_snippets_articles_img_width_option()).',
							"width": '.json_encode(seopress_rich_snippets_articles_img_height_option()).'
						},';
					}
					$html .= '"datePublished": "'.get_the_date('c').'",
					"dateModified": '.json_encode(get_the_modified_date('c')).',
					"author": {
						"@type": "Person",
						"name": '.json_encode(get_the_author()).'
					},';
					
					if (seopress_rich_snippets_articles_publisher_option() !='') {
						$html .= '"publisher": {
					    	"@type": "Organization",
					    	"name": '.json_encode(seopress_rich_snippets_articles_publisher_option()).',';
					    	if (seopress_rich_snippets_articles_publisher_logo_option() !='') {
					    		$html .= '"logo": {
						      		"@type": "ImageObject",
						      		"url": '.json_encode(seopress_rich_snippets_articles_publisher_logo_option()).',
						      		"width": '.json_encode(seopress_rich_snippets_articles_publisher_logo_width_option()).',
						      		"height": '.json_encode(seopress_rich_snippets_articles_publisher_logo_height_option()).'
						      	}';
						    }
					    $html .= '},';
					}
					$html .= '"description": '.json_encode(wp_trim_words(esc_html(get_the_excerpt()), 30));
					$html = trim($html, ',');
				$html .= '}';
			$html .= '</script>';
			$html .= "\n";

			$html = apply_filters('seopress_schemas_article_html', $html);

			echo $html;
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_articles_option', 3 );
		}
	}

	//Local Business
	//=========================================================================================
	//Name
	function seopress_pro_rich_snippets_lb_name_option() {
		$_seopress_pro_rich_snippets_lb_name = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_name',true);
		if ($_seopress_pro_rich_snippets_lb_name != '') {
			return $_seopress_pro_rich_snippets_lb_name;
		}
	}
	//Type
	function seopress_pro_rich_snippets_lb_type_option() {
		$_seopress_pro_rich_snippets_lb_type = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_type',true);
		if ($_seopress_pro_rich_snippets_lb_type != '') {
			return $_seopress_pro_rich_snippets_lb_type;
		} else {
			return 'LocalBusiness';
		}
	}
	//Img
	function seopress_pro_rich_snippets_lb_img_option() {
		$_seopress_pro_rich_snippets_lb_img = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_img',true);
		if ($_seopress_pro_rich_snippets_lb_img != '') {
			return $_seopress_pro_rich_snippets_lb_img;
		}
	}
	//Img width
	function seopress_pro_rich_snippets_lb_img_width_option() {
		$_seopress_pro_rich_snippets_lb_img_width = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_img_width',true);
		if ($_seopress_pro_rich_snippets_lb_img_width != '') {
			return $_seopress_pro_rich_snippets_lb_img_width;
		}
	}
	//Img height
	function seopress_pro_rich_snippets_lb_img_height_option() {
		$_seopress_pro_rich_snippets_lb_img_height = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_img_height',true);
		if ($_seopress_pro_rich_snippets_lb_img_height != '') {
			return $_seopress_pro_rich_snippets_lb_img_height;
		}
	}
	//Street addr
	function seopress_pro_rich_snippets_lb_street_addr_option() {
		$_seopress_pro_rich_snippets_lb_street_addr = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_street_addr',true);
		if ($_seopress_pro_rich_snippets_lb_street_addr != '') {
			return $_seopress_pro_rich_snippets_lb_street_addr;
		}
	}
	//City
	function seopress_pro_rich_snippets_lb_city_option() {
		$_seopress_pro_rich_snippets_lb_city = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_city',true);
		if ($_seopress_pro_rich_snippets_lb_city != '') {
			return $_seopress_pro_rich_snippets_lb_city;
		}
	}
	//State
	function seopress_pro_rich_snippets_lb_state_option() {
		$_seopress_pro_rich_snippets_lb_state = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_state',true);
		if ($_seopress_pro_rich_snippets_lb_state != '') {
			return $_seopress_pro_rich_snippets_lb_state;
		}
	}
	//Postal Code
	function seopress_pro_rich_snippets_lb_pc_option() {
		$_seopress_pro_rich_snippets_lb_pc = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_pc',true);
		if ($_seopress_pro_rich_snippets_lb_pc != '') {
			return $_seopress_pro_rich_snippets_lb_pc;
		}
	}
	//Country
	function seopress_pro_rich_snippets_lb_country_option() {
		$_seopress_pro_rich_snippets_lb_country = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_country',true);
		if ($_seopress_pro_rich_snippets_lb_country != '') {
			return $_seopress_pro_rich_snippets_lb_country;
		}
	}
	//Lat
	function seopress_pro_rich_snippets_lb_lat_option() {
		$_seopress_pro_rich_snippets_lb_lat = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_lat',true);
		if ($_seopress_pro_rich_snippets_lb_lat != '') {
			return $_seopress_pro_rich_snippets_lb_lat;
		}
	}
	//Lon
	function seopress_pro_rich_snippets_lb_lon_option() {
		$_seopress_pro_rich_snippets_lb_lon = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_lon',true);
		if ($_seopress_pro_rich_snippets_lb_lon != '') {
			return $_seopress_pro_rich_snippets_lb_lon;
		}
	}
	//Website
	function seopress_pro_rich_snippets_lb_website_option() {
		$_seopress_pro_rich_snippets_lb_website = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_website',true);
		if ($_seopress_pro_rich_snippets_lb_website != '') {
			return $_seopress_pro_rich_snippets_lb_website;
		}
	}
	//Tel
	function seopress_pro_rich_snippets_lb_tel_option() {
		$_seopress_pro_rich_snippets_lb_tel = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_tel',true);
		if ($_seopress_pro_rich_snippets_lb_tel != '') {
			return $_seopress_pro_rich_snippets_lb_tel;
		}
	}
	//Price
	function seopress_pro_rich_snippets_lb_price_option() {
		$_seopress_pro_rich_snippets_lb_price = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_price',true);
		if ($_seopress_pro_rich_snippets_lb_price != '') {
			return $_seopress_pro_rich_snippets_lb_price;
		}
	}
	//Opening Hours
	function seopress_pro_rich_snippets_lb_opening_hours_option() {
		$_seopress_pro_rich_snippets_lb_opening_hours = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_lb_opening_hours',true);
		if ($_seopress_pro_rich_snippets_lb_opening_hours != '') {
			return $_seopress_pro_rich_snippets_lb_opening_hours;
		}
	}
	//Local Business JSON-LD
	if ($_seopress_pro_rich_snippets_type =='localbusiness') {
		function seopress_rich_snippets_local_business_option() {
			if (seopress_pro_rich_snippets_lb_img_option() !='') {
				$seopress_pro_rich_snippets_lb_img_option = json_encode(seopress_pro_rich_snippets_lb_img_option());
			}
			if (seopress_pro_rich_snippets_lb_name_option() !='') {
				$seopress_pro_rich_snippets_lb_name_option = json_encode(seopress_pro_rich_snippets_lb_name_option());
			}
			if (seopress_pro_rich_snippets_lb_type_option() !='') {
				$seopress_pro_rich_snippets_lb_type_option = json_encode(seopress_pro_rich_snippets_lb_type_option());
			}
			if (seopress_pro_rich_snippets_lb_street_addr_option() !='') {
				$seopress_pro_rich_snippets_lb_street_addr_option = json_encode(seopress_pro_rich_snippets_lb_street_addr_option());
			}
			if (seopress_pro_rich_snippets_lb_city_option() !='') {
				$seopress_pro_rich_snippets_lb_city_option = json_encode(seopress_pro_rich_snippets_lb_city_option());
			}
			if (seopress_pro_rich_snippets_lb_state_option() !='') {
				$seopress_pro_rich_snippets_lb_state_option = json_encode(seopress_pro_rich_snippets_lb_state_option());
			}
			if (seopress_pro_rich_snippets_lb_pc_option() !='') {
				$seopress_pro_rich_snippets_lb_pc_option = json_encode(seopress_pro_rich_snippets_lb_pc_option());
			}
			if (seopress_pro_rich_snippets_lb_country_option() !='') {
				$seopress_pro_rich_snippets_lb_country_option = json_encode(seopress_pro_rich_snippets_lb_country_option());
			}
			if (seopress_pro_rich_snippets_lb_lat_option() !='') {
				$seopress_pro_rich_snippets_lb_lat_option = json_encode(seopress_pro_rich_snippets_lb_lat_option());
			}
			if (seopress_pro_rich_snippets_lb_lon_option() !='') {
				$seopress_pro_rich_snippets_lb_lon_option = json_encode(seopress_pro_rich_snippets_lb_lon_option());
			}
			if (seopress_pro_rich_snippets_lb_website_option() !='') {
				$seopress_pro_rich_snippets_lb_website_option = json_encode(seopress_pro_rich_snippets_lb_website_option());
			}
			if (seopress_pro_rich_snippets_lb_tel_option() !='') {
				$seopress_pro_rich_snippets_lb_tel_option = json_encode(seopress_pro_rich_snippets_lb_tel_option());
			}
			if (seopress_pro_rich_snippets_lb_price_option() !='') {
				$seopress_pro_rich_snippets_lb_price_option = json_encode(seopress_pro_rich_snippets_lb_price_option());
			}
			if (seopress_pro_rich_snippets_lb_opening_hours_option() !='') {
				$days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

				$seopress_pro_rich_snippets_lb_opening_hours_option ='';
							
				foreach (seopress_pro_rich_snippets_lb_opening_hours_option() as $oh) {//OPENING HOURS
					foreach ($oh as $key => $day) {//DAY
						if(!array_key_exists('open', $day)) {//CLOSED?
							foreach ($day as $keys => $ampm) {//AM/PM
								if(array_key_exists('open', $ampm)) {//OPEN?
									
									$seopress_pro_rich_snippets_lb_opening_hours_option .= '{ ';
									$seopress_pro_rich_snippets_lb_opening_hours_option .= '"@type": "OpeningHoursSpecification",';
									$seopress_pro_rich_snippets_lb_opening_hours_option .= '"dayOfWeek": "'.$days[$key].'", ';

									foreach ($ampm as $_key => $value) {//HOURS
										if ($_key =='start') {//START AM/PM
											$seopress_pro_rich_snippets_lb_opening_hours_option .= '"opens": "';
											foreach ($value as $__key => $time) {
												$seopress_pro_rich_snippets_lb_opening_hours_option .= $time;
												if ($__key == 'hours') {
													$seopress_pro_rich_snippets_lb_opening_hours_option .= ':';
												}
											}
											$seopress_pro_rich_snippets_lb_opening_hours_option .= '",';
										}
										if ($_key =='end') {//CLOSE AM/PM
											$seopress_pro_rich_snippets_lb_opening_hours_option .= '"closes": "';
											foreach ($value as $__key => $time) {
												$seopress_pro_rich_snippets_lb_opening_hours_option .= $time;
												if ($__key == 'hours') {
													$seopress_pro_rich_snippets_lb_opening_hours_option .= ':';
												}
											}
											$seopress_pro_rich_snippets_lb_opening_hours_option .= '"';
										}
									}

									$seopress_pro_rich_snippets_lb_opening_hours_option .= '|';
								}
							}
						}
					}
				}
			}

			$html = '<script type="application/ld+json">';
			$html .= '{"@context" : "'.seopress_check_ssl().'schema.org","@type" : '.$seopress_pro_rich_snippets_lb_type_option.',';
			if (isset($seopress_pro_rich_snippets_lb_img_option)) {
				$html .= '"image": '.$seopress_pro_rich_snippets_lb_img_option.', ';
			}
			$html .= '"@id": '.json_encode(get_home_url()).',';

			if (isset($seopress_pro_rich_snippets_lb_street_addr_option) || isset($seopress_pro_rich_snippets_lb_city_option) || isset($seopress_pro_rich_snippets_lb_state_option) || isset($seopress_pro_rich_snippets_lb_pc_option) || isset($seopress_local_business_address_country_option)) {
				$html .= '"address": {
				    "@type": "PostalAddress",';
				    if (isset($seopress_pro_rich_snippets_lb_street_addr_option)) {
				    	$html .= '"streetAddress": '.$seopress_pro_rich_snippets_lb_street_addr_option.',';
					}
					if (isset($seopress_pro_rich_snippets_lb_city_option)) {
				    	$html .= '"addressLocality": '.$seopress_pro_rich_snippets_lb_city_option.',';
					}
					if (isset($seopress_pro_rich_snippets_lb_state_option)) {
				    	$html .= '"addressRegion": '.$seopress_pro_rich_snippets_lb_state_option.',';
				    }
				    if (isset($seopress_pro_rich_snippets_lb_pc_option)) {
				    	$html .= '"postalCode": '.$seopress_pro_rich_snippets_lb_pc_option.',';
					}
					if (isset($seopress_pro_rich_snippets_lb_country_option)) {
				    	$html .= '"addressCountry": '.$seopress_pro_rich_snippets_lb_country_option;
					}
			  	$html .= '},';
			}

			if (isset($seopress_pro_rich_snippets_lb_lat_option) || isset($seopress_pro_rich_snippets_lb_lon_option)) {
				$html .= '"geo": {
				    "@type": "GeoCoordinates",';
				    if (isset($seopress_pro_rich_snippets_lb_lat_option)) {
				    	$html .= '"latitude": '.$seopress_pro_rich_snippets_lb_lat_option.',';
					}
					if (isset($seopress_pro_rich_snippets_lb_lon_option)) {
				    	$html .= '"longitude": '.$seopress_pro_rich_snippets_lb_lon_option;
				    }
				$html .= '},';
			}

			if (isset($seopress_pro_rich_snippets_lb_website_option)) {
				$html .= '"url": '.$seopress_pro_rich_snippets_lb_website_option.',';
			}
			if (isset($seopress_pro_rich_snippets_lb_tel_option)) {
				$html .= '"telephone": '.$seopress_pro_rich_snippets_lb_tel_option.',';
			}
			if (isset($seopress_pro_rich_snippets_lb_price_option)) {
				$html .= '"priceRange": '.$seopress_pro_rich_snippets_lb_price_option.',';
			}
			if (isset($seopress_pro_rich_snippets_lb_opening_hours_option)) {
			 	$html .= '"openingHoursSpecification": [';
			 	
			 	$explode = array_filter(explode("|", $seopress_pro_rich_snippets_lb_opening_hours_option));
				$seopress_comma_count = count($explode);
				for ($i = 0; $i < $seopress_comma_count; $i++) {
					$html .= $explode[$i];
				   	if ($i < ($seopress_comma_count - 1)) {  		
				    	$html .= '}, ';
				   	} else {
				   		$html .= '} ';
				   	}
				}
				
				$html .= '],';
			}
			if (isset($seopress_pro_rich_snippets_lb_name_option)) {
				$html .= '"name": '.$seopress_pro_rich_snippets_lb_name_option;
			} else {
				$html .= '"name": "'.get_bloginfo('name').'"';
			}
			$html = trim($html, ',');
			$html .= '}';
			$html .= '</script>';
			$html .= "\n";

			$html = apply_filters('seopress_schemas_lb_html', $html);

			echo $html;
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_local_business_option', 3 );
		}
	}
	//FAQ
	//=========================================================================================
	if ($_seopress_pro_rich_snippets_type =='faq') {
		//FAQ JSON-LD
		function seopress_rich_snippets_faq_option() {
			//Question
			$seopress_pro_rich_snippets_faq     			= get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_faq');

	  		if (!empty($seopress_pro_rich_snippets_faq[0][0]["question"]) && !empty($seopress_pro_rich_snippets_faq[0][0]["answer"])) {
				//Init
	  			$seopress_pro_rich_snippets_faq_questions ='';
				$i = '0';
				$count = count($seopress_pro_rich_snippets_faq[0]);

				foreach ($seopress_pro_rich_snippets_faq[0] as $key => $value) {
					
					//Question + Answer
					if ($seopress_pro_rich_snippets_faq[0][$key]["question"] !='' && $seopress_pro_rich_snippets_faq[0][$key]["answer"] !='') {
						$seopress_pro_rich_snippets_faq_questions .= '{';
						$seopress_pro_rich_snippets_faq_questions .= '"@type": "Question",';
						$seopress_pro_rich_snippets_faq_questions .= '"name": '.json_encode($seopress_pro_rich_snippets_faq[0][$key]["question"]).',';
						$seopress_pro_rich_snippets_faq_questions .= '"answerCount": 1,';
						$seopress_pro_rich_snippets_faq_questions .= '"acceptedAnswer": {
		                "@type": "Answer",
		                "text": '.json_encode($seopress_pro_rich_snippets_faq[0][$key]["answer"]).'
		            	}';
		            	$seopress_pro_rich_snippets_faq_questions .= '}';
		            	if ($i < $count -1) {
		            		$seopress_pro_rich_snippets_faq_questions .= ',';
		            	}
					}
					$i++;
				}

				$html = '<script type="application/ld+json">';
				$html .= '{
					  "@context": "'.seopress_check_ssl().'schema.org",
					  "@type": "FAQPage",
					  "name": "FAQ",
					  "mainEntity": ['.$seopress_pro_rich_snippets_faq_questions.']
					}';
				$html .= '</script>';
				$html .= "\n";

				$html = apply_filters('seopress_schemas_faq_html', $html);

				echo $html;
			}
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_faq_option', 3 );
		}
	}
	//Courses
	//=========================================================================================
	//Title
	function seopress_rich_snippets_courses_title_option() {
		$_seopress_pro_rich_snippets_courses_title = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_courses_title',true);
		if ($_seopress_pro_rich_snippets_courses_title != '') {
			return $_seopress_pro_rich_snippets_courses_title;
		} else { //Default
			return the_title_attribute('echo=0');
		}
	}
	//Description
	function seopress_rich_snippets_courses_desc_option() {
		$_seopress_pro_rich_snippets_courses_desc = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_courses_desc',true);
		if ($_seopress_pro_rich_snippets_courses_desc != '') {
			return $_seopress_pro_rich_snippets_courses_desc;
		} else { //Default
			return wp_trim_words(esc_html(get_the_excerpt()), 30);
		}
	}
	//School
	function seopress_rich_snippets_courses_school_option() {
		$_seopress_pro_rich_snippets_courses_school = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_courses_school',true);
		if ($_seopress_pro_rich_snippets_courses_school != '') {
			return $_seopress_pro_rich_snippets_courses_school;
		} else { //Default
			return the_title_attribute('echo=0');
		}
	}
	//Website
	function seopress_rich_snippets_courses_website_option() {
		$_seopress_pro_rich_snippets_courses_website = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_courses_website',true);
		if ($_seopress_pro_rich_snippets_courses_website != '') {
			return $_seopress_pro_rich_snippets_courses_website;
		} else { //Default
			return the_title_attribute('echo=0');
		}
	}
	//Courses JSON-LD
	if ($_seopress_pro_rich_snippets_type =='courses') {
		function seopress_rich_snippets_courses_option() {
			$html = '<script type="application/ld+json">';
			$html .= '{
				  	"@context": "'.seopress_check_ssl().'schema.org",
				  	"@type": "Course",';
				  	if (seopress_rich_snippets_courses_title_option() !='') {
				  		$html .= '"name": '.json_encode(seopress_rich_snippets_courses_title_option()).',';
				  	}
				  	if (seopress_rich_snippets_courses_desc_option() !='') {
				  		$html .= '"description": '.json_encode(seopress_rich_snippets_courses_desc_option()).',';
				  	}
				  	if (seopress_rich_snippets_courses_school_option() !='') {
						$html .= '"provider": {
						    "@type": "Organization",
						    "name": '.json_encode(seopress_rich_snippets_courses_school_option()).',
						    "sameAs": '.json_encode(seopress_rich_snippets_courses_website_option()).'
						  }';
					}
				$html = trim($html, ',');
				$html .= '}';
			$html .= '</script>';
			$html .= "\n";

			$html = apply_filters('seopress_schemas_course_html', $html);

			echo $html;
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_courses_option', 3 );
		}
	}
	//Recipes
	//=========================================================================================
	//Recipe name
	function seopress_rich_snippets_recipes_name_option() {
		$_seopress_pro_rich_snippets_recipes_name = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_name',true);
		if ($_seopress_pro_rich_snippets_recipes_name != '') {
			return $_seopress_pro_rich_snippets_recipes_name;
		} else { //Default
			return the_title_attribute('echo=0');
		}
	}
	//Description
	function seopress_rich_snippets_recipes_desc_option() {
		$_seopress_pro_rich_snippets_recipes_desc = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_desc',true);
		if ($_seopress_pro_rich_snippets_recipes_desc != '') {
			return $_seopress_pro_rich_snippets_recipes_desc;
		} else { //Default
			return wp_trim_words(esc_html(get_the_excerpt()), 30);
		}
	}
	//Categories
	function seopress_rich_snippets_recipes_cat_option() {
		$_seopress_pro_rich_snippets_recipes_cat = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_cat',true);
		if ($_seopress_pro_rich_snippets_recipes_cat != '') {
			return $_seopress_pro_rich_snippets_recipes_cat;
		}
	}
	//Image
	function seopress_rich_snippets_recipes_img_option() {
		$_seopress_pro_rich_snippets_recipes_img = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_img',true);
		if ($_seopress_pro_rich_snippets_recipes_img != '') {
			return $_seopress_pro_rich_snippets_recipes_img;
		}
	}
	//Prep Time
	function seopress_rich_snippets_recipes_prep_time_option() {
		$_seopress_pro_rich_snippets_recipes_prep_time = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_prep_time',true);
		if ($_seopress_pro_rich_snippets_recipes_prep_time != '') {
			return $_seopress_pro_rich_snippets_recipes_prep_time;
		}
	}
	//Cook Time
	function seopress_rich_snippets_recipes_cook_time_option() {
		$_seopress_pro_rich_snippets_recipes_cook_time = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_cook_time',true);
		if ($_seopress_pro_rich_snippets_recipes_cook_time != '') {
			return $_seopress_pro_rich_snippets_recipes_cook_time;
		}
	}
	//Total Time
	function seopress_rich_snippets_recipes_total_time_option() {
		$seopress_pro_rich_snippets_recipes_total_time = seopress_rich_snippets_recipes_cook_time_option() + seopress_rich_snippets_recipes_prep_time_option();
		return $seopress_pro_rich_snippets_recipes_total_time;
	}
	//Calories
	function seopress_rich_snippets_recipes_calories_option() {
		$_seopress_pro_rich_snippets_recipes_calories = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_calories',true);
		if ($_seopress_pro_rich_snippets_recipes_calories != '') {
			return $_seopress_pro_rich_snippets_recipes_calories;
		}
	}
	//Yield
	function seopress_rich_snippets_recipes_yield_option() {
		$_seopress_pro_rich_snippets_recipes_yield = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_yield',true);
		if ($_seopress_pro_rich_snippets_recipes_yield != '') {
			return $_seopress_pro_rich_snippets_recipes_yield;
		}
	}
	//Keywords
	function seopress_rich_snippets_recipes_keywords_option() {
		$_seopress_pro_rich_snippets_recipes_keywords = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_keywords',true);
		if ($_seopress_pro_rich_snippets_recipes_keywords != '') {
			return $_seopress_pro_rich_snippets_recipes_keywords;
		}
	}
	//Recipe Cuisine
	function seopress_rich_snippets_recipes_cuisine_option() {
		$_seopress_pro_rich_snippets_recipes_cuisine = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_cuisine',true);
		if ($_seopress_pro_rich_snippets_recipes_cuisine != '') {
			return $_seopress_pro_rich_snippets_recipes_cuisine;
		}
	}
	//Recipe Ingredients
	function seopress_rich_snippets_recipes_ingredient_option() {
		$_seopress_pro_rich_snippets_recipes_ingredient = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_ingredient',true);
		if ($_seopress_pro_rich_snippets_recipes_ingredient != '') {
			return $_seopress_pro_rich_snippets_recipes_ingredient;
		}
	}
	//Recipe Instructions
	function seopress_rich_snippets_recipes_instructions_option() {
		$_seopress_pro_rich_snippets_recipes_instructions = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_recipes_instructions',true);
		if ($_seopress_pro_rich_snippets_recipes_instructions != '') {
			return $_seopress_pro_rich_snippets_recipes_instructions;
		}
	}
	//Recipes JSON-LD
	if ($_seopress_pro_rich_snippets_type =='recipes') {
		function seopress_rich_snippets_recipes_option() {
			$html = '<script type="application/ld+json">';
			$html .= '{
			      	"@context": "'.seopress_check_ssl().'schema.org/",';
			      	$sp_recipe = '"@type": "Recipe",';
			      	
			      	if (seopress_rich_snippets_recipes_name_option() !='') {
			      		$sp_recipe .= '"name": '.json_encode(seopress_rich_snippets_recipes_name_option()).',';
			      	}
			      	if (seopress_rich_snippets_recipes_cat_option() !='') {
			      		$sp_recipe .= '"recipeCategory": '.json_encode(seopress_rich_snippets_recipes_cat_option()).',';
			      	}
			      	if (seopress_rich_snippets_recipes_img_option() !='') {
			      		$sp_recipe .= '"image": '.json_encode(seopress_rich_snippets_recipes_img_option()).',';
			      	}
			      	if (get_the_author()) {
				      	$sp_recipe .= '"author": {
				      		"@type": "Person",
				      		"name": '.json_encode(get_the_author()).'
				     	},';
			     	}
			     	if (get_the_date()) {
			     		$sp_recipe .= '"datePublished": "'.get_the_date('Y-m-j').'",';
			     	}
			     	if (seopress_rich_snippets_recipes_desc_option() !='') {
			     		$sp_recipe .= '"description": '.json_encode(seopress_rich_snippets_recipes_desc_option()).',';
			     	}
			     	if (seopress_rich_snippets_recipes_prep_time_option()) {
			     		$sp_recipe .= '"prepTime": '.json_encode('PT'.seopress_rich_snippets_recipes_prep_time_option().'M').',';
			     	}
			     	if (seopress_rich_snippets_recipes_total_time_option() !='') {
			     		$sp_recipe .= '"totalTime": '.json_encode('PT'.seopress_rich_snippets_recipes_total_time_option().'M').',';
			     	}
			     	if (seopress_rich_snippets_recipes_yield_option() !='') {
			     		$sp_recipe .= '"recipeYield": '.json_encode(seopress_rich_snippets_recipes_yield_option()).',';
			     	}
			     	if (seopress_rich_snippets_recipes_keywords_option() !='') {
			     		$sp_recipe .= '"keywords": '.json_encode(seopress_rich_snippets_recipes_keywords_option()).',';
			     	}
			     	if (seopress_rich_snippets_recipes_cuisine_option() !='') {
			     		$sp_recipe .= '"recipeCuisine": '.json_encode(seopress_rich_snippets_recipes_cuisine_option()).',';
			     	}
			     	if (seopress_rich_snippets_recipes_ingredient_option() !='') {
						$recipes_ingredient = preg_split('/\r\n|[\r\n]/', seopress_rich_snippets_recipes_ingredient_option());
						if(!empty($recipes_ingredient)) {
							$i = '0';
							$count = count($recipes_ingredient);

							$sp_recipe .= '"recipeIngredient": [';
							foreach($recipes_ingredient as $value) {
								$sp_recipe .= json_encode($value);
								if ($i < $count -1) {
									$sp_recipe .= ',';
								}
								$i++;
							}
							$sp_recipe .= '],';
						}
					}
			     	if (seopress_rich_snippets_recipes_instructions_option() !='') {
						$recipes_instructions = preg_split('/\r\n|[\r\n]/', seopress_rich_snippets_recipes_instructions_option());
						if(!empty($recipes_instructions)) {
							$i = '0';
							$count = count($recipes_instructions);

							$sp_recipe .= '"recipeInstructions": [';
							foreach($recipes_instructions as $value) {
								$sp_recipe .= '{"@type": "HowToStep","text":'.json_encode($value).'}';
								if ($i < $count -1) {
									$sp_recipe .= ',';
								}
								$i++;
							}
							$sp_recipe .= '],';
						}
					}
			     	if (seopress_rich_snippets_recipes_calories_option() !='') {
				     	$sp_recipe .= '"nutrition": {
				       		"@type": "NutritionInformation",
				       		"calories": '.json_encode(seopress_rich_snippets_recipes_calories_option()).'
				    	}';
				    }
				$sp_recipe = trim($sp_recipe, ',');
			    $sp_recipe .= '}';
			    $html .= $sp_recipe;
			$html .= '</script>';
			$html .= "\n";

			$html = apply_filters('seopress_schemas_recipe_html', $html);

			echo $html;
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_recipes_option', 3 );
		}
	}
	//Jobs
	//=========================================================================================
	//Job title
	function seopress_pro_rich_snippets_jobs_name_option() {
		$_seopress_pro_rich_snippets_jobs_name = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_name',true);
		if ($_seopress_pro_rich_snippets_jobs_name != '') {
			return $_seopress_pro_rich_snippets_jobs_name;
		}
	}
	//Job description
	function seopress_pro_rich_snippets_jobs_desc_option() {
		$_seopress_pro_rich_snippets_jobs_desc = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_desc',true);
		if ($_seopress_pro_rich_snippets_jobs_desc != '') {
			return $_seopress_pro_rich_snippets_jobs_desc;
		}
	}
	//Job date posted
	function seopress_pro_rich_snippets_jobs_date_posted_option() {
		$_seopress_pro_rich_snippets_jobs_date_posted = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_date_posted',true);
		if ($_seopress_pro_rich_snippets_jobs_date_posted != '') {
			return $_seopress_pro_rich_snippets_jobs_date_posted;
		}
	}
	//Job date posted
	function seopress_pro_rich_snippets_jobs_valid_through_option() {
		$_seopress_pro_rich_snippets_jobs_valid_through = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_valid_through',true);
		if ($_seopress_pro_rich_snippets_jobs_valid_through != '') {
			return $_seopress_pro_rich_snippets_jobs_valid_through;
		}
	}
	//Job date posted
	function seopress_pro_rich_snippets_jobs_employment_type_option() {
		$_seopress_pro_rich_snippets_jobs_employment_type = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_employment_type',true);
		if ($_seopress_pro_rich_snippets_jobs_employment_type != '') {
			return $_seopress_pro_rich_snippets_jobs_employment_type;
		}
	}
	//Job ID name
	function seopress_pro_rich_snippets_jobs_identifier_name_option() {
		$_seopress_pro_rich_snippets_jobs_identifier_name = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_identifier_name',true);
		if ($_seopress_pro_rich_snippets_jobs_identifier_name != '') {
			return $_seopress_pro_rich_snippets_jobs_identifier_name;
		}
	}
	//Job ID value
	function seopress_pro_rich_snippets_jobs_identifier_value_option() {
		$_seopress_pro_rich_snippets_jobs_identifier_value = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_identifier_value',true);
		if ($_seopress_pro_rich_snippets_jobs_identifier_value != '') {
			return $_seopress_pro_rich_snippets_jobs_identifier_value;
		}
	}
	//Job hiring organization
	function seopress_pro_rich_snippets_jobs_hiring_organization_default_name_option() {
		$seopress_local_business_img_option = get_option("seopress_social_option_name");
		if ( ! empty ( $seopress_local_business_img_option ) ) {
			foreach ($seopress_local_business_img_option as $key => $seopress_local_business_img_value)
				$options[$key] = $seopress_local_business_img_value;
			if (isset($seopress_local_business_img_option['seopress_social_knowledge_name'])) { 
				return $seopress_local_business_img_option['seopress_social_knowledge_name'];
			}
		}
	}
	function seopress_pro_rich_snippets_jobs_hiring_organization_default_logo_option() {
		$seopress_local_business_img_option = get_option("seopress_social_option_name");
		if ( ! empty ( $seopress_local_business_img_option ) ) {
			foreach ($seopress_local_business_img_option as $key => $seopress_local_business_img_value)
				$options[$key] = $seopress_local_business_img_value;
			if (isset($seopress_local_business_img_option['seopress_social_knowledge_img'])) { 
				return $seopress_local_business_img_option['seopress_social_knowledge_img'];
			}
		}
	}
	function seopress_pro_rich_snippets_jobs_hiring_organization_option() {
		$_seopress_pro_rich_snippets_jobs_hiring_organization = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_hiring_organization',true);
		if ($_seopress_pro_rich_snippets_jobs_hiring_organization != '') {
			return $_seopress_pro_rich_snippets_jobs_hiring_organization;
		} elseif (seopress_pro_rich_snippets_jobs_hiring_organization_default_name_option() !='') {
			return seopress_pro_rich_snippets_jobs_hiring_organization_default_name_option();
		}
	}
	//Job hiring same as
	function seopress_pro_rich_snippets_jobs_hiring_same_as_option() {
		$_seopress_pro_rich_snippets_jobs_hiring_same_as = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_hiring_same_as',true);
		if ($_seopress_pro_rich_snippets_jobs_hiring_same_as != '') {
			return $_seopress_pro_rich_snippets_jobs_hiring_same_as;
		} else {
			return get_home_url();
		}
	}
	//Job hiring logo
	function seopress_pro_rich_snippets_jobs_hiring_logo_option() {
		$_seopress_pro_rich_snippets_jobs_hiring_logo = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_hiring_logo',true);
		if ($_seopress_pro_rich_snippets_jobs_hiring_logo != '') {
			return $_seopress_pro_rich_snippets_jobs_hiring_logo;
		} elseif (seopress_pro_rich_snippets_jobs_hiring_organization_default_logo_option() !='') {
			return seopress_pro_rich_snippets_jobs_hiring_organization_default_logo_option();
		}
	}
	//Job hiring logo width
	function seopress_pro_rich_snippets_jobs_hiring_logo_width_option() {
		$_seopress_pro_rich_snippets_jobs_hiring_logo_width = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_hiring_logo_width',true);
		if ($_seopress_pro_rich_snippets_jobs_hiring_logo_width != '') {
			return $_seopress_pro_rich_snippets_jobs_hiring_logo_width;
		}
	}
	//Job hiring logo height
	function seopress_pro_rich_snippets_jobs_hiring_logo_height_option() {
		$_seopress_pro_rich_snippets_jobs_hiring_logo_height = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_hiring_logo_height',true);
		if ($_seopress_pro_rich_snippets_jobs_hiring_logo_height != '') {
			return $_seopress_pro_rich_snippets_jobs_hiring_logo_height;
		}
	}
	//Job street address
	function seopress_pro_rich_snippets_jobs_address_street_option() {
		$_seopress_pro_rich_snippets_jobs_address_street = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_address_street',true);
		if ($_seopress_pro_rich_snippets_jobs_address_street != '') {
			return $_seopress_pro_rich_snippets_jobs_address_street;
		}
	}
	//Job address locality
	function seopress_pro_rich_snippets_jobs_address_locality_option() {
		$_seopress_pro_rich_snippets_jobs_address_locality = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_address_locality',true);
		if ($_seopress_pro_rich_snippets_jobs_address_locality != '') {
			return ", ".$_seopress_pro_rich_snippets_jobs_address_locality;
		}
	}
	//Job address region
	function seopress_pro_rich_snippets_jobs_address_region_option() {
		$_seopress_pro_rich_snippets_jobs_address_region = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_address_region',true);
		if ($_seopress_pro_rich_snippets_jobs_address_region != '') {
			return $_seopress_pro_rich_snippets_jobs_address_region;
		}
	}
	//Job postal code
	function seopress_pro_rich_snippets_jobs_postal_code_option() {
		$_seopress_pro_rich_snippets_jobs_postal_code = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_postal_code',true);
		if ($_seopress_pro_rich_snippets_jobs_postal_code != '') {
			return $_seopress_pro_rich_snippets_jobs_postal_code;
		}
	}
	//Job country
	function seopress_pro_rich_snippets_jobs_country_option() {
		$_seopress_pro_rich_snippets_jobs_country = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_country',true);
		if ($_seopress_pro_rich_snippets_jobs_country != '') {
			return $_seopress_pro_rich_snippets_jobs_country;
		}
	}
	//Job remote
	function seopress_pro_rich_snippets_jobs_remote_option() {
		$_seopress_pro_rich_snippets_jobs_remote = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_remote',true);
		if ($_seopress_pro_rich_snippets_jobs_remote != '') {
			return $_seopress_pro_rich_snippets_jobs_remote;
		}
	}
	//Job salary
	function seopress_pro_rich_snippets_jobs_salary_option() {
		$_seopress_pro_rich_snippets_jobs_salary = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_salary',true);
		if ($_seopress_pro_rich_snippets_jobs_salary != '') {
			return $_seopress_pro_rich_snippets_jobs_salary;
		}
	}
	//Job salary currency
	function seopress_pro_rich_snippets_jobs_salary_currency_option() {
		$_seopress_pro_rich_snippets_jobs_salary_currency = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_salary_currency',true);
		if ($_seopress_pro_rich_snippets_jobs_salary_currency != '') {
			return $_seopress_pro_rich_snippets_jobs_salary_currency;
		}
	}
	//Job salary unit
	function seopress_pro_rich_snippets_jobs_salary_unit_option() {
		$_seopress_pro_rich_snippets_jobs_salary_unit = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_jobs_salary_unit',true);
		if ($_seopress_pro_rich_snippets_jobs_salary_unit != '') {
			return $_seopress_pro_rich_snippets_jobs_salary_unit;
		}
	}
	//Jobs JSON-LD
	if ($_seopress_pro_rich_snippets_type =='jobs') {
		function seopress_rich_snippets_jobs_option() {
			$html = '<script type="application/ld+json">';
			$html .= '{
			      	"@context": "'.seopress_check_ssl().'schema.org/",';
			      	$sp_job = '"@type": "JobPosting",';
			      	
			      	if (seopress_pro_rich_snippets_jobs_name_option() !='') {
			      		$sp_job .= '"title": '.json_encode(seopress_pro_rich_snippets_jobs_name_option()).',';
			      	}
			      	if (seopress_pro_rich_snippets_jobs_desc_option() !='') {
			      		$sp_job .= '"description": '.json_encode(seopress_pro_rich_snippets_jobs_desc_option()).',';
					}
					if (seopress_pro_rich_snippets_jobs_identifier_name_option() !='' && seopress_pro_rich_snippets_jobs_identifier_value_option() !='') {
						$sp_job .= '"identifier": {
							"@type": "PropertyValue",
							"name": '.json_encode(seopress_pro_rich_snippets_jobs_identifier_name_option()).',
							"value": '.json_encode(seopress_pro_rich_snippets_jobs_identifier_value_option()).'
						},';
					}
					if (seopress_pro_rich_snippets_jobs_date_posted_option() !='') {
						$sp_job .= '"datePosted": '.json_encode(seopress_pro_rich_snippets_jobs_date_posted_option()).',';
					}
					if (seopress_pro_rich_snippets_jobs_valid_through_option() !='') {
						$sp_job .= '"validThrough": '.json_encode(seopress_pro_rich_snippets_jobs_valid_through_option()).',';
					}
					if (seopress_pro_rich_snippets_jobs_employment_type_option() !='') {
						$sp_job .= '"employmentType": '.json_encode(seopress_pro_rich_snippets_jobs_employment_type_option()).',';
					}
					if (seopress_pro_rich_snippets_jobs_hiring_organization_option() !='' && seopress_pro_rich_snippets_jobs_hiring_same_as_option() !='' && seopress_pro_rich_snippets_jobs_hiring_logo_option() !='') {
						$sp_job .= '"hiringOrganization" : {
							"@type" : "Organization",
							"name" : '.json_encode(seopress_pro_rich_snippets_jobs_hiring_organization_option()).',
							"sameAs" : '.json_encode(seopress_pro_rich_snippets_jobs_hiring_same_as_option()).',
							"logo" : '.json_encode(seopress_pro_rich_snippets_jobs_hiring_logo_option()).'
						  },';
					}
					if (seopress_pro_rich_snippets_jobs_address_street_option() !='' || seopress_pro_rich_snippets_jobs_address_locality_option() !='' || seopress_pro_rich_snippets_jobs_address_region_option() !='' || seopress_pro_rich_snippets_jobs_postal_code_option() !='' || seopress_pro_rich_snippets_jobs_country_option() !='') {
						$sp_job .= '"jobLocation": {
							"@type": "Place",
								"address": {
								"@type": "PostalAddress",';
								if (seopress_pro_rich_snippets_jobs_address_street_option() !='') {
									$sp_job .= '"streetAddress": '.json_encode(seopress_pro_rich_snippets_jobs_address_street_option()).',';
								}
								if (seopress_pro_rich_snippets_jobs_address_locality_option() !='') {
									$sp_job .= '"addressLocality": '.json_encode(seopress_pro_rich_snippets_jobs_address_locality_option()).',';
								}
								if (seopress_pro_rich_snippets_jobs_address_region_option() !='') {
									$sp_job .= '"addressRegion": '.json_encode(seopress_pro_rich_snippets_jobs_address_region_option()).',';
								}
								if (seopress_pro_rich_snippets_jobs_postal_code_option() !='') {
									$sp_job .= '"postalCode": '.json_encode(seopress_pro_rich_snippets_jobs_postal_code_option()).',';
								}
								if (seopress_pro_rich_snippets_jobs_country_option() !='') {
									$sp_job .= '"addressCountry": '.json_encode(seopress_pro_rich_snippets_jobs_country_option());
								}
							$sp_job .= '}
							},';
					}
					if (seopress_pro_rich_snippets_jobs_remote_option() !='' && seopress_pro_rich_snippets_jobs_country_option() !='') {
						$sp_job .= '"jobLocationType": "TELECOMMUTE",';
					}
					if (seopress_pro_rich_snippets_jobs_salary_option() !='' && seopress_pro_rich_snippets_jobs_salary_currency_option() !='' && seopress_pro_rich_snippets_jobs_salary_unit_option() !='') {
						$sp_job .= '"baseSalary": {
							"@type": "MonetaryAmount",
							"currency": '.json_encode(seopress_pro_rich_snippets_jobs_salary_currency_option()).',
							"value": {
							  "@type": "QuantitativeValue",
							  "value": '.json_encode(seopress_pro_rich_snippets_jobs_salary_option()).',
							  "unitText": '.json_encode(seopress_pro_rich_snippets_jobs_salary_unit_option()).'
							}
						  }';
					}
				$sp_job = trim($sp_job, ',');
			    $sp_job .= '}';
			    $html .= $sp_job;
			$html .= '</script>';
			$html .= "\n";

			$html = apply_filters('seopress_schemas_job_html', $html);

			echo $html;
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_jobs_option', 3 );
		}
	}
	//Videos
	//=========================================================================================
	//Video name
	function seopress_rich_snippets_videos_name_option() {
		$_seopress_pro_rich_snippets_videos_name = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_videos_name',true);
		if ($_seopress_pro_rich_snippets_videos_name != '') {
			return $_seopress_pro_rich_snippets_videos_name;
		} else { //Default
			return the_title_attribute('echo=0');
		}
	}
	//Description
	function seopress_rich_snippets_videos_desc_option() {
		$_seopress_pro_rich_snippets_videos_description = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_videos_description',true);
		if ($_seopress_pro_rich_snippets_videos_description != '') {
			return $_seopress_pro_rich_snippets_videos_description;
		} else { //Default
			return wp_trim_words(esc_html(get_the_excerpt()), 30);
		}
	}
	//Thumbnail
	function seopress_rich_snippets_videos_img_option() {
		$_seopress_pro_rich_snippets_videos_img = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_videos_img',true);
		if ($_seopress_pro_rich_snippets_videos_img != '') {
			return $_seopress_pro_rich_snippets_videos_img;
		}
	}
	//Thumbnail width
	function seopress_rich_snippets_videos_img_width_option() {
		$_seopress_pro_rich_snippets_videos_img_width = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_videos_img_width',true);
		if ($_seopress_pro_rich_snippets_videos_img_width != '') {
			return $_seopress_pro_rich_snippets_videos_img_width;
		}
	}
	//Thumbnail Height
	function seopress_rich_snippets_videos_img_height_option() {
		$_seopress_pro_rich_snippets_videos_img_height = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_videos_img_height',true);
		if ($_seopress_pro_rich_snippets_videos_img_height != '') {
			return $_seopress_pro_rich_snippets_videos_img_height;
		}
	}
	//Duration
	function seopress_rich_snippets_videos_duration_option() {
		$_seopress_pro_rich_snippets_videos_duration = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_videos_duration',true);
		if ($_seopress_pro_rich_snippets_videos_duration != '') {
			return 'PT'.$_seopress_pro_rich_snippets_videos_duration.'M';
		}
	}
	//URL
	function seopress_rich_snippets_videos_url_option() {
		$_seopress_pro_rich_snippets_videos_url = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_videos_url',true);
		if ($_seopress_pro_rich_snippets_videos_url != '') {
			return $_seopress_pro_rich_snippets_videos_url;
		}
	}
	//Publisher name
	function seopress_rich_snippets_videos_publisher_option() {
		$seopress_rich_snippets_videos_publisher_option = get_option("seopress_social_option_name");
		if ( ! empty ( $seopress_rich_snippets_videos_publisher_option ) ) {
			foreach ($seopress_rich_snippets_videos_publisher_option as $key => $seopress_rich_snippets_videos_publisher_value)
				$options[$key] = $seopress_rich_snippets_videos_publisher_value;
			 if (isset($seopress_rich_snippets_videos_publisher_option['seopress_social_knowledge_name'])) { 
			 	return $seopress_rich_snippets_videos_publisher_option['seopress_social_knowledge_name'];
			 }
		}
	}
	//Publisher Logo
	function seopress_rich_snippets_videos_publisher_logo_option() {
		$seopress_local_business_img_option = get_option("seopress_social_option_name");
		if ( ! empty ( $seopress_local_business_img_option ) ) {
			foreach ($seopress_local_business_img_option as $key => $seopress_local_business_img_value)
				$options[$key] = $seopress_local_business_img_value;
			 if (isset($seopress_local_business_img_option['seopress_social_knowledge_img'])) { 
			 	return $seopress_local_business_img_option['seopress_social_knowledge_img'];
			 }
		}
	}
	//Videos JSON-LD
	if ($_seopress_pro_rich_snippets_type =='videos') {
		function seopress_rich_snippets_videos_option() {
			$html = '<script type="application/ld+json">';
			$html .= '{
					"@context": "'.seopress_check_ssl().'schema.org",
					"@type": "VideoObject",';
					if (seopress_rich_snippets_videos_name_option() !='') {
						$html .= '"name": '.json_encode(seopress_rich_snippets_videos_name_option()).',';
					}
					if (seopress_rich_snippets_videos_desc_option() !='') {
						$html .= '"description": '.json_encode(seopress_rich_snippets_videos_desc_option()).',';
					}
					if (seopress_rich_snippets_videos_img_option() !='') {
						$html .= '"thumbnailUrl": '.json_encode(seopress_rich_snippets_videos_img_option()).',';
					}
					if (get_the_date()) {
						$html .= '"uploadDate": "'.get_the_date('c').'",';
					}
					if (seopress_rich_snippets_videos_duration_option() !='') {
						$html .= '"duration": '.json_encode(seopress_rich_snippets_videos_duration_option()).',';
					}
					if (seopress_rich_snippets_videos_publisher_option() !='') {
						$html .= '"publisher": {
							"@type": "Organization",
							"name": '.json_encode(seopress_rich_snippets_videos_publisher_option()).',
							"logo": {
								"@type": "ImageObject",
								"url": '.json_encode(seopress_rich_snippets_videos_publisher_logo_option()).'
							}
						},';
					}
					if (seopress_rich_snippets_videos_url_option() !='') {
						$html .= '"contentUrl": '.json_encode(seopress_rich_snippets_videos_url_option()).',
						"embedUrl": '.json_encode(seopress_rich_snippets_videos_url_option()).'';
					}
				$html = trim($html, ',');
				$html .= '}';
			$html .= '</script>';
			$html .= "\n";

			$html = apply_filters('seopress_schemas_video_html', $html);

			echo $html;
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_videos_option', 3 );
		}
	}
	//Events
	//=========================================================================================
	//Event type
	function seopress_rich_snippets_events_type_option() {
		$_seopress_pro_rich_snippets_events_type = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_type',true);
		if ($_seopress_pro_rich_snippets_events_type != '') {
			return $_seopress_pro_rich_snippets_events_type;
		}
	}
	//Event name
	function seopress_rich_snippets_events_name_option() {
		$_seopress_pro_rich_snippets_events_name = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_name',true);
		if ($_seopress_pro_rich_snippets_events_name != '') {
			return $_seopress_pro_rich_snippets_events_name;
		} else { //Default
			return the_title_attribute('echo=0');
		}
	}
	//Event Description
	function seopress_rich_snippets_events_description_option() {
		$_seopress_pro_rich_snippets_events_description = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_desc',true);
		if ($_seopress_pro_rich_snippets_events_description != '') {
			return $_seopress_pro_rich_snippets_events_description;
		} else { //Default
			return wp_trim_words(esc_html(get_the_excerpt()), 30);
		}
	}
	//Event Thumbnail
	function seopress_rich_snippets_events_img_option() {
		$_seopress_pro_rich_snippets_events_img = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_img',true);
		if ($_seopress_pro_rich_snippets_events_img != '') {
			return $_seopress_pro_rich_snippets_events_img;
		}
	}
	//Start Date
	function seopress_rich_snippets_events_start_date_option() {
		$_seopress_pro_rich_snippets_events_start_date = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_start_date',true);
		if ($_seopress_pro_rich_snippets_events_start_date != '') {
			return $_seopress_pro_rich_snippets_events_start_date;
		}
	}
	//Start time
	function seopress_rich_snippets_events_start_time_option() {
		$_seopress_pro_rich_snippets_events_start_time = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_start_time',true);
		if ($_seopress_pro_rich_snippets_events_start_time != '') {
			return $_seopress_pro_rich_snippets_events_start_time;
		}
	}
	//Start time + Start date
	function seopress_rich_snippets_events_date_time_start_option() {
		if (seopress_rich_snippets_events_start_date_option() !='' && seopress_rich_snippets_events_start_time_option() !='' ) {
			return seopress_rich_snippets_events_start_date_option().'T'.seopress_rich_snippets_events_start_time_option();
		} else {
			return seopress_rich_snippets_events_start_date_option();
		}
	}
	//End Date
	function seopress_rich_snippets_events_end_date_option() {
		$_seopress_pro_rich_snippets_events_end_date = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_end_date',true);
		if ($_seopress_pro_rich_snippets_events_end_date != '') {
			return $_seopress_pro_rich_snippets_events_end_date;
		}
	}
	//End time
	function seopress_rich_snippets_events_end_time_option() {
		$_seopress_pro_rich_snippets_events_end_time = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_end_time',true);
		if ($_seopress_pro_rich_snippets_events_end_time != '') {
			return $_seopress_pro_rich_snippets_events_end_time;
		}
	}
	//End time + End date
	function seopress_rich_snippets_events_date_time_end_option() {
		if (seopress_rich_snippets_events_end_date_option() !='' && seopress_rich_snippets_events_end_time_option() !='' ) {
			return seopress_rich_snippets_events_end_date_option().'T'.seopress_rich_snippets_events_end_time_option();
		} else {
			return seopress_rich_snippets_events_end_date_option();
		}
	}
	//Location name
	function seopress_rich_snippets_events_location_name_option() {
		$_seopress_pro_rich_snippets_events_location_name = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_location_name',true);
		if ($_seopress_pro_rich_snippets_events_location_name != '') {
			return $_seopress_pro_rich_snippets_events_location_name;
		}
	}
	//Location URL
	function seopress_rich_snippets_events_location_url_option() {
		$_seopress_pro_rich_snippets_events_location_url = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_location_url',true);
		if ($_seopress_pro_rich_snippets_events_location_url != '') {
			return $_seopress_pro_rich_snippets_events_location_url;
		}
	}
	//Location Address
	function seopress_rich_snippets_events_location_address_option() {
		$_seopress_pro_rich_snippets_events_location_address = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_location_address',true);
		if ($_seopress_pro_rich_snippets_events_location_address != '') {
			return $_seopress_pro_rich_snippets_events_location_address;
		}
	}
	//Offer name
	function seopress_rich_snippets_events_offers_name_option() {
		$_seopress_pro_rich_snippets_events_offers_name = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_offers_name',true);
		if ($_seopress_pro_rich_snippets_events_offers_name != '') {
			return $_seopress_pro_rich_snippets_events_offers_name;
		}
	}
	//Offer category
	function seopress_rich_snippets_events_offers_cat_option() {
		$_seopress_pro_rich_snippets_events_offers_cat = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_offers_cat',true);
		if ($_seopress_pro_rich_snippets_events_offers_cat != '') {
			return $_seopress_pro_rich_snippets_events_offers_cat;
		}
	}
	//Offer price
	function seopress_rich_snippets_events_offers_price_option() {
		$_seopress_pro_rich_snippets_events_offers_price = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_offers_price',true);
		if ($_seopress_pro_rich_snippets_events_offers_price != '') {
			return $_seopress_pro_rich_snippets_events_offers_price;
		}
	}
	//Offer price currency
	function seopress_rich_snippets_events_offers_price_currency_option() {
		$_seopress_pro_rich_snippets_events_offers_price_currency = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_offers_price_currency',true);
		if ($_seopress_pro_rich_snippets_events_offers_price_currency != '') {
			return $_seopress_pro_rich_snippets_events_offers_price_currency;
		}
	}
	//Offer availability
	function seopress_rich_snippets_events_offers_availability_option() {
		$_seopress_pro_rich_snippets_events_offers_availability = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_offers_availability',true);
		if ($_seopress_pro_rich_snippets_events_offers_availability != '') {
			return $_seopress_pro_rich_snippets_events_offers_availability;
		}
	}
	//Offer ValidFrom Date
	function seopress_rich_snippets_events_offers_valid_from_date_option() {
		$seopress_rich_snippets_events_offers_valid_from_date = get_post_meta(get_the_ID(),'_seopress_rich_snippets_events_offers_valid_from_date',true);
		if ($seopress_rich_snippets_events_offers_valid_from_date != '') {
			return $seopress_rich_snippets_events_offers_valid_from_date;
		}
	}
	//Offer ValidFrom Time
	function seopress_rich_snippets_events_offers_valid_from_time_option() {
		$seopress_rich_snippets_events_offers_valid_from_time = get_post_meta(get_the_ID(),'_seopress_rich_snippets_events_offers_valid_from_time',true);
		if ($seopress_rich_snippets_events_offers_valid_from_time != '') {
			return $seopress_rich_snippets_events_offers_valid_from_time;
		}
	}
	//Offer ValidFrom Date+Time+Timezone
	function seopress_rich_snippets_events_offers_valid_from() {
		if (seopress_rich_snippets_events_offers_valid_from_date_option() !='' && seopress_rich_snippets_events_offers_valid_from_time_option() !='') {
			$date = seopress_rich_snippets_events_offers_valid_from_date_option().'T'.seopress_rich_snippets_events_offers_valid_from_time_option();
		
			if (get_option('gmt_offset') !='') {
				$timezone = sprintf("%+d",get_option('gmt_offset'));
				$date = $date.$timezone.':00';
			}
			return $date;
		}
	}

	//Offer URL
	function seopress_rich_snippets_events_offers_url_option() {
		$_seopress_pro_rich_snippets_events_offers_url = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_offers_url',true);
		if ($_seopress_pro_rich_snippets_events_offers_url != '') {
			return $_seopress_pro_rich_snippets_events_offers_url;
		}
	}
	//Performer name
	function seopress_pro_rich_snippets_events_performer_option() {
		$_seopress_pro_rich_snippets_events_performer_option = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_events_performer',true);
		if ($_seopress_pro_rich_snippets_events_performer_option != '') {
			return $_seopress_pro_rich_snippets_events_performer_option;
		}
	}
	//Events JSON-LD
	if ($_seopress_pro_rich_snippets_type =='events') {
		function seopress_rich_snippets_events_option() {
			$html = '<script type="application/ld+json">';
			$html .= '{
					"@context": "'.seopress_check_ssl().'schema.org",';
					if (seopress_rich_snippets_events_type_option() !='') {
						$html .= '"@type": '.json_encode(seopress_rich_snippets_events_type_option()).',';
					}
					if (seopress_rich_snippets_events_name_option() !='') {
						$html .= '"name": '.json_encode(seopress_rich_snippets_events_name_option()).',';
					}
					if (seopress_rich_snippets_events_description_option() !='') {
						$html .= '"description": '.json_encode(seopress_rich_snippets_events_description_option()).',';
					}
					if (seopress_rich_snippets_events_img_option() !='') {
						$html .= '"image": '.json_encode(seopress_rich_snippets_events_img_option()).',';
					}
					if (seopress_rich_snippets_events_location_url_option() !='') {
						$html .= '"url": '.json_encode(seopress_rich_snippets_events_location_url_option()).',';
					}
					if (seopress_rich_snippets_events_date_time_start_option() !='') {
						$html .= '"startDate": '.json_encode(seopress_rich_snippets_events_date_time_start_option()).',';
					}
					if (seopress_rich_snippets_events_date_time_end_option() !='') {
						$html .= '"endDate": '.json_encode(seopress_rich_snippets_events_date_time_end_option()).',';
					}
					if (seopress_rich_snippets_events_location_name_option() !='' && seopress_rich_snippets_events_location_address_option() !='') {
						$html .= '"location": {
							"@type": "Place",
							"name": '.json_encode(seopress_rich_snippets_events_location_name_option()).',
							"address": '.json_encode(seopress_rich_snippets_events_location_address_option()).'
						},';
					}
					if (seopress_rich_snippets_events_offers_name_option() !='') {
						$sp_offers = '"offers": [{
							"@type": "Offer",
							"name": '.json_encode(seopress_rich_snippets_events_offers_name_option()).',';
							if (seopress_rich_snippets_events_offers_cat_option() !='') {
								$sp_offers .= '"category": '.json_encode(seopress_rich_snippets_events_offers_cat_option()).',';
							}
							if (seopress_rich_snippets_events_offers_price_option() !='') {
								$sp_offers .= '"price": '.json_encode(seopress_rich_snippets_events_offers_price_option()).',';
							}
							if (seopress_rich_snippets_events_offers_price_currency_option() !='') {
								$sp_offers .= '"priceCurrency": '.json_encode(seopress_rich_snippets_events_offers_price_currency_option()).',';
							}
							if (seopress_rich_snippets_events_offers_url_option() !='') {
								$sp_offers .= '"url": '.json_encode(seopress_rich_snippets_events_offers_url_option()).',';
							}
							if (seopress_rich_snippets_events_offers_availability_option() !='') {
								$sp_offers .= '"availability": '.json_encode(seopress_rich_snippets_events_offers_availability_option()).',';
							}
							if (seopress_rich_snippets_events_offers_valid_from() !='') {
								$sp_offers .= '"validFrom": '.json_encode(seopress_rich_snippets_events_offers_valid_from());
							}
						$sp_offers = trim($sp_offers,',');
						if (seopress_pro_rich_snippets_events_performer_option() !='') {
							$sp_offers .= '}],';
						} else {
							$sp_offers .= '}]';
						}
						$html .= $sp_offers;
						
					}
					if (seopress_pro_rich_snippets_events_performer_option() !='') {
						$html .= '"performer": {
							"@type": "Person",
							"name": '.json_encode(seopress_pro_rich_snippets_events_performer_option()).'
						}';
					}
				$html = trim($html, ',');
				$html .= '}';
			$html .= '</script>';
			$html .= "\n";

			$html = apply_filters('seopress_schemas_event_html', $html);

			echo $html;
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_events_option', 3 );
		}
	}
	//Products
	//=========================================================================================
	//Init
	global $product;

	//Product name
	function seopress_rich_snippets_product_name_option() {
		$_seopress_pro_rich_snippets_product_name = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_name',true);
		if ($_seopress_pro_rich_snippets_product_name != '') {
			return $_seopress_pro_rich_snippets_product_name;
		} else { //Default
			return the_title_attribute('echo=0');
		}
	}
	//Description
	function seopress_rich_snippets_product_description_option() {
		$_seopress_pro_rich_snippets_product_description = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_description',true);
		if ($_seopress_pro_rich_snippets_product_description != '') {
			return $_seopress_pro_rich_snippets_product_description;
		} else { //Default
			return wp_trim_words(esc_html(get_the_excerpt()), 30);
		}
	}
	//Img
	function seopress_rich_snippets_product_img_option() {
		$_seopress_pro_rich_snippets_product_img = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_img',true);
		if ($_seopress_pro_rich_snippets_product_img != '') {
			return $_seopress_pro_rich_snippets_product_img;
		} elseif (get_the_post_thumbnail_url(get_the_ID(), 'large') !='') {
			return get_the_post_thumbnail_url(get_the_ID(), 'large');
		}
	}
	//Price
	function seopress_rich_snippets_product_price_option($product) {
		$_seopress_pro_rich_snippets_product_price = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_price',true);
		if ($_seopress_pro_rich_snippets_product_price != '') {
			return $_seopress_pro_rich_snippets_product_price;
		} elseif (isset($product) && $product->get_price() !='') {
			return $product->get_price();
		}
	}
	//Price valid until
	function seopress_pro_rich_snippets_product_price_valid_date_option($product) {
		$_seopress_pro_rich_snippets_product_price_valid_date = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_price_valid_date',true);
		if ($_seopress_pro_rich_snippets_product_price_valid_date != '') {
			return $_seopress_pro_rich_snippets_product_price_valid_date;
		} elseif(isset($product) && $product->get_date_on_sale_to() !='') {
			$date = $product->get_date_on_sale_to();
			return $date->date("m-d-Y");
		}
	}
	//SKU
	function seopress_rich_snippets_product_sku_option($product) {
		$_seopress_pro_rich_snippets_product_sku = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_sku',true);
		if ($_seopress_pro_rich_snippets_product_sku != '') {
			return $_seopress_pro_rich_snippets_product_sku;
		} elseif (isset($product) && $product->get_sku() !='') {
			return $product->get_sku();
		}
	}
	//Product Brand
	function seopress_rich_snippets_product_brand_option() {
		$_seopress_pro_rich_snippets_product_brand = '';
		$_seopress_pro_rich_snippets_product_brand = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_brand',true);
		if ($_seopress_pro_rich_snippets_product_brand != '') {
			$term_list = wp_get_post_terms(get_the_ID(), $_seopress_pro_rich_snippets_product_brand, array("fields" => "names"));
			if (!empty($term_list) && !is_wp_error($term_list)) {
				return $term_list[0];
			}
		}
	}
	//gtin8 | gtin13 | gtin14 | mpn | isbn
	function seopress_rich_snippets_product_global_ids_option() {
		$_seopress_rich_snippets_product_global_ids = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_global_ids',true);
		if ($_seopress_rich_snippets_product_global_ids != '') {
			return $_seopress_rich_snippets_product_global_ids;
		}
	}
	//global identifiers value
	function seopress_rich_snippets_product_global_ids_value_option() {
		$_seopress_rich_snippets_product_global_ids_value = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_global_ids_value',true);
		if ($_seopress_rich_snippets_product_global_ids_value != '') {
			return $_seopress_rich_snippets_product_global_ids_value;
		}
	}
	//Price currency
	function seopress_rich_snippets_product_price_currency_option() {
		$_seopress_pro_rich_snippets_product_price_currency = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_price_currency',true);
		if ($_seopress_pro_rich_snippets_product_price_currency != '') {
			return $_seopress_pro_rich_snippets_product_price_currency;
		}
	}
	//Item Condition
	function seopress_rich_snippets_product_condition_option() {
		$_seopress_pro_rich_snippets_product_condition = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_condition',true);
		if ($_seopress_pro_rich_snippets_product_condition != '') {
			return seopress_check_ssl().'schema.org/'.$_seopress_pro_rich_snippets_product_condition;
		} else {
			return seopress_check_ssl().'schema.org/NewCondition';
		}
	}
	//Availability
	function seopress_rich_snippets_product_availability_option() {
		$_seopress_pro_rich_snippets_product_availability = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_product_availability',true);
		if ($_seopress_pro_rich_snippets_product_availability != '') {
			return seopress_check_ssl().'schema.org/'.$_seopress_pro_rich_snippets_product_availability;
		}
	}

	//Products JSON-LD
	if ($_seopress_pro_rich_snippets_type =='products') {
		function seopress_rich_snippets_product_option($product) {
			//Init
			global $product;
			
			$html = '<script type="application/ld+json">';
			$html .= '{
				"@context": "'.seopress_check_ssl().'schema.org/",
				"@type": "Product",';
				if (seopress_rich_snippets_product_name_option()) {
					$html .= '"name": '.json_encode(seopress_rich_snippets_product_name_option()).',';
				}
				if (seopress_rich_snippets_product_img_option() !='') {
					$html .= '"image": '.json_encode(seopress_rich_snippets_product_img_option()).',';
				}
				if (seopress_rich_snippets_product_description_option() !='') {
					$html .= '"description": '.json_encode(seopress_rich_snippets_product_description_option()).',';
				}
				if (seopress_rich_snippets_product_sku_option($product) !='') {
					$html .= '"sku": '.json_encode(seopress_rich_snippets_product_sku_option($product)).',';
				}
				if (seopress_rich_snippets_product_global_ids_option() !='' && seopress_rich_snippets_product_global_ids_value_option() !='') {
					$html .=  json_encode(seopress_rich_snippets_product_global_ids_option()).': '.json_encode(seopress_rich_snippets_product_global_ids_value_option()).',';
				}
				//brand
				if (seopress_rich_snippets_product_brand_option() !='') {		
					$html .= '"brand": {
				    	"@type": "Thing",
				    	"name": '.json_encode(seopress_rich_snippets_product_brand_option()).'
				  	},';
				}
				if (isset($product) && comments_open(get_the_ID()) ===true) {//If Reviews is true
					//review
					$args = array(
						'meta_key' => 'rating',
						'number' => 1,
					    'status'      => 'approve',
					    'post_status' => 'publish',
					    'parent'      => 0,
						'orderby' => 'meta_value_num',
						'order' => 'DESC',
						'post_id' => get_the_ID(),
						'post_type' => 'product',
					);

					$comments = get_comments( $args );

					if (!empty($comments)) {
						$html .= '"review": {
						    "@type": "Review",
						    "reviewRating": {
						      	"@type": "Rating",
						    	"ratingValue": '.json_encode(get_comment_meta( $comments[0]->comment_ID, 'rating', true )).'
						    },
						    "author": {
						    	"@type": "Person",
						      	"name": '.json_encode(get_comment_author($comments[0]->comment_ID)).'
						    }
					  	},';
					}
					//aggregateRating
					if (isset($product) && $product->get_review_count() >=1) {
						$html .= '"aggregateRating": {
						    "@type": "AggregateRating",
						    "ratingValue": "'.$product->get_average_rating().'",
						    "reviewCount": "'.json_encode($product->get_review_count()).'"
					  	},';
				  	}
				}
			  	//offers
				if (seopress_rich_snippets_product_price_option($product) !='') {
					$html .= '"offers": {
						"@type": "Offer",
						"url": '.json_encode(get_permalink()).',
						"priceCurrency": '.json_encode(seopress_rich_snippets_product_price_currency_option()).',
						"price": '.json_encode(seopress_rich_snippets_product_price_option($product)).',
						"priceValidUntil": '.json_encode(seopress_pro_rich_snippets_product_price_valid_date_option($product)).',
						"itemCondition": '.json_encode(seopress_rich_snippets_product_condition_option()).',
						"availability": '.json_encode(seopress_rich_snippets_product_availability_option()).'
					}';
				}
				$html = trim($html, ',');
				$html .= '}';
			$html .= '</script>';
			$html .= "\n";

			$html = apply_filters('seopress_schemas_product_html', $html);

			echo $html;
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_product_option', 3 );
		}
	}
	//Services
	//=========================================================================================
	//Service name
	function seopress_rich_snippets_service_name_option() {
		$_seopress_pro_rich_snippets_service_name = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_name',true);
		if ($_seopress_pro_rich_snippets_service_name != '') {
			return $_seopress_pro_rich_snippets_service_name;
		} else { //Default
			return the_title_attribute('echo=0');
		}
	}
	//Service type
	function seopress_rich_snippets_service_type_option() {
		$_seopress_pro_rich_snippets_service_type = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_type',true);
		if ($_seopress_pro_rich_snippets_service_type != '') {
			return $_seopress_pro_rich_snippets_service_type;
		}
	}
	//Service description
	function seopress_rich_snippets_service_description_option() {
		$_seopress_pro_rich_snippets_service_description = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_description',true);
		if ($_seopress_pro_rich_snippets_service_description != '') {
			return $_seopress_pro_rich_snippets_service_description;
		} else { //Default
			return wp_trim_words(esc_html(get_the_excerpt()), 30);
		}
	}
	//Img
	function seopress_rich_snippets_service_img_option() {
		$_seopress_pro_rich_snippets_service_img = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_img',true);
		if ($_seopress_pro_rich_snippets_service_img != '') {
			return $_seopress_pro_rich_snippets_service_img;
		} elseif (get_the_post_thumbnail_url(get_the_ID(), 'large') !='') {
			return get_the_post_thumbnail_url(get_the_ID(), 'large');
		}
	}
	//Area served
	function seopress_rich_snippets_service_area_served_option() {
		$_seopress_pro_rich_snippets_service_area = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_area',true);
		if ($_seopress_pro_rich_snippets_service_area != '') {
			return $_seopress_pro_rich_snippets_service_area;
		}
	}
	//Provider name
	function seopress_rich_snippets_service_provider_name_option() {
		$_seopress_pro_rich_snippets_service_provider_name = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_provider_name',true);
		if ($_seopress_pro_rich_snippets_service_provider_name != '') {
			return $_seopress_pro_rich_snippets_service_provider_name;
		}
	}
	//Location img
	function seopress_rich_snippets_service_lb_img_option() {
		$_seopress_pro_rich_snippets_service_lb_img = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_lb_img',true);
		if ($_seopress_pro_rich_snippets_service_lb_img != '') {
			return $_seopress_pro_rich_snippets_service_lb_img;
		}
	}
	//Provider mobility
	function seopress_rich_snippets_service_provider_mobility_option() {
		$_seopress_pro_rich_snippets_service_provider_mobility = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_provider_mobility',true);
		if ($_seopress_pro_rich_snippets_service_provider_mobility != '') {
			return $_seopress_pro_rich_snippets_service_provider_mobility;
		}
	}
	//Slogan
	function seopress_rich_snippets_service_slogan_option() {
		$_seopress_pro_rich_snippets_service_slogan = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_slogan',true);
		if ($_seopress_pro_rich_snippets_service_slogan != '') {
			return $_seopress_pro_rich_snippets_service_slogan;
		}
	}
	//Street addr
	function seopress_rich_snippets_service_street_addr_option() {
		$_seopress_pro_rich_snippets_service_street_addr = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_street_addr',true);
		if ($_seopress_pro_rich_snippets_service_street_addr != '') {
			return $_seopress_pro_rich_snippets_service_street_addr;
		}
	}
	//City
	function seopress_rich_snippets_service_city_option() {
		$_seopress_pro_rich_snippets_service_city = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_city',true);
		if ($_seopress_pro_rich_snippets_service_city != '') {
			return $_seopress_pro_rich_snippets_service_city;
		}
	}
	//State
	function seopress_rich_snippets_service_state_option() {
		$_seopress_pro_rich_snippets_service_state = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_state',true);
		if ($_seopress_pro_rich_snippets_service_state != '') {
			return $_seopress_pro_rich_snippets_service_state;
		}
	}
	//PC
	function seopress_rich_snippets_service_pc_option() {
		$_seopress_pro_rich_snippets_service_pc = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_pc',true);
		if ($_seopress_pro_rich_snippets_service_pc != '') {
			return $_seopress_pro_rich_snippets_service_pc;
		}
	}
	//Country
	function seopress_rich_snippets_service_country_option() {
		$_seopress_pro_rich_snippets_service_country = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_country',true);
		if ($_seopress_pro_rich_snippets_service_country != '') {
			return $_seopress_pro_rich_snippets_service_country;
		}
	}
	//Lat
	function seopress_rich_snippets_service_lat_option() {
		$_seopress_pro_rich_snippets_service_lat = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_lat',true);
		if ($_seopress_pro_rich_snippets_service_lat != '') {
			return $_seopress_pro_rich_snippets_service_lat;
		}
	}
	//Lon
	function seopress_rich_snippets_service_lon_option() {
		$_seopress_pro_rich_snippets_service_lon = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_lon',true);
		if ($_seopress_pro_rich_snippets_service_lon != '') {
			return $_seopress_pro_rich_snippets_service_lon;
		}
	}
	//Tel
	function seopress_rich_snippets_service_tel_option() {
		$_seopress_pro_rich_snippets_service_tel = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_tel',true);
		if ($_seopress_pro_rich_snippets_service_tel != '') {
			return $_seopress_pro_rich_snippets_service_tel;
		}
	}
	//Price
	function seopress_rich_snippets_service_price_option() {
		$_seopress_pro_rich_snippets_service_price = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_service_price',true);
		if ($_seopress_pro_rich_snippets_service_price != '') {
			return $_seopress_pro_rich_snippets_service_price;
		}
	}

	//Services JSON-LD
	if ($_seopress_pro_rich_snippets_type =='services') {
		function seopress_rich_snippets_service_option($product) {
			//Init
			global $product;
			
			$html = '<script type="application/ld+json">';
			$html .= '{
				"@context": "'.seopress_check_ssl().'schema.org/",
				"@type": "Service",';
				if (seopress_rich_snippets_service_name_option() !='') {
					$html .= '"name": '.json_encode(seopress_rich_snippets_service_name_option()).',';
				}
				if (seopress_rich_snippets_service_type_option() !='') {
					$html .= '"serviceType": '.json_encode(seopress_rich_snippets_service_type_option()).',';
				}
				if (seopress_rich_snippets_service_description_option() !='') {
					$html .= '"description": '.json_encode(seopress_rich_snippets_service_description_option()).',';
				}
				if (seopress_rich_snippets_service_img_option() !='') {
					$html .= '"image": '.json_encode(seopress_rich_snippets_service_img_option()).',';
				}
				if (seopress_rich_snippets_service_area_served_option() !='') {
					$html .= '"areaServed": '.json_encode(seopress_rich_snippets_service_area_served_option()).',';
				}
				if (seopress_rich_snippets_service_provider_mobility_option() !='') {
					$html .= '"providerMobility": '.json_encode(seopress_rich_snippets_service_provider_mobility_option()).',';
				}
				if (seopress_rich_snippets_service_slogan_option() !='') {
					$html .= '"slogan": '.json_encode(seopress_rich_snippets_service_slogan_option()).',';
				}
				//Provider
				if (seopress_rich_snippets_service_lb_img_option() !='') {
					$html .= '"provider": {
						"@type": "LocalBusiness",';
					$html .= '"name": '.json_encode(seopress_rich_snippets_service_lb_img_option()).',';
		
					if (seopress_rich_snippets_service_tel_option() !='') {
						$html .= '"telephone": '.json_encode(seopress_rich_snippets_service_tel_option()).',';
					}
					if (seopress_rich_snippets_service_lb_img_option() !='') {
						$html .= '"image": '.json_encode(seopress_rich_snippets_service_lb_img_option()).',';
					}
					if (seopress_rich_snippets_service_price_option() !='') {
						$html .= '"priceRange": '.json_encode(seopress_rich_snippets_service_price_option()).',';
					}
				
					//Address
					if (seopress_rich_snippets_service_street_addr_option() !='' || seopress_rich_snippets_service_city_option() !='' || seopress_rich_snippets_service_state_option() !='' || seopress_rich_snippets_service_pc_option() !='' || seopress_rich_snippets_service_country_option() !='') {
						$html .= '"address": {
							"@type": "PostalAddress",';
							if (seopress_rich_snippets_service_street_addr_option() !='') {
								$html .= '"streetAddress": '.json_encode(seopress_rich_snippets_service_street_addr_option()).',';
							}
							if (seopress_rich_snippets_service_city_option() !='') {
								$html .= '"addressLocality": '.json_encode(seopress_rich_snippets_service_city_option()).',';
							}
							if (seopress_rich_snippets_service_state_option() !='') {
								$html .= '"addressRegion": '.json_encode(seopress_rich_snippets_service_state_option()).',';
							}
							if (seopress_rich_snippets_service_pc_option() !='') {
								$html .= '"postalCode": '.json_encode(seopress_rich_snippets_service_pc_option()).',';
							}
							if (seopress_rich_snippets_service_country_option() !='') {
								$html .= '"addressCountry": '.json_encode(seopress_rich_snippets_service_country_option());
							}
						$html .= '},';
					}
					//GPS
					if (seopress_rich_snippets_service_lat_option() !='' || seopress_rich_snippets_service_lon_option() !='') {
						$html .= '"geo": {
							"@type": "GeoCoordinates",';
							if (seopress_rich_snippets_service_lat_option() !='') {
								$html .= '"latitude": '.json_encode(seopress_rich_snippets_service_lat_option()).',';
							}
							if (seopress_rich_snippets_service_lon_option() !='') {
								$html .= '"longitude": '.json_encode(seopress_rich_snippets_service_lon_option());
							}
						$html .= '}';
					}
					if (isset($product) && comments_open(get_the_ID()) ===true) {//If Reviews is true
						$html .= '},';
					} else {
						$html .= '}';
					}
				}
				
				if (isset($product) && comments_open(get_the_ID()) ===true) {//If Reviews is true
					//review
					$args = array(
						'meta_key' => 'rating',
						'number' => 1,
						'status'      => 'approve',
						'post_status' => 'publish',
						'parent'      => 0,
						'orderby' => 'meta_value_num',
						'order' => 'DESC',
						'post_id' => get_the_ID(),
						'post_type' => 'product',
					);

					$comments = get_comments( $args );

					if (!empty($comments)) {
						$html .= '"review": {
							"@type": "Review",
							"reviewRating": {
									"@type": "Rating",
								"ratingValue": '.json_encode(get_comment_meta( $comments[0]->comment_ID, 'rating', true )).'
							},
							"author": {
								"@type": "Person",
									"name": '.json_encode(get_comment_author($comments[0]->comment_ID)).'
							}
							},';
					}

					//aggregateRating
					if (isset($product) && $product->get_review_count() >=1) {
						$html .= '"aggregateRating": {
							"@type": "AggregateRating",
							"ratingValue": "'.$product->get_average_rating().'",
							"reviewCount": "'.json_encode($product->get_review_count()).'"
							}';
					}
				}
				$html = trim($html, ',');
				$html .= '}';
			$html .= '</script>';
			$html .= "\n";

			$html = apply_filters('seopress_schemas_service_html', $html);

			echo $html;
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_service_option', 3 );
		}
	}
	//Review
	//=========================================================================================
	//Review item name
	function seopress_pro_rich_snippets_review_item_option() {
		$_seopress_pro_rich_snippets_review_item = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_review_item',true);
		if ($_seopress_pro_rich_snippets_review_item != '') {
			return $_seopress_pro_rich_snippets_review_item;
		}
	}
	//Review item type
	function seopress_pro_rich_snippets_review_item_type_option() {
		$_seopress_pro_rich_snippets_review_item_type = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_review_item_type',true);
		if ($_seopress_pro_rich_snippets_review_item_type != '') {
			return $_seopress_pro_rich_snippets_review_item_type;
		}
	}
	//Review item img
	function seopress_pro_rich_snippets_review_img_option() {
		$_seopress_pro_rich_snippets_review_img = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_review_img',true);
		if ($_seopress_pro_rich_snippets_review_img != '') {
			return $_seopress_pro_rich_snippets_review_img;
		}
	}
	//Review rating
	function seopress_pro_rich_snippets_review_rating_option() {
		$_seopress_pro_rich_snippets_review_rating = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_review_rating',true);
		if ($_seopress_pro_rich_snippets_review_rating != '') {
			return $_seopress_pro_rich_snippets_review_rating;
		}
	}
	//Review JSON-LD
	if ($_seopress_pro_rich_snippets_type =='review') {
		function seopress_rich_snippets_review_option() {

			if (seopress_pro_rich_snippets_review_item_type_option()) {
				$type = seopress_pro_rich_snippets_review_item_type_option();
			} else {
				$type = 'Thing';
			}

			$html = '<script type="application/ld+json">';
			$html .= '{
				"@context": "'.seopress_check_ssl().'schema.org/",
				"@type": "Review",';
				if (seopress_pro_rich_snippets_review_item_option()) {
					$html .= '"itemReviewed":{"@type":'.json_encode($type).',"name":'.json_encode(seopress_pro_rich_snippets_review_item_option());
				}
				if (seopress_pro_rich_snippets_review_item_option() !='' && seopress_pro_rich_snippets_review_img_option() =='') {
					$html .= '},';
				} else {
					$html .= ',';
				}
				if (seopress_pro_rich_snippets_review_img_option() !='') {
					$html .= '"image": {"@type":"ImageObject","url":'.json_encode(seopress_pro_rich_snippets_review_img_option()).'}';
				}
				if (seopress_pro_rich_snippets_review_item_option() !='' && seopress_pro_rich_snippets_review_img_option() !='') {
					$html .= '},';
				}
				if (seopress_pro_rich_snippets_review_rating_option() !='') {
					$html .= '"reviewRating":{"@type":"Rating","ratingValue":'.json_encode(seopress_pro_rich_snippets_review_rating_option()).'},';
				}
				$html .= '"datePublished":"'.get_the_date('c').'",';
				$html .= '"author":{"@type":"Person","name":'.json_encode(get_the_author()).'}';
				$html = trim($html, ',');
				$html .= '}';
			$html .= '</script>';

			$html .= "\n";

			$html = apply_filters('seopress_schemas_review_html', $html);

			echo $html;
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_review_option', 3 );
		}
	}
	//Custom schema
	//=========================================================================================
	//Custom
	function seopress_pro_rich_snippets_custom_option() {
		$_seopress_pro_rich_snippets_custom = get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_custom',true);
		if ($_seopress_pro_rich_snippets_custom != '') {
			return $_seopress_pro_rich_snippets_custom;
		}
	}
	//Custom JSON-LD
	if ($_seopress_pro_rich_snippets_type =='custom') {
		function seopress_rich_snippets_custom_option() {
			$html = '';
			if (seopress_pro_rich_snippets_custom_option()) {
				$variables = NULL;
				$variables = apply_filters('seopress_dyn_variables_fn', $variables);
			
				$post = $variables['post'];
				$term = $variables['term'];
				$seopress_titles_title_template = $variables['seopress_titles_title_template'];
				$seopress_titles_description_template = $variables['seopress_titles_description_template'];
				$seopress_paged = $variables['seopress_paged'];
				$the_author_meta = $variables['the_author_meta'];
				$sep = $variables['sep'];
				$seopress_excerpt = $variables['seopress_excerpt'];
				$post_category = $variables['post_category'];
				$post_tag = $variables['post_tag'];
				$post_thumbnail_url = $variables['post_thumbnail_url'];
				$get_search_query = $variables['get_search_query'];
				$woo_single_cat_html = $variables['woo_single_cat_html'];
				$woo_single_tag_html = $variables['woo_single_tag_html'];
				$woo_single_price = $variables['woo_single_price'];
				$woo_single_price_exc_tax = $variables['woo_single_price_exc_tax'];
				$woo_single_sku = $variables['woo_single_sku'];
				$author_bio = $variables['author_bio'];
				$seopress_get_the_excerpt = $variables['seopress_get_the_excerpt'];
				$seopress_titles_template_variables_array = $variables['seopress_titles_template_variables_array'];
				$seopress_titles_template_replace_array = $variables['seopress_titles_template_replace_array'];
				$seopress_excerpt_length = $variables['seopress_excerpt_length'];

				$custom = seopress_pro_rich_snippets_custom_option();
				
				preg_match_all('/%%_cf_(.*?)%%/', $custom, $matches); //custom fields

				if (!empty($matches)) {
					$seopress_titles_cf_template_variables_array = array();
					$seopress_titles_cf_template_replace_array = array();
	
					foreach ($matches['0'] as $key => $value) {
						$seopress_titles_cf_template_variables_array[] = $value;
					}
	
					foreach ($matches['1'] as $key => $value) {
						$seopress_titles_cf_template_replace_array[] = esc_attr(get_post_meta($post->ID,$value,true));
					}
				}
	
				preg_match_all('/%%_ct_(.*?)%%/', $custom, $matches2); //custom terms taxonomy
	
				if (!empty($matches2)) {
					$seopress_titles_ct_template_variables_array = array();
					$seopress_titles_ct_template_replace_array = array();
	
					foreach ($matches2['0'] as $key => $value) {
						$seopress_titles_ct_template_variables_array[] = $value;
					}
	
					foreach ($matches2['1'] as $key => $value) {
						$term = wp_get_post_terms( $post->ID, $value );
						if (!is_wp_error($term)) {
							$seopress_titles_ct_template_replace_array[] = esc_attr($term[0]->name);
						}
					}
				}
	
				//Default
				$custom = str_replace($seopress_titles_template_variables_array, $seopress_titles_template_replace_array, $custom);
	
				//Custom fields
				if (!empty($matches) && !empty($seopress_titles_cf_template_variables_array) && !empty($seopress_titles_cf_template_replace_array)) {
					$custom = str_replace($seopress_titles_cf_template_variables_array, $seopress_titles_cf_template_replace_array, $custom);
				}
	
				//Custom terms taxonomy
				if (!empty($matches2) && !empty($seopress_titles_ct_template_variables_array) && !empty($seopress_titles_ct_template_replace_array)) {
					$custom = str_replace($seopress_titles_ct_template_variables_array, $seopress_titles_ct_template_replace_array, $custom);
				}

				$html .= wp_specialchars_decode($custom,ENT_COMPAT);
			}

			$html .= "\n";

			$html = apply_filters('seopress_schemas_custom_html', $html);

			echo $html;
		}
		if (is_singular()) {
			add_action( 'wp_head', 'seopress_rich_snippets_custom_option', 3 );
		}
	}

	//SiteNavigationElement schema
	//=========================================================================================
	//SiteNavigationElement?
	function seopress_rich_snippets_site_nav_option() {
		$seopress_rich_snippets_site_nav_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_rich_snippets_site_nav_option ) ) {
			foreach ($seopress_rich_snippets_site_nav_option as $key => $seopress_rich_snippets_site_nav_value)
				$options[$key] = $seopress_rich_snippets_site_nav_value;
				if (isset($seopress_rich_snippets_site_nav_option['seopress_rich_snippets_site_nav'])) { 
					return $seopress_rich_snippets_site_nav_option['seopress_rich_snippets_site_nav'];
				}
		}
	}

	if (seopress_rich_snippets_site_nav_option() !="" && seopress_rich_snippets_site_nav_option() !='none') {
		function seopress_rich_snippets_site_nav() {
			if (function_exists('wp_get_nav_menu_items')) {
				$menu_items = wp_get_nav_menu_items(seopress_rich_snippets_site_nav_option());

				if (!empty($menu_items)) {
					$html = '<script type="application/ld+json">';
					$html .= '{
						"@context": "'.seopress_check_ssl().'schema.org/",
						"@type": "SiteNavigationElement",';


						$i = '0';
						$count = count($menu_items);
						$html .= '"name":[';
						foreach ($menu_items as $item) {
							$html .= json_encode($item->title);
							if ($i < $count -1) {
								$html .= ',';
							}
							$i++;
						}
						$i = '0';
						$html .= '],';
						$html .= '"url":[';
						foreach ($menu_items as $item) {
							$html .= json_encode($item->url);
							if ($i < $count -1) {
								$html .= ',';
							}
							$i++;
						}
						$html .= ']';
					$html .= '}';
					$html .= '</script>';

					$html .= "\n";
					
					$html = apply_filters('seopress_schemas_site_navigation_element_html', $html);

					echo $html;
				}
			}
		}
		add_action( 'wp_head', 'seopress_rich_snippets_site_nav');
	}
}