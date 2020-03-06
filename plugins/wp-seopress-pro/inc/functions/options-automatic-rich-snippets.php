<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//Rich Snippets
//=================================================================================================
//Rich Snippets JSON-LD
if (seopress_rich_snippets_enable_option() =='1') { //Is RS enable
	if(is_single() || is_singular()){

		//Manual option
		function seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace) {
			if (!empty($post_meta_key)) {
				foreach ($post_meta_key as $key => $value) {
					//Init
					$_post_meta_value = NULL;

					//Single datas
					if ($key =='opening_hours') {
						if ($seopress_pro_schemas[0][$id]['rich_snippets_'.$schema_name][$key] !='') {
							$_post_meta_value = $seopress_pro_schemas[0][$id]['rich_snippets_'.$schema_name][$key];
						} else {
							$_post_meta_value = get_post_meta($id, $value, true);
							$_post_meta_value = $_post_meta_value['seopress_pro_rich_snippets_lb_opening_hours'];
						}
					} else {
						$post_meta_value = get_post_meta($id,$value,true);
					}

					//Global datas
		           	$manual_global 									= get_post_meta($id,$value.'_manual_global',true);
		           	
		           	$manual_img_global 								= get_post_meta($id,$value.'_manual_img_global',true);
		           	$manual_img_library_global 						= get_post_meta($id,$value.'_manual_img_library_global',true);

		           	$manual_date_global 							= get_post_meta($id,$value.'_manual_date_global',true);

		           	$manual_time_global 							= get_post_meta($id,$value.'_manual_time_global',true);

		           	$manual_rating_global 							= get_post_meta($id,$value.'_manual_rating_global',true);
					   
					$manual_custom_global 							= get_post_meta($id,$value.'_manual_custom_global',true);
					
					$cf 											= get_post_meta($id,$value.'_cf',true);
					
					$tax 											= get_post_meta($id,$value.'_tax',true);

					//From current single post
					if ($post_meta_value == 'manual_single' || $post_meta_value == 'manual_img_single' || $post_meta_value == 'manual_date_single' || $post_meta_value == 'manual_time_single' || $post_meta_value =='manual_rating_single' || $post_meta_value =='manual_custom_single') {
						if (isset($seopress_pro_schemas[0][$id]['rich_snippets_'.$schema_name][$key])) {
							$_post_meta_value = $seopress_pro_schemas[0][$id]['rich_snippets_'.$schema_name][$key];
						}
					} elseif ($post_meta_value == 'manual_global') {
						if ($manual_global !='') {
							$_post_meta_value = $manual_global;
						}
					} elseif ($post_meta_value == 'manual_img_global') {
						if ($manual_img_global !='') {
							$_post_meta_value = $manual_img_global;
						}
					} elseif ($post_meta_value == 'manual_img_library_global') {
						if ($manual_img_library_global !='') {
							$_post_meta_value = $manual_img_library_global;
						}
					} elseif ($post_meta_value == 'manual_date_global') {
						if ($manual_date_global !='') {
							$_post_meta_value = $manual_date_global;
						}
					} elseif ($post_meta_value == 'manual_time_global') {
						if ($manual_time_global !='') {
							$_post_meta_value = $manual_time_global;
						}
					} elseif ($post_meta_value == 'manual_rating_global') {
						if ($manual_rating_global !='') {
							$_post_meta_value = $manual_rating_global;
						}
					} elseif ($post_meta_value == 'manual_custom_global') {
						if ($manual_custom_global !='') {
							$_post_meta_value = $manual_custom_global;
						}
					} elseif($post_meta_value == 'custom_fields') {
						if ($cf !='') {
							$_post_meta_value = get_post_meta(get_the_ID(), $cf, true);
						}
					} elseif($post_meta_value == 'custom_taxonomy') {
						if ($tax !='') {
							$_post_meta_value ='';
							if (taxonomy_exists($tax)) {
								$terms = wp_get_post_terms(get_the_ID(), $tax, array("fields" => "names"));
								if (!empty($terms) && !is_wp_error($terms)) {
									$_post_meta_value = $terms[0];
								}
							}
						}
					} elseif ($post_meta_value != 'none') { //From schema single post
						$_post_meta_value = str_replace($sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace, $post_meta_value);
					}

					//Push value to array
					$schema_datas[$key] = $_post_meta_value;
				}
				return $schema_datas;
			}
		}

		//Articles JSON-LD
		function seopress_automatic_rich_snippets_articles_option($schema_datas) {
			//if no data
			if(count(array_filter($schema_datas,'strlen')) != 0) {
				$article_type 					= $schema_datas['type'];
				$article_title 					= $schema_datas['title'];
				$article_img 					= $schema_datas['img'];

				$html = '<script type="application/ld+json">';
				$html .= '{
						"@context": "'.seopress_check_ssl().'schema.org",';
						if ($article_type !='') {
							$html .= '"@type": '.json_encode($article_type).',';
						}
						if (function_exists('seopress_rich_snippets_articles_canonical_option') && seopress_rich_snippets_articles_canonical_option() !='') {
							$html .= '"mainEntityOfPage": {
								"@type": "WebPage",
								"@id": '.json_encode(seopress_rich_snippets_articles_canonical_option()).'
							},';
						}
						if ($article_title !='') {
							$html .= '"headline": '.json_encode($article_title).',';
						}
						if ($article_img !='') {
							$html .= '"image": {
								"@type": "ImageObject",
								"url": '.json_encode($article_img).'
							},';
						}
						$html .= '"datePublished": "'.get_the_date('c').'",
						"dateModified": '.json_encode(get_the_modified_date('c')).',
						"author": {
							"@type": "Person",
							"name": '.json_encode(get_the_author()).'
						},';
						
						if (function_exists('seopress_rich_snippets_articles_publisher_option') && seopress_rich_snippets_articles_publisher_option() !='') {
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

				$html = apply_filters('seopress_schemas_auto_article_html', $html);

				echo $html;
			}
		}

		//Local Business JSON-LD
		function seopress_automatic_rich_snippets_lb_option($schema_datas) {
			$lb_name 							= $schema_datas['name'];
			$lb_type 							= $schema_datas['type'];
			$lb_img 							= $schema_datas['img'];
			$lb_street_addr 					= $schema_datas['street_addr'];
			$lb_city 							= $schema_datas['city'];
			$lb_state 							= $schema_datas['state'];
			$lb_pc 								= $schema_datas['pc'];
			$lb_country 						= $schema_datas['country'];
			$lb_lat 							= $schema_datas['lat'];
			$lb_lon 							= $schema_datas['lon'];
			$lb_website 						= $schema_datas['website'];
			$lb_tel 							= $schema_datas['tel'];
			$lb_price 							= $schema_datas['price'];
			$lb_opening_hours 					= $schema_datas['opening_hours'];

			if ($lb_img !='') {
				$lb_img = json_encode($lb_img);
			}

			if ($lb_name !='') {
				$lb_name = json_encode($lb_name);
			}

			if ($lb_type !='') {
				$lb_type = json_encode($lb_type);
			} else {
				$lb_type = "LocalBusiness";
			}

			if ($lb_street_addr !='') {
				$lb_street_addr = json_encode($lb_street_addr);
			}

			if ($lb_city !='') {
				$lb_city = json_encode($lb_city);
			}

			if ($lb_state !='') {
				$lb_state = json_encode($lb_state);
			}

			if ($lb_pc !='') {
				$lb_pc = json_encode($lb_pc);
			}

			if ($lb_country !='') {
				$lb_country = json_encode($lb_country);
			}

			if ($lb_lat !='') {
				$lb_lat = json_encode($lb_lat);
			}

			if ($lb_lon !='') {
				$lb_lon = json_encode($lb_lon);
			}

			if ($lb_website !='') {
				$lb_website = json_encode($lb_website);
			}

			if ($lb_tel !='') {
				$lb_tel = json_encode($lb_tel);
			}

			if ($lb_price !='') {
				$lb_price = json_encode($lb_price);
			}

			if ($lb_opening_hours !='') {
				$days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

				$seopress_pro_rich_snippets_lb_opening_hours_option ='';
							
				foreach ($lb_opening_hours as $key => $day) {//DAY
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

			$html = '<script type="application/ld+json">';
			$html .= '{"@context" : "'.seopress_check_ssl().'schema.org","@type" : '.$lb_type.',';
			if (isset($lb_img)) {
				$html .= '"image": '.$lb_img.', ';
			}
			$html .= '"@id": '.json_encode(get_home_url()).',';

			if (isset($lb_street_addr) || isset($lb_city) || isset($lb_state) || isset($lb_pc) || isset($lb_country)) {
				$html .= '"address": {
					"@type": "PostalAddress",';
					if (isset($lb_street_addr)) {
						$html .= '"streetAddress": '.$lb_street_addr.',';
					}
					if (isset($lb_city)) {
						$html .= '"addressLocality": '.$lb_city.',';
					}
					if (isset($lb_state)) {
						$html .= '"addressRegion": '.$lb_state.',';
					}
					if (isset($lb_pc)) {
						$html .= '"postalCode": '.$lb_pc.',';
					}
					if (isset($lb_country)) {
						$html .= '"addressCountry": '.$lb_country;
					}
				$html .= '},';
			}

			if (isset($lb_lat) || isset($lb_lon)) {
				$html .= '"geo": {
					"@type": "GeoCoordinates",';
					if (isset($lb_lat)) {
						$html .= '"latitude": '.$lb_lat.',';
					}
					if (isset($lb_lon)) {
						$html .= '"longitude": '.$lb_lon;
					}
				$html .= '},';
			}

			if (isset($lb_website)) {
				$html .= '"url": '.$lb_website.',';
			}

			if (isset($lb_tel)) {
				$html .= '"telephone": '.$lb_tel.',';
			}

			if (isset($lb_price)) {
				$html .= '"priceRange": '.$lb_price.',';
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
			if (isset($lb_name)) {
				$html .= '"name": '.$lb_name;
			} else {
				$html .= '"name": "'.get_bloginfo('name').'"';
			}
			$html = trim($html, ',');
			$html .= '}';
			$html .= '</script>';
			$html .= "\n";

			$html = apply_filters('seopress_schemas_auto_lb_html', $html);

			echo $html;
		}

		//FAQ JSON-LD
		function seopress_automatic_rich_snippets_faq_option($schema_datas) {
			//if no data
			if(count(array_filter($schema_datas,'strlen')) != 0) {
				$faq_q 							= $schema_datas['q'];
				$faq_a 							= $schema_datas['a'];
				if (($faq_q !='') && ($faq_a !='')) {
					$html = '<script type="application/ld+json">';
					$html .= '{
						"@context": "'.seopress_check_ssl().'schema.org",
						"@type": "FAQPage",
						"name": "FAQ","mainEntity": [{"@type": "Question","name": '.json_encode($faq_q).',"answerCount": 1,"acceptedAnswer": {"@type": "Answer","text": '.json_encode($faq_a).'}}]}';
					$html .= '</script>';
					$html .= "\n";
				
					$html = apply_filters('seopress_schemas_auto_faq_html', $html);
					
					echo $html;
				}
			}
		}

		//Courses JSON-LD
		function seopress_automatic_rich_snippets_courses_option($schema_datas) {
			//if no data
			if(count(array_filter($schema_datas,'strlen')) != 0) {
				$courses_title 							= $schema_datas['title'];
				$courses_desc 							= $schema_datas['desc'];
				$courses_school 						= $schema_datas['school'];
				$courses_website 						= $schema_datas['website'];

				$html = '<script type="application/ld+json">';
				$html .= '{
						"@context": "'.seopress_check_ssl().'schema.org",
						"@type": "Course",';
						if ($courses_title !='') {
							$html .= '"name": '.json_encode($courses_title).',';
						}
						if ($courses_desc !='') {
							$html .= '"description": '.json_encode($courses_desc).',';
						}
						if ($courses_school !='') {
							$html .= '"provider": {
								"@type": "Organization",
								"name": '.json_encode($courses_school).',
								"sameAs": '.json_encode($courses_website).'
							}';
						}
						$html = trim($html, ',');
					$html .= '}';
				$html .= '</script>';
				$html .= "\n";

				$html = apply_filters('seopress_schemas_auto_course_html', $html);

				echo $html;
			}
		}

		//Recipes JSON-LD
		function seopress_automatic_rich_snippets_recipes_option($schema_datas) {
			//if no data
			if(count(array_filter($schema_datas,'strlen')) != 0) {
				$recipes_name 							= $schema_datas['name'];
				$recipes_desc 							= $schema_datas['desc'];
				$recipes_cat 							= $schema_datas['cat'];
				$recipes_img 							= $schema_datas['img'];
				$recipes_prep_time 						= $schema_datas['prep_time'];
				$recipes_cook_time 						= $schema_datas['cook_time'];
				$recipes_calories 						= $schema_datas['calories'];
				$recipes_yield 							= $schema_datas['yield'];
				$recipes_keywords 						= $schema_datas['keywords'];
				$recipes_cuisine 						= $schema_datas['cuisine'];
				$recipes_ingredient 					= $schema_datas['ingredient'];
				$recipes_instructions 					= $schema_datas['instructions'];
				
				$html = '<script type="application/ld+json">';
				$html .= '{
						"@context": "'.seopress_check_ssl().'schema.org/",';
						$html .= '"@type": "Recipe",';
						
						if ($recipes_name !='') {
							$html .= '"name": '.json_encode($recipes_name).',';
						}
						if ($recipes_cat !='') {
							$html .= '"recipeCategory": '.json_encode($recipes_cat).',';
						}
						if ($recipes_img !='') {
							$html .= '"image": '.json_encode($recipes_img).',';
						}
						if (get_the_author()) {
							$html .= '"author": {
								"@type": "Person",
								"name": '.json_encode(get_the_author()).'
							},';
						}
						if (get_the_date()) {
							$html .= '"datePublished": "'.get_the_date('Y-m-j').'",';
						}
						if ($recipes_desc !='') {
							$html .= '"description": '.json_encode($recipes_desc).',';
						}
						if ($recipes_prep_time) {
							$html .= '"prepTime": '.json_encode('PT'.$recipes_prep_time.'M').',';
						}
						if ($recipes_cook_time !='') {
							$html .= '"totalTime": '.json_encode('PT'.$recipes_cook_time.'M').',';
						}
						if ($recipes_yield !='') {
							$html .= '"recipeYield": '.json_encode($recipes_yield).',';
						}
						if ($recipes_keywords !='') {
							$html .= '"keywords": '.json_encode($recipes_keywords).',';
						}
						if ($recipes_cuisine !='') {
							$html .= '"recipeCuisine": '.json_encode($recipes_cuisine).',';
						}
						if ($recipes_ingredient !='') {
							$recipes_ingredient = preg_split('/\r\n|[\r\n]/', $recipes_ingredient);
							if(!empty($recipes_ingredient)) {
								$i = '0';
								$count = count($recipes_ingredient);

								$html .= '"recipeIngredient": [';
								foreach($recipes_ingredient as $value) {
									$html .= json_encode($value);
									if ($i < $count -1) {
										$html .= ',';
									}
									$i++;
								}
								$html .= '],';
							}
						}
						if ($recipes_instructions !='') {
							$recipes_instructions = preg_split('/\r\n|[\r\n]/', $recipes_instructions);
							if(!empty($recipes_instructions)) {
								$i = '0';
								$count = count($recipes_instructions);

								$html .= '"recipeInstructions": [';
								foreach($recipes_instructions as $value) {
									$html .= '{"@type": "HowToStep","text":'.json_encode($value).'}';
									if ($i < $count -1) {
										$html .= ',';
									}
									$i++;
								}
								$html .= '],';
							}
						}
						if ($recipes_calories !='') {
							$html .= '"nutrition": {
								"@type": "NutritionInformation",
								"calories": '.json_encode($recipes_calories).'
							}';
						}
					$html = trim($html, ',');
					$html .= '}';
				$html .= '</script>';
				$html .= "\n";

				$html = apply_filters('seopress_schemas_auto_recipe_html', $html);

				echo $html;
			}
		}

		//Jobs JSON-LD
		function seopress_automatic_rich_snippets_jobs_option($schema_datas) {
			//if no data
			if(count(array_filter($schema_datas,'strlen')) != 0) {
				$jobs_name 							= $schema_datas['name'];
				$jobs_desc 							= $schema_datas['desc'];
				$jobs_date_posted 					= $schema_datas['date_posted'];
				$jobs_valid_through 				= $schema_datas['valid_through'];
				$jobs_employment_type 				= $schema_datas['employment_type'];
				$jobs_identifier_name 				= $schema_datas['identifier_name'];
				$jobs_identifier_value 				= $schema_datas['identifier_value'];
				$jobs_hiring_organization 			= $schema_datas['hiring_organization'];
				$jobs_hiring_same_as 				= $schema_datas['hiring_same_as'];
				$jobs_hiring_logo 					= $schema_datas['hiring_logo'];
				$jobs_hiring_logo_width 			= $schema_datas['hiring_logo_width'];
				$jobs_hiring_logo_height 			= $schema_datas['hiring_logo_height'];
				$jobs_address_street 				= $schema_datas['address_street'];
				$jobs_address_locality 				= $schema_datas['address_locality'];
				$jobs_address_region 				= $schema_datas['address_region'];
				$jobs_postal_code 					= $schema_datas['postal_code'];
				$jobs_country 						= $schema_datas['country'];
				$jobs_remote 						= $schema_datas['remote'];
				$jobs_salary 						= $schema_datas['salary'];
				$jobs_salary_currency 				= $schema_datas['salary_currency'];
				$jobs_salary_unit 					= $schema_datas['salary_unit'];
				
				$html = '<script type="application/ld+json">';
				$html .= '{
						"@context": "'.seopress_check_ssl().'schema.org/",';
						$html .= '"@type": "JobPosting",';
						
						if ($jobs_name !='') {
							$html .= '"title": '.json_encode($jobs_name).',';
						}
						if ($jobs_desc !='') {
							$html .= '"description": '.json_encode($jobs_desc).',';
						}
						if ($jobs_identifier_name !='' && $jobs_identifier_value !='') {
							$html .= '"identifier": {
								"@type": "PropertyValue",
								"name": '.json_encode($jobs_identifier_name).',
								"value": '.json_encode($jobs_identifier_value).'
							  },';
						}
						if ($jobs_date_posted !='') {
							$html .= '"datePosted" : '.json_encode($jobs_date_posted).',';
						}
						if ($jobs_valid_through !='') {
							$html .= '"validThrough" : '.json_encode($jobs_valid_through).',';
						}
						if ($jobs_employment_type !='') {
							$html .= '"employmentType" : '.json_encode($jobs_employment_type).',';
						}
						if ($jobs_hiring_organization !='' && $jobs_hiring_same_as !='' && $jobs_hiring_logo !='') {
							$html .= '"hiringOrganization" : {
								"@type" : "Organization",
								"name" : '.json_encode($jobs_hiring_organization).',
								"sameAs" : '.json_encode($jobs_hiring_same_as).',
								"logo" : '.json_encode($jobs_hiring_logo).'
							  },';
						}
						if ($jobs_address_street !='' || $jobs_address_locality !='' || $jobs_address_region !='' || $jobs_postal_code !='' || $jobs_country !='') {
							$html .= '"jobLocation": {
								"@type": "Place",
									"address": {
									"@type": "PostalAddress",';
									if ($jobs_address_street !='') {
										$html .= '"streetAddress": '.json_encode($jobs_address_street).',';
									}
									if ($jobs_address_locality !='') {
										$html .= '"addressLocality": '.json_encode($jobs_address_locality).',';
									}
									if ($jobs_address_region !='') {
										$html .= '"addressRegion": '.json_encode($jobs_address_region).',';
									}
									if ($jobs_postal_code !='') {
										$html .= '"postalCode": '.json_encode($jobs_postal_code).',';
									}
									if ($jobs_country !='') {
										$html .= '"addressCountry": '.json_encode($jobs_country);
									}
								$html .= '}
								},';
						}
						if ($jobs_remote !='' && $jobs_country !='') {
							$html .= '"jobLocationType": "TELECOMMUTE",';
						}
						if ($jobs_salary !='' && $jobs_salary_currency !='' && $jobs_salary_unit !='') {
							$html .= '"baseSalary": {
								"@type": "MonetaryAmount",
								"currency": '.json_encode($jobs_salary_currency).',
								"value": {
								  "@type": "QuantitativeValue",
								  "value": '.json_encode($jobs_salary).',
								  "unitText": '.json_encode($jobs_salary_unit).'
								}
							  }';
						}
					$html = trim($html, ',');
					$html .= '}';
				$html .= '</script>';
				$html .= "\n";

				$html = apply_filters('seopress_schemas_auto_job_html', $html);

				echo $html;
			}
		}

		//Videos JSON-LD
		function seopress_automatic_rich_snippets_videos_option($schema_datas) {
			//if no data
			if(count(array_filter($schema_datas,'strlen')) != 0) {
				$videos_name 							= $schema_datas['name'];
				$videos_description 					= $schema_datas['description'];
				$videos_img 							= $schema_datas['img'];
				$videos_duration 						= $schema_datas['duration'];
				$videos_url 							= $schema_datas['url'];

				$html = '<script type="application/ld+json">';
				$html .= '{
						"@context": "'.seopress_check_ssl().'schema.org",
						"@type": "VideoObject",';
						if ($videos_name !='') {
							$html .= '"name": '.json_encode($videos_name).',';
						}
						if ($videos_description !='') {
							$html .= '"description": '.json_encode($videos_description).',';
						}
						if ($videos_img !='') {
							$html .= '"thumbnailUrl": '.json_encode($videos_img).',';
						}
						if (get_the_date()) {
							$html .= '"uploadDate": "'.get_the_date('c').'",';
						}
						if ($videos_duration !='') {
							$time    = explode(':', $videos_duration);
							$videos_duration = ($time[0] * 60.0 + $time[1] * 1.0);

							$html .= '"duration": '.json_encode('PT'.$videos_duration.'M').',';
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
						if ($videos_url !='') {
							$html .= '"contentUrl": '.json_encode($videos_url).',
							"embedUrl": '.json_encode($videos_url).'';
						}
					$html .= '}';
				$html = trim($html, ',');
				$html .= '</script>';
				$html .= "\n";

				$html = apply_filters('seopress_schemas_auto_video_html', $html);

				echo $html;
			}
		}

		//Events JSON-LD
		function seopress_automatic_rich_snippets_events_option($schema_datas) {
			//if no data
			if(count(array_filter($schema_datas,'strlen')) != 0) {
				$events_type 							= $schema_datas['type'];
				$events_name 							= $schema_datas['name'];
				$events_desc 							= $schema_datas['desc'];
				$events_img 							= $schema_datas['img'];
				$events_start_date 						= $schema_datas['start_date'];
				$events_start_time 						= $schema_datas['start_time'];
				$events_end_date 						= $schema_datas['end_date'];
				$events_end_time 						= $schema_datas['end_time'];
				$events_location_name 					= $schema_datas['location_name'];
				$events_location_url 					= $schema_datas['location_url'];
				$events_location_address 				= $schema_datas['location_address'];
				$events_offers_name 					= $schema_datas['offers_name'];
				$events_offers_cat 						= $schema_datas['offers_cat'];
				$events_offers_price 					= $schema_datas['offers_price'];
				$events_offers_price_currency 			= $schema_datas['offers_price_currency'];
				$events_offers_availability 			= $schema_datas['offers_availability'];
				$events_offers_valid_from_date 			= $schema_datas['offers_valid_from_date'];
				$events_offers_valid_from_time 			= $schema_datas['offers_valid_from_time'];
				$events_offers_url 						= $schema_datas['offers_url'];
				$events_performer 						= $schema_datas['performer'];

				if ($events_start_date !='' && $events_start_time !='') {
					$events_start_date = $events_start_date.'T'.$events_start_time;
				}

				if ($events_end_date !='' && $events_end_time !='') {
					$events_end_date = $events_end_date.'T'.$events_end_time;
				}

				$html = '<script type="application/ld+json">';
				$html .= '{
						"@context": "'.seopress_check_ssl().'schema.org",';
						if ($events_type !='') {
							$html .= '"@type": '.json_encode($events_type).',';
						}
						if ($events_name !='') {
							$html .= '"name": '.json_encode($events_name).',';
						}
						if ($events_desc !='') {
							$html .= '"description": '.json_encode($events_desc).',';
						}
						if ($events_img !='') {
							$html .= '"image": '.json_encode($events_img).',';
						}
						if ($events_location_url !='') {
							$html .= '"url": '.json_encode($events_location_url).',';
						}
						if ($events_start_date !='') {
							$html .= '"startDate": '.json_encode($events_start_date).',';
						}
						if ($events_end_date !='') {
							$html .= '"endDate": '.json_encode($events_end_date).',';
						}
						if ($events_location_name !='' && $events_location_address !='') {
							$html .= '"location": {
								"@type": "Place",
								"name": '.json_encode($events_location_name).',
								"address": '.json_encode($events_location_address).'
							},';
						}
						if ($events_offers_name !='') {
							$sp_offers = '"offers": [{
								"@type": "Offer",
								"name": '.json_encode($events_offers_name).',';
								if ($events_offers_cat !='') {
									$sp_offers .= '"category": '.json_encode($events_offers_cat).',';
								}
								if ($events_offers_price !='') {
									$sp_offers .= '"price": '.json_encode($events_offers_price).',';
								}
								if ($events_offers_price_currency !='') {
									$sp_offers .= '"priceCurrency": '.json_encode($events_offers_price_currency).',';
								}
								if ($events_offers_url !='') {
									$sp_offers .= '"url": '.json_encode($events_offers_url).',';
								}
								if ($events_offers_availability !='') {
									$sp_offers .= '"availability": '.json_encode($events_offers_availability).',';
								}
								if ($events_offers_valid_from_date !='') {
									$sp_offers .= '"validFrom": '.json_encode($events_offers_valid_from_date);
								}
							$sp_offers = trim($sp_offers,',');
							if ($events_performer !='') {
								$sp_offers .= '}],';
							} else {
								$sp_offers .= '}]';
							}
							$html .= $sp_offers;
							
						}
						if ($events_performer !='') {
							$html .= '"performer": {
								"@type": "Person",
								"name": '.json_encode($events_performer).'
							}';
						}
					$html = trim($html, ',');
					$html .= '}';
				$html .= '</script>';
				$html .= "\n";

				$html = apply_filters('seopress_schemas_auto_event_html', $html);

				echo $html;
			}
		}

		//Products JSON-LD
		function seopress_automatic_rich_snippets_products_option($schema_datas) {
			//if no data
			if(count(array_filter($schema_datas,'strlen')) != 0) {
				//Init
				global $product;

				$products_name 							= $schema_datas['name'];
				if ($products_name =='') {
					$products_name = the_title_attribute('echo=0');
				}

				$products_description 					= $schema_datas['description'];
				if ($products_description =='') {
					$products_description = wp_trim_words(esc_html(get_the_excerpt()), 30);
				}

				$products_img 							= $schema_datas['img'];
				if ($products_img =='' && get_the_post_thumbnail_url(get_the_ID(), 'large') !='') {
					$products_img = get_the_post_thumbnail_url(get_the_ID(), 'large');
				}

				$products_price 						= $schema_datas['price'];
				if (isset($product) && $products_price =='' && $product->get_price() !='') {
					$products_price = $product->get_price();
				}

				$products_price_valid_date 				= $schema_datas['price_valid_date'];
				if(isset($product) && $products_price_valid_date =='' && $product->get_date_on_sale_to() !='') {
					$products_price_valid_date = $product->get_date_on_sale_to();
					$products_price_valid_date = $products_price_valid_date->date("m-d-Y");
				}
				$products_sku 							= $schema_datas['sku'];
				if (isset($product) && $products_sku =='' && $product->get_sku() !='') {
					$products_sku = $product->get_sku();
				}

				$products_brand 						= $schema_datas['brand'];
				$products_global_ids 					= $schema_datas['global_ids'];
				$products_global_ids_value 				= $schema_datas['global_ids_value'];
				$products_currency 						= $schema_datas['currency'];
				if ($products_currency =='') {
					$products_currency = 'USD';
				}

				$products_condition 					= $schema_datas['condition'];
				if ($products_condition =='') {
					$products_condition = seopress_check_ssl().'schema.org/NewCondition';
				}

				$products_availability 					= $schema_datas['availability'];
				if ($products_availability =='') {
					$products_availability = seopress_check_ssl().'schema.org/InStock';
				}

				$html = '<script type="application/ld+json">';
				$html .= '{
					"@context": "'.seopress_check_ssl().'schema.org/",
					"@type": "Product",';
					if ($products_name) {
						$html .= '"name": '.json_encode($products_name).',';
					}
					if ($products_img !='') {
						$html .= '"image": '.json_encode($products_img).',';
					}
					if ($products_description !='') {
						$html .= '"description": '.json_encode($products_description).',';
					}
					if ($products_sku !='') {
						$html .= '"sku": '.json_encode($products_sku).',';
					}
					if ($products_global_ids !='' && $products_global_ids_value !='') {
						$html .= json_encode($products_global_ids).': '.json_encode($products_global_ids_value).',';
					}


					//brand
					if ($products_brand !='') {		
						$html .= '"brand": {
							"@type": "Thing",
							"name": '.json_encode($products_brand).'
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

					if ($products_price !='') {
						$html .= '"offers": {
							"@type": "Offer",
							"url": '.json_encode(get_permalink()).',
							"priceCurrency": '.json_encode($products_currency).',
							"price": '.json_encode($products_price).',
							"priceValidUntil": '.json_encode($products_price_valid_date).',
							"itemCondition": '.json_encode($products_condition).',
							"availability": '.json_encode($products_availability).'
						}';
					}
					$html = trim($html, ',');
					$html .= '}';
				$html .= '</script>';
				$html .= "\n";

				$html = apply_filters('seopress_schemas_auto_product_html', $html);

				echo $html;
			}
		}

		//Service JSON-LD
		function seopress_automatic_rich_snippets_services_option($schema_datas) {
			//if no data
			if(count(array_filter($schema_datas,'strlen')) != 0) {
				//Init
				global $product;

				$service_name 							= $schema_datas['name'];
				$service_type 							= $schema_datas['type'];
				$service_desc 							= $schema_datas['description'];
				$service_img 							= $schema_datas['img'];
				$service_area 							= $schema_datas['area'];
				$service_provider_name					= $schema_datas['provider_name'];
				$service_lb_img							= $schema_datas['lb_img'];
				$service_provider_mob 					= $schema_datas['provider_mobility'];
				$service_slogan 						= $schema_datas['slogan'];
				$service_street_addr 					= $schema_datas['street_addr'];
				$service_city 							= $schema_datas['city'];
				$service_state 							= $schema_datas['state'];
				$service_postal_code 					= $schema_datas['pc'];
				$service_country 						= $schema_datas['country'];
				$service_lat							= $schema_datas['lat'];
				$service_lon 							= $schema_datas['lon'];
				$service_tel 							= $schema_datas['tel'];
				$service_price 							= $schema_datas['price'];
				

				$html = '<script type="application/ld+json">';
				$html .= '{
					"@context": "'.seopress_check_ssl().'schema.org/",
					"@type": "Service",';
					if ($service_name !='') {
						$html .= '"name": '.json_encode($service_name).',';
					}
					if ($service_type !='') {
						$html .= '"serviceType": '.json_encode($service_type).',';
					}
					if ($service_desc !='') {
						$html .= '"description": '.json_encode($service_desc).',';
					}
					if ($service_img !='') {
						$html .= '"image": '.json_encode($service_img).',';
					}
					if ($service_area !='') {
						$html .= '"areaServed": '.json_encode($service_area).',';
					}
					if ($service_provider_mob !='') {
						$html .= '"providerMobility": '.json_encode($service_provider_mob).',';
					}
					if ($service_slogan !='') {
						$html .= '"slogan": '.json_encode($service_slogan).',';
					}
					//Provider
					if ($service_provider_name !='') {
						$html .= '"provider": {
							"@type": "LocalBusiness",';
						$html .= '"name": '.json_encode($service_provider_name).',';
			
						if ($service_tel !='') {
							$html .= '"telephone": '.json_encode($service_tel).',';
						}
						if ($service_lb_img !='') {
							$html .= '"image": '.json_encode($service_lb_img).',';
						}
						if ($service_price !='') {
							$html .= '"priceRange": '.json_encode($service_price).',';
						}
					
						//Address
						if (isset($service_street_addr) || isset($service_city) || isset($service_state) || isset($service_postal_code) || isset($service_country)) {
							$html .= '"address": {
								"@type": "PostalAddress",';
								if (isset($service_street_addr)) {
									$html .= '"streetAddress": '.json_encode($service_street_addr).',';
								}
								if (isset($service_city)) {
									$html .= '"addressLocality": '.json_encode($service_city).',';
								}
								if (isset($service_state)) {
									$html .= '"addressRegion": '.json_encode($service_state).',';
								}
								if (isset($service_postal_code)) {
									$html .= '"postalCode": '.json_encode($service_postal_code).',';
								}
								if (isset($service_country)) {
									$html .= '"addressCountry": '.json_encode($service_country);
								}
							$html .= '},';
						}
						//GPS
						if ($service_lat !='' || $service_lon !='') {
							$html .= '"geo": {
								"@type": "GeoCoordinates",';
								if (isset($service_lat)) {
									$html .= '"latitude": '.json_encode($service_lat).',';
								}
								if (isset($service_lon)) {
									$html .= '"longitude": '.json_encode($service_lon);
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

				$html = apply_filters('seopress_schemas_auto_service_html', $html);

				echo $html;
			}
		}

		//Review JSON-LD
		function seopress_automatic_rich_snippets_review_option($schema_datas) {
			//if no data
			if(count(array_filter($schema_datas,'strlen')) != 0) {
				$review_item 							= $schema_datas['item'];
				$review_type 							= $schema_datas['item_type'];
				$review_img 							= $schema_datas['img'];
				$review_rating 							= $schema_datas['rating'];

				if ($review_type) {
					$type = $review_type;
				} else {
					$type = 'Thing';
				}

				$html = '<script type="application/ld+json">';
				$html .= '{
					"@context": "'.seopress_check_ssl().'schema.org/",
					"@type": "Review",';
					if ($review_item) {
						$html .= '"itemReviewed":{"@type":'.json_encode($type).',"name":'.json_encode($review_item);
					}
					if ($review_item !='' && $review_img =='') {
						$html .= '},';
					} else {
						$html .= ',';
					}
					if ($review_img !='') {
						$html .= '"image": {"@type":"ImageObject","url":'.json_encode($review_img).'}';
					}
					if ($review_item !='' && $review_img !='') {
						$html .= '},';
					}
					if ($review_rating !='') {
						$html .= '"reviewRating":{"@type":"Rating","ratingValue":'.json_encode($review_rating).'},';
					}
					$html .= '"datePublished":"'.get_the_date('c').'",';
					$html .= '"author":{"@type":"Person","name":'.json_encode(get_the_author()).'}';
					$html = trim($html, ',');
				$html .= '}';
				$html .= '</script>';
				$html .= "\n";

				$html = apply_filters('seopress_schemas_auto_review_html', $html);

				echo $html;
			}
		}

		//Custom JSON-LD
		function seopress_automatic_rich_snippets_custom_option($schema_datas) {
			//if no data
			if(count(array_filter($schema_datas,'strlen')) != 0) {
				$custom 							= $schema_datas['custom'];

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

				$html = wp_specialchars_decode($custom,ENT_COMPAT);
				
				$html .= "\n";

				$html = apply_filters('seopress_schemas_auto_custom_html', $html);

				echo $html;
			}
		}

		//Dynamic variables
		global $post;
		global $product;

		/*Excerpt length*/
		$seopress_excerpt_length = 50;
		$seopress_excerpt_length = apply_filters('seopress_excerpt_length',$seopress_excerpt_length);

		/*Excerpt*/
		$seopress_excerpt ='';
		if (!is_404() && $post !='') {
			if (has_excerpt($post->ID)) {
				$seopress_excerpt = get_the_excerpt();
			}
		}
		if ($seopress_excerpt !='') {
			$seopress_get_the_excerpt = wp_trim_words(esc_attr(stripslashes_deep(wp_filter_nohtml_kses(wp_strip_all_tags(strip_shortcodes($seopress_excerpt), true)))), $seopress_excerpt_length);
		} elseif ($post !='') {
			if (get_post_field('post_content', $post->ID) !='') {
				$seopress_get_the_excerpt = wp_trim_words(esc_attr(stripslashes_deep(wp_filter_nohtml_kses(wp_strip_all_tags(strip_shortcodes(get_post_field('post_content', $post->ID), true))))), $seopress_excerpt_length);
			} else {
				$seopress_get_the_excerpt = null;
			}
		} else {
			$seopress_get_the_excerpt = null;
		}

		if ($post !='') {
			if (get_post_field('post_content', $post->ID) !='') {
				$seopress_get_the_content = wp_trim_words(esc_attr(stripslashes_deep(wp_filter_nohtml_kses(wp_strip_all_tags(strip_shortcodes(get_post_field('post_content', $post->ID), true))))), $seopress_excerpt_length);
			} else {
				$seopress_get_the_content = null;
			}
		} else {
			$seopress_get_the_content = null;
		}
		
		/*Author name*/
		$the_author_meta ='';
		$the_author_meta = get_the_author_meta('display_name', $post->post_author);

		if (!function_exists('seopress_social_knowledge_img_option')) {
			function seopress_social_knowledge_img_option() {
				$seopress_social_knowledge_img_option = get_option("seopress_social_option_name");
				if ( ! empty ( $seopress_social_knowledge_img_option ) ) {
					foreach ($seopress_social_knowledge_img_option as $key => $seopress_social_knowledge_img_value)
						$options[$key] = $seopress_social_knowledge_img_value;
					 if (isset($seopress_social_knowledge_img_option['seopress_social_knowledge_img'])) { 
					 	return $seopress_social_knowledge_img_option['seopress_social_knowledge_img'];
					 }
				}
			}
		}

		/*Date on sale from*/
		$get_date_on_sale_from ='';
		if (isset($product) && method_exists($product,'get_date_on_sale_from')) {
			$get_date_on_sale_from = $product->get_date_on_sale_from();
			if ($get_date_on_sale_from !='') {
				$get_date_on_sale_from = $get_date_on_sale_from->date("m-d-Y");
			}
		}

		/*Date on sale to*/
		$get_date_on_sale_to ='';
		if (isset($product) && method_exists($product,'get_date_on_sale_to')) {
			$get_date_on_sale_to = $product->get_date_on_sale_to();
			if ($get_date_on_sale_to !='') {
				$get_date_on_sale_to = $get_date_on_sale_to->date("m-d-Y");
			}
		}

		/*product cat*/
		$product_cat_term_list ='';
		if (taxonomy_exists('product_cat')) {
			$terms = wp_get_post_terms(get_the_ID(), 'product_cat', array("fields" => "names"));
			if (!empty($terms) && !is_wp_error($terms)) {
				$product_cat_term_list = $terms[0];
			}
		}

		/*regular price*/
		$get_regular_price ='';
		if (isset($product) && method_exists($product, 'get_regular_price')) {
			$get_regular_price = $product->get_regular_price();
		}

		/*sale price*/
		$get_sale_price ='';
		if (isset($product) && method_exists($product, 'get_sale_price')) {
			$get_sale_price = $product->get_sale_price();
		}

		/*sku*/
		$get_sku ='';
		if (isset($product) && method_exists($product, 'get_sku')) {
			$get_sku = $product->get_sku();
		}

		$sp_schemas_dyn_variables = array(
			'site_title',
			'tagline',
			'site_url',
			'post_title',
			'post_excerpt',
			'post_content',
			'post_permalink',
			'post_author_name',
			'post_date',
			'post_updated',
			'knowledge_graph_logo',
			'post_thumbnail',
			'post_author_picture',
			'product_regular_price',
			'product_sale_price',
			'product_date_from',
			'product_date_to',
			'product_sku',
			'product_category',
		);

		$sp_schemas_dyn_variables_replace = array(
			get_bloginfo('name'),
			get_bloginfo('description'),
			get_home_url(),
			the_title_attribute('echo=0'),
			$seopress_get_the_excerpt,
			$seopress_get_the_content,
			get_permalink(),
			$the_author_meta,
			get_the_date(),
			get_the_modified_date(),
			seopress_social_knowledge_img_option(),
			get_the_post_thumbnail_url($post,'full'),
			get_avatar_url(get_the_author_meta('ID')),
			$get_regular_price,
			$get_sale_price,
			$get_date_on_sale_from,
			$get_date_on_sale_to,
			$get_sku,
			$product_cat_term_list,
		);

		//Request schemas based on post type / rules
		$args = array(
		    'post_type' => 'seopress_schemas',
		    'posts_per_page' => -1,
		    //'fields' => 'ids',
		);

		$sp_schemas_query = new WP_Query( $args );
		 
		$sp_schemas_ids = array();

		if ( $sp_schemas_query->have_posts() ) {
		    while ( $sp_schemas_query->have_posts() ) {
		        $sp_schemas_query->the_post();
		        if (get_post_meta(get_the_ID(), '_seopress_pro_rich_snippets_rules', true)) {
		            if (is_singular(get_post_meta(get_the_ID(), '_seopress_pro_rich_snippets_rules', true))) {
		                $sp_schemas_ids[] = get_the_ID();
		            }
		        }
		    }
		}
		wp_reset_postdata();

		if (!empty($sp_schemas_ids)) {

	        foreach ($sp_schemas_ids as $id) {
	        	//Datas
	        	$schema_datas = array();

	        	//Type
	            $seopress_pro_rich_snippets_type 					= get_post_meta($id,'_seopress_pro_rich_snippets_type',true);

	            //Datas
	           	$seopress_pro_schemas                           	= get_post_meta($post->ID,'_seopress_pro_schemas');

	            //Article
	            if ($seopress_pro_rich_snippets_type =='articles') {
		            //Schema type
		            $schema_name 									= 'article';
		            
		            $post_meta_key = array(
		            	'type' => '_seopress_pro_rich_snippets_article_type',
		            	'title' => '_seopress_pro_rich_snippets_article_title',
		            	'img' => '_seopress_pro_rich_snippets_article_img',
		            );

		           	//Get datas
		           	$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

		           	//Output schema in JSON-LD
		           	seopress_automatic_rich_snippets_articles_option($schema_datas);
		        }

		        //Local Business
	            if ($seopress_pro_rich_snippets_type =='localbusiness') {
		            //Schema type
		            $schema_name 									= 'lb';
		            
		            $post_meta_key = array(
		            	'name' => '_seopress_pro_rich_snippets_lb_name',
		            	'type' => '_seopress_pro_rich_snippets_lb_type',
		            	'img' => '_seopress_pro_rich_snippets_lb_img',
		            	'street_addr' => '_seopress_pro_rich_snippets_lb_street_addr',
		            	'city' => '_seopress_pro_rich_snippets_lb_city',
		            	'state' => '_seopress_pro_rich_snippets_lb_state',
		            	'pc' => '_seopress_pro_rich_snippets_lb_pc',
		            	'country' => '_seopress_pro_rich_snippets_lb_country',
		            	'lat' => '_seopress_pro_rich_snippets_lb_lat',
		            	'lon' => '_seopress_pro_rich_snippets_lb_lon',
		            	'website' => '_seopress_pro_rich_snippets_lb_website',
		            	'tel' => '_seopress_pro_rich_snippets_lb_tel',
		            	'price' => '_seopress_pro_rich_snippets_lb_price',
		            	'opening_hours' => '_seopress_pro_rich_snippets_lb_opening_hours',
		            );

		           	//Get datas
		           	$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

		           	//Output schema in JSON-LD
		           	seopress_automatic_rich_snippets_lb_option($schema_datas);
		        }

		        //FAQ
	            if ($seopress_pro_rich_snippets_type =='faq') {
		            //Schema type
		            $schema_name 									= 'faq';

		            $post_meta_key = array(
		            	'q' => '_seopress_pro_rich_snippets_faq_q',
		            	'a' => '_seopress_pro_rich_snippets_faq_a',
		            );

		           	//Get datas
		           	$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

		           	//Output schema in JSON-LD
		           	seopress_automatic_rich_snippets_faq_option($schema_datas);
				}
				
		        //Courses
	            if ($seopress_pro_rich_snippets_type =='courses') {
		            //Schema type
		            $schema_name 									= 'courses';

		            $post_meta_key = array(
		            	'title' => '_seopress_pro_rich_snippets_courses_title',
		            	'desc' => '_seopress_pro_rich_snippets_courses_desc',
		            	'school' => '_seopress_pro_rich_snippets_courses_school',
		            	'website' => '_seopress_pro_rich_snippets_courses_website',
		            );

		           	//Get datas
		           	$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

		           	//Output schema in JSON-LD
		           	seopress_automatic_rich_snippets_courses_option($schema_datas);
		        }

		        //Recipes
	            if ($seopress_pro_rich_snippets_type =='recipes') {
		            //Schema type
		            $schema_name 									= 'recipes';
		            
		            $post_meta_key = array(
		            	'name' => '_seopress_pro_rich_snippets_recipes_name',
		            	'desc' => '_seopress_pro_rich_snippets_recipes_desc',
		            	'cat' => '_seopress_pro_rich_snippets_recipes_cat',
		            	'img' => '_seopress_pro_rich_snippets_recipes_img',
		            	'prep_time' => '_seopress_pro_rich_snippets_recipes_prep_time',
		            	'cook_time' => '_seopress_pro_rich_snippets_recipes_cook_time',
		            	'calories' => '_seopress_pro_rich_snippets_recipes_calories',
		            	'yield' => '_seopress_pro_rich_snippets_recipes_yield',
		            	'keywords' => '_seopress_pro_rich_snippets_recipes_keywords',
		            	'cuisine' => '_seopress_pro_rich_snippets_recipes_cuisine',
		            	'ingredient' => '_seopress_pro_rich_snippets_recipes_ingredient',
		            	'instructions' => '_seopress_pro_rich_snippets_recipes_instructions',
		            );

		           	//Get datas
		           	$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

		           	//Output schema in JSON-LD
		           	seopress_automatic_rich_snippets_recipes_option($schema_datas);
				}
				
				//Jobs
				if ($seopress_pro_rich_snippets_type =='jobs') {
					//Schema type
					$schema_name 									= 'jobs';
					
					$post_meta_key = array(
						'name' => '_seopress_pro_rich_snippets_jobs_name',
						'desc' => '_seopress_pro_rich_snippets_jobs_desc',
						'date_posted' => '_seopress_pro_rich_snippets_jobs_date_posted',
						'valid_through' => '_seopress_pro_rich_snippets_jobs_valid_through',
						'employment_type' => '_seopress_pro_rich_snippets_jobs_employment_type',
						'identifier_name' => '_seopress_pro_rich_snippets_jobs_identifier_name',
						'identifier_value' => '_seopress_pro_rich_snippets_jobs_identifier_value',
						'hiring_organization' => '_seopress_pro_rich_snippets_jobs_hiring_organization',
						'hiring_same_as' => '_seopress_pro_rich_snippets_jobs_hiring_same_as',
						'hiring_logo' => '_seopress_pro_rich_snippets_jobs_hiring_logo',
						'hiring_logo_width' => '_seopress_pro_rich_snippets_jobs_hiring_logo_width',
						'hiring_logo_height' => '_seopress_pro_rich_snippets_jobs_hiring_logo_height',
						'address_street' => '_seopress_pro_rich_snippets_jobs_address_street',
						'address_locality' => '_seopress_pro_rich_snippets_jobs_address_locality',
						'address_region' => '_seopress_pro_rich_snippets_jobs_address_region',
						'postal_code' => '_seopress_pro_rich_snippets_jobs_postal_code',
						'country' => '_seopress_pro_rich_snippets_jobs_country',
						'remote' => '_seopress_pro_rich_snippets_jobs_remote',
						'salary' => '_seopress_pro_rich_snippets_jobs_salary',
						'salary_currency' => '_seopress_pro_rich_snippets_jobs_salary_currency',
						'salary_unit' => '_seopress_pro_rich_snippets_jobs_salary_unit',
					);

					//Get datas
					$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

					//Output schema in JSON-LD
					seopress_automatic_rich_snippets_jobs_option($schema_datas);
				}

		        //Videos
	            if ($seopress_pro_rich_snippets_type =='videos') {
		            //Schema type
		            $schema_name 									= 'videos';
		            
		            $post_meta_key = array(
		            	'name' => '_seopress_pro_rich_snippets_videos_name',
		            	'description' => '_seopress_pro_rich_snippets_videos_description',
		            	'img' => '_seopress_pro_rich_snippets_videos_img',
		            	'duration' => '_seopress_pro_rich_snippets_videos_duration',
		            	'url' => '_seopress_pro_rich_snippets_videos_url',
		            );

		           	//Get datas
		           	$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

		           	//Output schema in JSON-LD
		           	seopress_automatic_rich_snippets_videos_option($schema_datas);
		        }

		        //Events
	            if ($seopress_pro_rich_snippets_type =='events') {
		            //Schema type
		            $schema_name 									= 'events';
		            
		            $post_meta_key = array(
		            	'type' => '_seopress_pro_rich_snippets_events_type',
		            	'name' => '_seopress_pro_rich_snippets_events_name',
		            	'desc' => '_seopress_pro_rich_snippets_events_desc',
		            	'img' => '_seopress_pro_rich_snippets_events_img',
		            	'start_date' => '_seopress_pro_rich_snippets_events_start_date',
		            	'start_time' => '_seopress_pro_rich_snippets_events_start_time',
		            	'end_date' => '_seopress_pro_rich_snippets_events_end_date',
		            	'end_time' => '_seopress_pro_rich_snippets_events_end_time',
		            	'location_name' => '_seopress_pro_rich_snippets_events_location_name',
		            	'location_url' => '_seopress_pro_rich_snippets_events_location_url',
		            	'location_address' => '_seopress_pro_rich_snippets_events_location_address',
		            	'offers_name' => '_seopress_pro_rich_snippets_events_offers_name',
		            	'offers_cat' => '_seopress_pro_rich_snippets_events_offers_cat',
		            	'offers_price' => '_seopress_pro_rich_snippets_events_offers_price',
		            	'offers_price_currency' => '_seopress_pro_rich_snippets_events_offers_price_currency',
		            	'offers_availability' => '_seopress_pro_rich_snippets_events_offers_availability',
		            	'offers_valid_from_date' => '_seopress_pro_rich_snippets_events_offers_valid_from_date',
		            	'offers_valid_from_time' => '_seopress_pro_rich_snippets_events_offers_valid_from_time',
		            	'offers_url' => '_seopress_pro_rich_snippets_events_offers_url',
		            	'performer' => '_seopress_pro_rich_snippets_events_performer',
		            );

		           	//Get datas
		           	$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

		           	//Output schema in JSON-LD
		           	seopress_automatic_rich_snippets_events_option($schema_datas);
		        }

		        //Products
	            if ($seopress_pro_rich_snippets_type =='products') {
		            //Schema type
		            $schema_name 									= 'product';
		            
		            $post_meta_key = array(
		            	'name' => '_seopress_pro_rich_snippets_product_name',
		            	'description' => '_seopress_pro_rich_snippets_product_description',
		            	'img' => '_seopress_pro_rich_snippets_product_img',
		            	'price' => '_seopress_pro_rich_snippets_product_price',
		            	'price_valid_date' => '_seopress_pro_rich_snippets_product_price_valid_date',
		            	'sku' => '_seopress_pro_rich_snippets_product_sku',
		            	'brand' => '_seopress_pro_rich_snippets_product_brand',
		            	'global_ids' => '_seopress_pro_rich_snippets_product_global_ids',
		            	'global_ids_value' => '_seopress_pro_rich_snippets_product_global_ids_value',
		            	'currency' => '_seopress_pro_rich_snippets_product_price_currency',
		            	'condition' => '_seopress_pro_rich_snippets_product_condition',
		            	'availability' => '_seopress_pro_rich_snippets_product_availability',
		            );

		           	//Get datas
		           	$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

		           	//Output schema in JSON-LD
		           	seopress_automatic_rich_snippets_products_option($schema_datas);
				}
				
				//Service
	            if ($seopress_pro_rich_snippets_type =='services') {
		            //Schema type
		            $schema_name 									= 'service';
		            
		            $post_meta_key = array(
		            	'name' => '_seopress_pro_rich_snippets_service_name',
		            	'type' => '_seopress_pro_rich_snippets_service_type',
		            	'description' => '_seopress_pro_rich_snippets_service_description',
		            	'img' => '_seopress_pro_rich_snippets_service_img',
		            	'area' => '_seopress_pro_rich_snippets_service_area',
		            	'provider_name' => '_seopress_pro_rich_snippets_service_provider_name',
		            	'lb_img' => '_seopress_pro_rich_snippets_service_lb_img',
		            	'provider_mobility' => '_seopress_pro_rich_snippets_service_provider_mobility',
		            	'slogan' => '_seopress_pro_rich_snippets_service_slogan',
		            	'street_addr' => '_seopress_pro_rich_snippets_service_street_addr',
		            	'city' => '_seopress_pro_rich_snippets_service_city',
		            	'state' => '_seopress_pro_rich_snippets_service_state',
		            	'pc' => '_seopress_pro_rich_snippets_service_pc',
		            	'country' => '_seopress_pro_rich_snippets_service_country',
		            	'lat' => '_seopress_pro_rich_snippets_service_lat',
		            	'lon' => '_seopress_pro_rich_snippets_service_lon',
		            	'tel' => '_seopress_pro_rich_snippets_service_tel',
		            	'price' => '_seopress_pro_rich_snippets_service_price',
		            );

		           	//Get datas
		           	$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

		           	//Output schema in JSON-LD
		           	seopress_automatic_rich_snippets_services_option($schema_datas);
		        }

		        //Review
	            if ($seopress_pro_rich_snippets_type =='review') {
		            //Schema type
		            $schema_name 									= 'review';
		            
		            $post_meta_key = array(
		            	'item' => '_seopress_pro_rich_snippets_review_item',
		            	'item_type' => '_seopress_pro_rich_snippets_review_item_type',
		            	'img' => '_seopress_pro_rich_snippets_review_img',
		            	'rating' => '_seopress_pro_rich_snippets_review_rating',
		            );

		           	//Get datas
		           	$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

		           	//Output schema in JSON-LD
		           	seopress_automatic_rich_snippets_review_option($schema_datas);
				}
				
				//Custom
	            if ($seopress_pro_rich_snippets_type =='custom') {
		            //Schema type
		            $schema_name 									= 'custom';
		            
		            $post_meta_key = array(
		            	'custom' => '_seopress_pro_rich_snippets_custom',
		            );

		           	//Get datas
		           	$schema_datas = seopress_automatic_rich_snippets_manual_option($id, $schema_name, $post_meta_key, $seopress_pro_schemas, $sp_schemas_dyn_variables, $sp_schemas_dyn_variables_replace);

		           	//Output schema in JSON-LD
		           	seopress_automatic_rich_snippets_custom_option($schema_datas);
		        }
			}
		}
	}
}