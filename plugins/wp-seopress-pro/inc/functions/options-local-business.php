<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//Local Business
//=================================================================================================
//Local Business JSON-LD
if (seopress_get_toggle_local_business_option() =='1' && get_post_meta(get_the_ID(),'_seopress_pro_rich_snippets_type',true) !='localbusiness') { //Is Local Business enable
	//Business Type
	function seopress_local_business_type_option() {
		$seopress_local_business_type_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_type_option ) ) {
			foreach ($seopress_local_business_type_option as $key => $seopress_local_business_type_value)
				$options[$key] = $seopress_local_business_type_value;
			 if (isset($seopress_local_business_type_option['seopress_local_business_type'])) { 
			 	return $seopress_local_business_type_option['seopress_local_business_type'];
			 }
		}
	}
	//Street address
	function seopress_local_business_street_address_option() {
		$seopress_local_business_street_address_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_street_address_option ) ) {
			foreach ($seopress_local_business_street_address_option as $key => $seopress_local_business_street_address_value)
				$options[$key] = $seopress_local_business_street_address_value;
			 if (isset($seopress_local_business_street_address_option['seopress_local_business_street_address'])) { 
			 	return $seopress_local_business_street_address_option['seopress_local_business_street_address'];
			 }
		}
	}
	//Locality
	function seopress_local_business_address_locality_option() {
		$seopress_local_business_address_locality_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_address_locality_option ) ) {
			foreach ($seopress_local_business_address_locality_option as $key => $seopress_local_business_address_locality_value)
				$options[$key] = $seopress_local_business_address_locality_value;
			 if (isset($seopress_local_business_address_locality_option['seopress_local_business_address_locality'])) { 
			 	return $seopress_local_business_address_locality_option['seopress_local_business_address_locality'];
			 }
		}
	}
	//Region
	function seopress_local_business_address_region_option() {
		$seopress_local_business_address_region_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_address_region_option ) ) {
			foreach ($seopress_local_business_address_region_option as $key => $seopress_local_business_address_region_value)
				$options[$key] = $seopress_local_business_address_region_value;
			 if (isset($seopress_local_business_address_region_option['seopress_local_business_address_region'])) { 
			 	return $seopress_local_business_address_region_option['seopress_local_business_address_region'];
			 }
		}
	}
	//Code
	function seopress_local_business_postal_code_option() {
		$seopress_local_business_postal_code_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_postal_code_option ) ) {
			foreach ($seopress_local_business_postal_code_option as $key => $seopress_local_business_postal_code_value)
				$options[$key] = $seopress_local_business_postal_code_value;
			 if (isset($seopress_local_business_postal_code_option['seopress_local_business_postal_code'])) { 
			 	return $seopress_local_business_postal_code_option['seopress_local_business_postal_code'];
			 }
		}
	}
	//Country
	function seopress_local_business_address_country_option() {
		$seopress_local_business_address_country_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_address_country_option ) ) {
			foreach ($seopress_local_business_address_country_option as $key => $seopress_local_business_address_country_value)
				$options[$key] = $seopress_local_business_address_country_value;
			 if (isset($seopress_local_business_address_country_option['seopress_local_business_address_country'])) { 
			 	return $seopress_local_business_address_country_option['seopress_local_business_address_country'];
			 }
		}
	}
	//Lat
	function seopress_local_business_lat_option() {
		$seopress_local_business_lat_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_lat_option ) ) {
			foreach ($seopress_local_business_lat_option as $key => $seopress_local_business_lat_value)
				$options[$key] = $seopress_local_business_lat_value;
			 if (isset($seopress_local_business_lat_option['seopress_local_business_lat'])) { 
			 	return $seopress_local_business_lat_option['seopress_local_business_lat'];
			 }
		}
	}
	//Lon
	function seopress_local_business_lon_option() {
		$seopress_local_business_lon_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_lon_option ) ) {
			foreach ($seopress_local_business_lon_option as $key => $seopress_local_business_lon_value)
				$options[$key] = $seopress_local_business_lon_value;
			 if (isset($seopress_local_business_lon_option['seopress_local_business_lon'])) { 
			 	return $seopress_local_business_lon_option['seopress_local_business_lon'];
			 }
		}
	}
	//URL
	function seopress_local_business_url_option() {
		$seopress_local_business_url_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_url_option ) ) {
			foreach ($seopress_local_business_url_option as $key => $seopress_local_business_url_value)
				$options[$key] = $seopress_local_business_url_value;
			 if (isset($seopress_local_business_url_option['seopress_local_business_url'])) { 
			 	return $seopress_local_business_url_option['seopress_local_business_url'];
			 }
		}
	}
	//Phone
	function seopress_local_business_phone_option() {
		$seopress_local_business_phone_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_phone_option ) ) {
			foreach ($seopress_local_business_phone_option as $key => $seopress_local_business_phone_value)
				$options[$key] = $seopress_local_business_phone_value;
			 if (isset($seopress_local_business_phone_option['seopress_local_business_phone'])) { 
			 	return $seopress_local_business_phone_option['seopress_local_business_phone'];
			 }
		}
	}
	//Price range
	function seopress_local_business_price_range_option() {
		$seopress_local_business_price_range_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_price_range_option ) ) {
			foreach ($seopress_local_business_price_range_option as $key => $seopress_local_business_price_range_value)
				$options[$key] = $seopress_local_business_price_range_value;
			 if (isset($seopress_local_business_price_range_option['seopress_local_business_price_range'])) { 
			 	return $seopress_local_business_price_range_option['seopress_local_business_price_range'];
			 }
		}
	}
	//Opening Hours
	function seopress_local_business_opening_hours_option() {
		$seopress_local_business_opening_hours_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_local_business_opening_hours_option ) ) {
			foreach ($seopress_local_business_opening_hours_option as $key => $seopress_local_business_opening_hours_value)
				$options[$key] = $seopress_local_business_opening_hours_value;
			 if (isset($seopress_local_business_opening_hours_option['seopress_local_business_opening_hours'])) { 
			 	return $seopress_local_business_opening_hours_option['seopress_local_business_opening_hours'];
			 }
		}
	}
	//Name
	function seopress_local_business_name_option() {
		$seopress_local_business_name_option = get_option("seopress_social_option_name");
		if ( ! empty ( $seopress_local_business_name_option ) ) {
			foreach ($seopress_local_business_name_option as $key => $seopress_local_business_name_value)
				$options[$key] = $seopress_local_business_name_value;
			 if (isset($seopress_local_business_name_option['seopress_social_knowledge_name'])) { 
			 	return $seopress_local_business_name_option['seopress_social_knowledge_name'];
			 }
		}
	}
	//Logo
	function seopress_local_business_img_option() {
		$seopress_local_business_img_option = get_option("seopress_social_option_name");
		if ( ! empty ( $seopress_local_business_img_option ) ) {
			foreach ($seopress_local_business_img_option as $key => $seopress_local_business_img_value)
				$options[$key] = $seopress_local_business_img_value;
			 if (isset($seopress_local_business_img_option['seopress_social_knowledge_img'])) { 
			 	return $seopress_local_business_img_option['seopress_social_knowledge_img'];
			 }
		}
	}
	function seopress_local_business_jsonld_hook() {
		if (seopress_local_business_img_option() !='') {
			$seopress_local_business_img_option = json_encode(seopress_local_business_img_option());
		}

		if (seopress_local_business_name_option() !='') {
			$seopress_local_business_name_option = json_encode(seopress_local_business_name_option());
		}

		if (seopress_local_business_type_option() !='') {
			$seopress_local_business_type_option = json_encode(seopress_local_business_type_option());
		}

		if (seopress_local_business_street_address_option() !='') {
			$seopress_local_business_street_address_option = json_encode(seopress_local_business_street_address_option());
		}

		if (seopress_local_business_address_locality_option() !='') {
			$seopress_local_business_address_locality_option = json_encode(seopress_local_business_address_locality_option());
		}

		if (seopress_local_business_address_region_option() !='') {
			$seopress_local_business_address_region_option = json_encode(seopress_local_business_address_region_option());
		}

		if (seopress_local_business_postal_code_option() !='') {
			$seopress_local_business_postal_code_option = json_encode(seopress_local_business_postal_code_option());
		}

		if (seopress_local_business_address_country_option() !='') {
			$seopress_local_business_address_country_option = json_encode(seopress_local_business_address_country_option());
		}

		if (seopress_local_business_lat_option() !='') {
			$seopress_local_business_lat_option = json_encode(seopress_local_business_lat_option());
		}

		if (seopress_local_business_lon_option() !='') {
			$seopress_local_business_lon_option = json_encode(seopress_local_business_lon_option());
		}

		if (seopress_local_business_url_option() !='') {
			$seopress_local_business_url_option = json_encode(seopress_local_business_url_option());
		}

		if (seopress_local_business_phone_option() !='') {
			$seopress_local_business_phone_option = json_encode(seopress_local_business_phone_option());
		}

		if (seopress_local_business_price_range_option() !='') {
			$seopress_local_business_price_range_option = json_encode(seopress_local_business_price_range_option());
		}
		if (seopress_local_business_opening_hours_option() !='') {
			$days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
			
			$seopress_local_business_opening_hours_option ='';
						
			foreach (seopress_local_business_opening_hours_option() as $key => $day) {
				if(!array_key_exists('open', $day)) {
					
					$seopress_local_business_opening_hours_option .= '{ ';
					$seopress_local_business_opening_hours_option .= '"@type": "OpeningHoursSpecification",';
					$seopress_local_business_opening_hours_option .= '"dayOfWeek": "'.$days[$key].'", ';
					foreach ($day as $_key => $value) {
						if ($_key =='start') {
							$seopress_local_business_opening_hours_option .= '"opens": "';
							foreach ($value as $__key => $time) {
								$seopress_local_business_opening_hours_option .= $time;
								if ($__key == 'hours') {
									$seopress_local_business_opening_hours_option .= ':';
								}
							}
							$seopress_local_business_opening_hours_option .= '",';
						}
						if ($_key =='end') {
							$seopress_local_business_opening_hours_option .= '"closes": "';
							foreach ($value as $__key => $time) {
								$seopress_local_business_opening_hours_option .= $time;
								if ($__key == 'hours') {
									$seopress_local_business_opening_hours_option .= ':';
								}
							}
							$seopress_local_business_opening_hours_option .= '"';
						}
					}
					$seopress_local_business_opening_hours_option .= '|';
				}
			}
		}

		if (isset($seopress_local_business_type_option)) {
			echo '<script type="application/ld+json">';
			echo '{"@context" : "'.seopress_check_ssl().'schema.org","@type" : '.$seopress_local_business_type_option.',';
			if (isset($seopress_local_business_img_option)) {
				echo '"image": '.$seopress_local_business_img_option.', ';
			}
			echo '"@id": '.json_encode(get_home_url()).',';

			if (isset($seopress_local_business_street_address_option) || isset($seopress_local_business_address_locality_option) || isset($seopress_local_business_address_region_option) || isset($seopress_local_business_postal_code_option) || isset($seopress_local_business_address_country_option)) {
				echo '"address": {
				    "@type": "PostalAddress",';
				    if (isset($seopress_local_business_street_address_option)) {
				    	echo '"streetAddress": '.$seopress_local_business_street_address_option.',';
					}
					if (isset($seopress_local_business_address_locality_option)) {
				    	echo '"addressLocality": '.$seopress_local_business_address_locality_option.',';
					}
					if (isset($seopress_local_business_address_region_option)) {
				    	echo '"addressRegion": '.$seopress_local_business_address_region_option.',';
				    }
				    if (isset($seopress_local_business_postal_code_option)) {
				    	echo '"postalCode": '.$seopress_local_business_postal_code_option.',';
					}
					if (isset($seopress_local_business_address_country_option)) {
				    	echo '"addressCountry": '.$seopress_local_business_address_country_option;
					}
			  	echo '},';
			}

			if (isset($seopress_local_business_lat_option) || isset($seopress_local_business_lon_option)) {
				echo '"geo": {
				    "@type": "GeoCoordinates",';
				    if (isset($seopress_local_business_lat_option)) {
				    	echo '"latitude": '.$seopress_local_business_lat_option.',';
					}
					if (isset($seopress_local_business_lon_option)) {
				    	echo '"longitude": '.$seopress_local_business_lon_option;
				    }
				echo '},';
			}

			if (isset($seopress_local_business_url_option)) {
				echo '"url": '.$seopress_local_business_url_option.',';
			}

			if (isset($seopress_local_business_phone_option)) {
				echo '"telephone": '.$seopress_local_business_phone_option.',';
			}
			
			if (isset($seopress_local_business_price_range_option)) {
				echo '"priceRange": '.$seopress_local_business_price_range_option.',';
			}

			if (isset($seopress_local_business_opening_hours_option)) {
			 	echo '"openingHoursSpecification": [';
			 	
			 	$explode = array_filter(explode("|", $seopress_local_business_opening_hours_option));
				$seopress_comma_count = count($explode);
				for ($i = 0; $i < $seopress_comma_count; $i++) {
					echo $explode[$i];
				   	if ($i < ($seopress_comma_count - 1)) {  		
				    	echo '}, ';
				   	} else {
				   		echo '} ';
				   	}
				}
				
				echo '],';
			}
			if (isset($seopress_local_business_name_option)) {
				echo '"name": '.$seopress_local_business_name_option;
			} else {
				echo '"name": "'.get_bloginfo('name').'"';
			}
			echo '}';
			echo '</script>';
			echo "\n";
		}
	}
	add_action( 'wp_head', 'seopress_local_business_jsonld_hook', 2 );
}