<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

///////////////////////////////////////////////////////////////////////////////////////////////////
//Requests schemas using WP Query
///////////////////////////////////////////////////////////////////////////////////////////////////
global $post;
$tmp = $post;

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
            if (get_current_screen()->post_type == get_post_meta(get_the_ID(), '_seopress_pro_rich_snippets_rules', true)) {
                $sp_schemas_ids[] = get_the_ID();
            }
        }
    }
    wp_reset_postdata();
}

$post = $tmp;

///////////////////////////////////////////////////////////////////////////////////////////////////
//Display schemas inside Automatic tab
///////////////////////////////////////////////////////////////////////////////////////////////////
if (!empty($sp_schemas_ids)) {
	foreach ($sp_schemas_ids as $id) {

		//All datas
		$seopress_pro_schemas                               = get_post_meta($post->ID,'_seopress_pro_schemas');

		//Type
		$seopress_pro_rich_snippets_type 					= get_post_meta($id,'_seopress_pro_rich_snippets_type',true);

		//Article
		if ($seopress_pro_rich_snippets_type == 'articles') {
			$seopress_pro_rich_snippets_article_title           = get_post_meta($id,'_seopress_pro_rich_snippets_article_title',true);
			$check_article_title = isset($seopress_pro_schemas[0][$id]['rich_snippets_article']['title']) ? $seopress_pro_schemas[0][$id]['rich_snippets_article']['title'] : NULL;

			$seopress_pro_rich_snippets_article_img           	= get_post_meta($id,'_seopress_pro_rich_snippets_article_img',true);
			$check_article_img = isset($seopress_pro_schemas[0][$id]['rich_snippets_article']['img']) ? $seopress_pro_schemas[0][$id]['rich_snippets_article']['img'] : NULL;
		}
		//Business
		if ($seopress_pro_rich_snippets_type == 'localbusiness') {
			$seopress_pro_rich_snippets_lb_name           		= get_post_meta($id,'_seopress_pro_rich_snippets_lb_name',true);
			$check_lb_name = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['name'] : NULL;

			$seopress_pro_rich_snippets_lb_type           		= get_post_meta($id,'_seopress_pro_rich_snippets_lb_type',true);
			$check_lb_type = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['type']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['type'] : NULL;

			$seopress_pro_rich_snippets_lb_img           		= get_post_meta($id,'_seopress_pro_rich_snippets_lb_img',true);
			$check_lb_img = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['img']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['img'] : NULL;

			$seopress_pro_rich_snippets_lb_street_addr          = get_post_meta($id,'_seopress_pro_rich_snippets_lb_street_addr',true);
			$check_lb_street_addr = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['street_addr']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['street_addr'] : NULL;

			$seopress_pro_rich_snippets_lb_city          		= get_post_meta($id,'_seopress_pro_rich_snippets_lb_city',true);
			$check_lb_city = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['city']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['city'] : NULL;

			$seopress_pro_rich_snippets_lb_state          		= get_post_meta($id,'_seopress_pro_rich_snippets_lb_state',true);
			$check_lb_state = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['state']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['state'] : NULL;

			$seopress_pro_rich_snippets_lb_pc          			= get_post_meta($id,'_seopress_pro_rich_snippets_lb_pc',true);
			$check_lb_pc = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['pc']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['pc'] : NULL;

			$seopress_pro_rich_snippets_lb_country          	= get_post_meta($id,'_seopress_pro_rich_snippets_lb_country',true);
			$check_lb_country = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['country']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['country'] : NULL;

			$seopress_pro_rich_snippets_lb_lat          		= get_post_meta($id,'_seopress_pro_rich_snippets_lb_lat',true);
			$check_lb_lat = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['lat']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['lat'] : NULL;

			$seopress_pro_rich_snippets_lb_lon          		= get_post_meta($id,'_seopress_pro_rich_snippets_lb_lon',true);
			$check_lb_lon = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['lon']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['lon'] : NULL;

			$seopress_pro_rich_snippets_lb_website          	= get_post_meta($id,'_seopress_pro_rich_snippets_lb_website',true);
			$check_lb_website = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['website']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['website'] : NULL;

			$seopress_pro_rich_snippets_lb_tel          		= get_post_meta($id,'_seopress_pro_rich_snippets_lb_tel',true);
			$check_lb_tel = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['tel']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['tel'] : NULL;

			$seopress_pro_rich_snippets_lb_price          		= get_post_meta($id,'_seopress_pro_rich_snippets_lb_price',true);
			$check_lb_price = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['price']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['price'] : NULL;

			$check_lb_opening_hours = isset($seopress_pro_schemas[0][$id]['rich_snippets_lb']['opening_hours']) ? $seopress_pro_schemas[0][$id]['rich_snippets_lb']['opening_hours'] : NULL;
		}

		//FAQ
		if ($seopress_pro_rich_snippets_type == 'faq') {
			$seopress_pro_rich_snippets_faq_q          			= get_post_meta($id,'_seopress_pro_rich_snippets_faq_q',true);
			$check_faq_q = isset($seopress_pro_schemas[0][$id]['rich_snippets_faq']['q']) ? $seopress_pro_schemas[0][$id]['rich_snippets_faq']['q'] : NULL;

			$seopress_pro_rich_snippets_faq_a          			= get_post_meta($id,'_seopress_pro_rich_snippets_faq_a',true);
			$check_faq_a = isset($seopress_pro_schemas[0][$id]['rich_snippets_faq']['a']) ? $seopress_pro_schemas[0][$id]['rich_snippets_faq']['a'] : NULL;
		}

		//Course
		if ($seopress_pro_rich_snippets_type == 'courses') {
			$seopress_pro_rich_snippets_courses_title          	= get_post_meta($id,'_seopress_pro_rich_snippets_courses_title',true);
			$check_courses_title = isset($seopress_pro_schemas[0][$id]['rich_snippets_courses']['title']) ? $seopress_pro_schemas[0][$id]['rich_snippets_courses']['title'] : NULL;

			$seopress_pro_rich_snippets_courses_desc          	= get_post_meta($id,'_seopress_pro_rich_snippets_courses_desc',true);
			$check_courses_desc = isset($seopress_pro_schemas[0][$id]['rich_snippets_courses']['desc']) ? $seopress_pro_schemas[0][$id]['rich_snippets_courses']['desc'] : NULL;

			$seopress_pro_rich_snippets_courses_school          = get_post_meta($id,'_seopress_pro_rich_snippets_courses_school',true);
			$check_courses_desc = isset($seopress_pro_schemas[0][$id]['rich_snippets_courses']['school']) ? $seopress_pro_schemas[0][$id]['rich_snippets_courses']['school'] : NULL;

			$seopress_pro_rich_snippets_courses_website         = get_post_meta($id,'_seopress_pro_rich_snippets_courses_website',true);
			$check_courses_website = isset($seopress_pro_schemas[0][$id]['rich_snippets_courses']['website']) ? $seopress_pro_schemas[0][$id]['rich_snippets_courses']['website'] : NULL;

			$seopress_pro_rich_snippets_courses_school         = get_post_meta($id,'_seopress_pro_rich_snippets_courses_school',true);
			$check_courses_school = isset($seopress_pro_schemas[0][$id]['rich_snippets_courses']['school']) ? $seopress_pro_schemas[0][$id]['rich_snippets_courses']['school'] : NULL;
		}

		//Recipe
		if ($seopress_pro_rich_snippets_type == 'recipes') {
			$seopress_pro_rich_snippets_recipes_name          	= get_post_meta($id,'_seopress_pro_rich_snippets_recipes_name',true);
			$check_recipes_name = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['name'] : NULL;

			$seopress_pro_rich_snippets_recipes_desc          	= get_post_meta($id,'_seopress_pro_rich_snippets_recipes_desc',true);
			$check_recipes_desc = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['desc']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['desc'] : NULL;

			$seopress_pro_rich_snippets_recipes_cat          	= get_post_meta($id,'_seopress_pro_rich_snippets_recipes_cat',true);
			$check_recipes_cat = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['cat']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['cat'] : NULL;

			$seopress_pro_rich_snippets_recipes_img          	= get_post_meta($id,'_seopress_pro_rich_snippets_recipes_img',true);
			$check_recipes_img = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['img']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['img'] : NULL;

			$seopress_pro_rich_snippets_recipes_prep_time      	= get_post_meta($id,'_seopress_pro_rich_snippets_recipes_prep_time',true);
			$check_recipes_prep_time = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['prep_time']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['prep_time'] : NULL;

			$seopress_pro_rich_snippets_recipes_cook_time      	= get_post_meta($id,'_seopress_pro_rich_snippets_recipes_cook_time',true);
			$check_recipes_cook_time = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['cook_time']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['cook_time'] : NULL;

			$seopress_pro_rich_snippets_recipes_calories      	= get_post_meta($id,'_seopress_pro_rich_snippets_recipes_calories',true);
			$check_recipes_calories = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['calories']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['calories'] : NULL;

			$seopress_pro_rich_snippets_recipes_yield      		= get_post_meta($id,'_seopress_pro_rich_snippets_recipes_yield',true);
			$check_recipes_yield = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['yield']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['yield'] : NULL;
			
			$seopress_pro_rich_snippets_recipes_keywords      	= get_post_meta($id,'_seopress_pro_rich_snippets_recipes_keywords',true);
			$check_recipes_keywords = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['keywords']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['keywords'] : NULL;
			
			$seopress_pro_rich_snippets_recipes_cuisine      	= get_post_meta($id,'_seopress_pro_rich_snippets_recipes_cuisine',true);
			$check_recipes_cuisine = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['cuisine']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['cuisine'] : NULL;
			
			$seopress_pro_rich_snippets_recipes_ingredient      = get_post_meta($id,'_seopress_pro_rich_snippets_recipes_ingredient',true);
			$check_recipes_ingredient = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['ingredient']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['ingredient'] : NULL;
			
			$seopress_pro_rich_snippets_recipes_instructions    = get_post_meta($id,'_seopress_pro_rich_snippets_recipes_instructions',true);
			$check_recipes_instructions = isset($seopress_pro_schemas[0][$id]['rich_snippets_recipes']['instructions']) ? $seopress_pro_schemas[0][$id]['rich_snippets_recipes']['instructions'] : NULL;
		}

		//Job
		if ($seopress_pro_rich_snippets_type == 'jobs') {
			$seopress_pro_rich_snippets_jobs_name          		= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_name',true);
			$check_jobs_name 									= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['name'] : NULL;

			$seopress_pro_rich_snippets_jobs_desc          		= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_desc',true);
			$check_jobs_desc 									= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['desc']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['desc'] : NULL;

			$seopress_pro_rich_snippets_jobs_date_posted        = get_post_meta($id,'_seopress_pro_rich_snippets_jobs_date_posted',true);
			$check_jobs_date_posted 							= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['date_posted']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['date_posted'] : NULL;

			$seopress_pro_rich_snippets_jobs_valid_through      = get_post_meta($id,'_seopress_pro_rich_snippets_jobs_valid_through',true);
			$check_jobs_valid_through 							= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['valid_through']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['valid_through'] : NULL;

			$seopress_pro_rich_snippets_jobs_employment_type    = get_post_meta($id,'_seopress_pro_rich_snippets_jobs_employment_type',true);
			$check_jobs_employment_type 						= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['employment_type']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['employment_type'] : NULL;

			$seopress_pro_rich_snippets_jobs_identifier_name   	= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_identifier_name',true);
			$check_jobs_identifier_name 						= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['identifier_name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['identifier_name'] : NULL;

			$seopress_pro_rich_snippets_jobs_identifier_value   = get_post_meta($id,'_seopress_pro_rich_snippets_jobs_identifier_value',true);
			$check_jobs_identifier_value 						= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['identifier_value']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['identifier_value'] : NULL;

			$seopress_pro_rich_snippets_jobs_hiring_organization	= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_hiring_organization',true);
			$check_jobs_hiring_organization 						= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['hiring_organization']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['hiring_organization'] : NULL;

			$seopress_pro_rich_snippets_jobs_hiring_same_as   	= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_hiring_same_as',true);
			$check_jobs_hiring_same_as 							= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['hiring_same_as']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['hiring_same_as'] : NULL;
			
			$seopress_pro_rich_snippets_jobs_hiring_logo   		= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_hiring_logo',true);
			$check_jobs_hiring_logo 							= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['hiring_logo']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['hiring_logo'] : NULL;

			$seopress_pro_rich_snippets_jobs_address_street   	= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_address_street',true);
			$check_jobs_address_street 							= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['address_street']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['address_street'] : NULL;

			$seopress_pro_rich_snippets_jobs_address_locality   = get_post_meta($id,'_seopress_pro_rich_snippets_jobs_address_locality',true);
			$check_jobs_address_locality 						= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['address_locality']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['address_locality'] : NULL;

			$seopress_pro_rich_snippets_jobs_address_region   	= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_address_region',true);
			$check_jobs_address_region 							= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['address_region']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['address_region'] : NULL;

			$seopress_pro_rich_snippets_jobs_postal_code   		= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_postal_code',true);
			$check_jobs_postal_code 							= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['postal_code']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['postal_code'] : NULL;

			$seopress_pro_rich_snippets_jobs_country   			= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_country',true);
			$check_jobs_country 								= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['country']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['country'] : NULL;
			
			$seopress_pro_rich_snippets_jobs_remote   			= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_remote',true);
			$check_jobs_remote 									= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['remote']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['remote'] : NULL;
			
			$seopress_pro_rich_snippets_jobs_salary   			= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_salary',true);
			$check_jobs_salary 									= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['salary']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['salary'] : NULL;

			$seopress_pro_rich_snippets_jobs_salary_currency   	= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_salary_currency',true);
			$check_jobs_salary_currency 						= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['salary_currency']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['salary_currency'] : NULL;

			$seopress_pro_rich_snippets_jobs_salary_unit   		= get_post_meta($id,'_seopress_pro_rich_snippets_jobs_salary_unit',true);
			$check_jobs_salary_unit 							= isset($seopress_pro_schemas[0][$id]['rich_snippets_jobs']['salary_unit']) ? $seopress_pro_schemas[0][$id]['rich_snippets_jobs']['salary_unit'] : NULL;
		}

		//Video
		if ($seopress_pro_rich_snippets_type == 'videos') {
			$seopress_pro_rich_snippets_videos_name      		= get_post_meta($id,'_seopress_pro_rich_snippets_videos_name',true);
			$check_videos_name = isset($seopress_pro_schemas[0][$id]['rich_snippets_videos']['name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_videos']['name'] : NULL;

			$seopress_pro_rich_snippets_videos_description      = get_post_meta($id,'_seopress_pro_rich_snippets_videos_description',true);
			$check_videos_description = isset($seopress_pro_schemas[0][$id]['rich_snippets_videos']['description']) ? $seopress_pro_schemas[0][$id]['rich_snippets_videos']['description'] : NULL;

			$seopress_pro_rich_snippets_videos_img      		= get_post_meta($id,'_seopress_pro_rich_snippets_videos_img',true);
			$check_videos_img = isset($seopress_pro_schemas[0][$id]['rich_snippets_videos']['img']) ? $seopress_pro_schemas[0][$id]['rich_snippets_videos']['img'] : NULL;

			$seopress_pro_rich_snippets_videos_duration      	= get_post_meta($id,'_seopress_pro_rich_snippets_videos_duration',true);
			$check_videos_duration = isset($seopress_pro_schemas[0][$id]['rich_snippets_videos']['duration']) ? $seopress_pro_schemas[0][$id]['rich_snippets_videos']['duration'] : NULL;

			$seopress_pro_rich_snippets_videos_url      		= get_post_meta($id,'_seopress_pro_rich_snippets_videos_url',true);
			$check_videos_url = isset($seopress_pro_schemas[0][$id]['rich_snippets_videos']['url']) ? $seopress_pro_schemas[0][$id]['rich_snippets_videos']['url'] : NULL;
		}

		//Events
		if ($seopress_pro_rich_snippets_type == 'events') {
			$seopress_pro_rich_snippets_events_type      		= get_post_meta($id,'_seopress_pro_rich_snippets_events_type',true);
			$check_events_type = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['type']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['type'] : NULL;

			$seopress_pro_rich_snippets_events_name      		= get_post_meta($id,'_seopress_pro_rich_snippets_events_name',true);
			$check_events_name = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['name'] : NULL;

			$seopress_pro_rich_snippets_events_desc      		= get_post_meta($id,'_seopress_pro_rich_snippets_events_desc',true);
			$check_events_desc = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['desc']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['desc'] : NULL;

			$seopress_pro_rich_snippets_events_img      		= get_post_meta($id,'_seopress_pro_rich_snippets_events_img',true);
			$check_events_img = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['img']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['img'] : NULL;

			$seopress_pro_rich_snippets_events_start_date      	= get_post_meta($id,'_seopress_pro_rich_snippets_events_start_date',true);
			$check_events_start_date = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['start_date']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['start_date'] : NULL;

			$seopress_pro_rich_snippets_events_start_time      	= get_post_meta($id,'_seopress_pro_rich_snippets_events_start_time',true);
			$check_events_start_time = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['start_time']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['start_time'] : NULL;

			$seopress_pro_rich_snippets_events_end_date      	= get_post_meta($id,'_seopress_pro_rich_snippets_events_end_date',true);
			$check_events_end_date = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['end_date']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['end_date'] : NULL;

			$seopress_pro_rich_snippets_events_end_time      	= get_post_meta($id,'_seopress_pro_rich_snippets_events_end_time',true);
			$check_events_end_time = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['end_time']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['end_time'] : NULL;

			$seopress_pro_rich_snippets_events_location_name    = get_post_meta($id,'_seopress_pro_rich_snippets_events_location_name',true);
			$check_events_location_name = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['location_name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['location_name'] : NULL;

			$seopress_pro_rich_snippets_events_location_url    	= get_post_meta($id,'_seopress_pro_rich_snippets_events_location_url',true);
			$check_events_location_url = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['location_url']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['location_url'] : NULL;

			$seopress_pro_rich_snippets_events_location_address = get_post_meta($id,'_seopress_pro_rich_snippets_events_location_address',true);
			$check_events_location_address = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['location_address']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['location_address'] : NULL;

			$seopress_pro_rich_snippets_events_offers_name 		= get_post_meta($id,'_seopress_pro_rich_snippets_events_offers_name',true);
			$check_events_offers_name = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_name'] : NULL;

			$seopress_pro_rich_snippets_events_offers_cat 		= get_post_meta($id,'_seopress_pro_rich_snippets_events_offers_cat',true);
			$check_events_offers_cat = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_cat']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_cat'] : NULL;

			$seopress_pro_rich_snippets_events_offers_price 	= get_post_meta($id,'_seopress_pro_rich_snippets_events_offers_price',true);
			$check_events_offers_price = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_price']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_price'] : NULL;

			$seopress_pro_rich_snippets_events_offers_price_currency 	= get_post_meta($id,'_seopress_pro_rich_snippets_events_offers_price_currency',true);
			$check_events_offers_price_currency = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_price_currency']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_price_currency'] : NULL;

			$seopress_pro_rich_snippets_events_offers_availability 	= get_post_meta($id,'_seopress_pro_rich_snippets_events_offers_availability',true);
			$check_events_offers_availability = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_availability']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_availability'] : NULL;

			$seopress_pro_rich_snippets_events_offers_valid_from_date 	= get_post_meta($id,'_seopress_pro_rich_snippets_events_offers_valid_from_date',true);
			$check_events_offers_valid_from_date = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_valid_from_date']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_valid_from_date'] : NULL;

			$seopress_pro_rich_snippets_events_offers_valid_from_time 	= get_post_meta($id,'_seopress_pro_rich_snippets_events_offers_valid_from_time',true);
			$check_events_offers_valid_from_time = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_valid_from_time']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_valid_from_time'] : NULL;

			$seopress_pro_rich_snippets_events_offers_url 	= get_post_meta($id,'_seopress_pro_rich_snippets_events_offers_url',true);
			$check_events_offers_url = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_url']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['offers_url'] : NULL;

			$seopress_pro_rich_snippets_events_performer 	= get_post_meta($id,'_seopress_pro_rich_snippets_events_performer',true);
			$check_events_performer = isset($seopress_pro_schemas[0][$id]['rich_snippets_events']['performer']) ? $seopress_pro_schemas[0][$id]['rich_snippets_events']['performer'] : NULL;
		}

		//Products
		if ($seopress_pro_rich_snippets_type == 'products') {
			$seopress_pro_rich_snippets_product_name 		= get_post_meta($id,'_seopress_pro_rich_snippets_product_name',true);
			$check_product_name = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['name'] : NULL;

			$seopress_pro_rich_snippets_product_description = get_post_meta($id,'_seopress_pro_rich_snippets_product_description',true);
			$check_product_description = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['description']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['description'] : NULL;

			$seopress_pro_rich_snippets_product_img 		= get_post_meta($id,'_seopress_pro_rich_snippets_product_img',true);
			$check_product_img = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['img']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['img'] : NULL;

			$seopress_pro_rich_snippets_product_price 		= get_post_meta($id,'_seopress_pro_rich_snippets_product_price',true);
			$check_product_price = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['price']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['price'] : NULL;

			$seopress_pro_rich_snippets_product_price_valid_date = get_post_meta($id,'_seopress_pro_rich_snippets_product_price_valid_date',true);
			$check_product_price_valid_date = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['price_valid_date']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['price_valid_date'] : NULL;

			$seopress_pro_rich_snippets_product_sku 		= get_post_meta($id,'_seopress_pro_rich_snippets_product_sku',true);
			$check_product_sku = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['sku']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['sku'] : NULL;

			$seopress_pro_rich_snippets_product_brand 		= get_post_meta($id,'_seopress_pro_rich_snippets_product_brand',true);
			$check_product_brand = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['brand']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['brand'] : NULL;

			$seopress_pro_rich_snippets_product_global_ids 	= get_post_meta($id,'_seopress_pro_rich_snippets_product_global_ids',true);
			$check_product_global_ids = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['global_ids']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['global_ids'] : NULL;

			$seopress_pro_rich_snippets_product_global_ids_value 	= get_post_meta($id,'_seopress_pro_rich_snippets_product_global_ids_value',true);
			$check_product_global_ids_value = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['global_ids_value']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['global_ids_value'] : NULL;
			
			$seopress_pro_rich_snippets_product_price_currency 	= get_post_meta($id,'_seopress_pro_rich_snippets_product_price_currency',true);
			$check_product_currency = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['currency']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['currency'] : NULL;

			$seopress_pro_rich_snippets_product_condition 	= get_post_meta($id,'_seopress_pro_rich_snippets_product_condition',true);
			$check_product_condition = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['condition']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['condition'] : NULL;

			$seopress_pro_rich_snippets_product_availability = get_post_meta($id,'_seopress_pro_rich_snippets_product_availability',true);
			$check_product_availability = isset($seopress_pro_schemas[0][$id]['rich_snippets_product']['availability']) ? $seopress_pro_schemas[0][$id]['rich_snippets_product']['availability'] : NULL;
		}
		
		//Service
		if ($seopress_pro_rich_snippets_type == 'services') {
			$seopress_pro_rich_snippets_service_name 		= get_post_meta($id,'_seopress_pro_rich_snippets_service_name',true);
			$check_service_name = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['name'] : NULL;
			
			$seopress_pro_rich_snippets_service_type 		= get_post_meta($id,'_seopress_pro_rich_snippets_service_type',true);
			$check_service_type = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['type'] : NULL;
			
			$seopress_pro_rich_snippets_service_description = get_post_meta($id,'_seopress_pro_rich_snippets_service_description',true);
			$check_service_description = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['description']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['description'] : NULL;
			
			$seopress_pro_rich_snippets_service_img 		= get_post_meta($id,'_seopress_pro_rich_snippets_service_img',true);
			$check_service_img = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['img']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['img'] : NULL;
			
			$seopress_pro_rich_snippets_service_area 		= get_post_meta($id,'_seopress_pro_rich_snippets_service_area',true);
			$check_service_area = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['area']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['area'] : NULL;
			
			$seopress_pro_rich_snippets_service_provider_name 	= get_post_meta($id,'_seopress_pro_rich_snippets_service_provider_name',true);
			$check_service_provider_name = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['provider_name']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['provider_name'] : NULL;

			$seopress_pro_rich_snippets_service_lb_img 		= get_post_meta($id,'_seopress_pro_rich_snippets_service_lb_img',true);
			$check_service_lb_img = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['lb_img']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['lb_img'] : NULL;
			
			$seopress_pro_rich_snippets_service_provider_mobility 	= get_post_meta($id,'_seopress_pro_rich_snippets_service_provider_mobility',true);
			$check_service_provider_mobility = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['provider_mobility']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['provider_mobility'] : NULL;
			
			$seopress_pro_rich_snippets_service_slogan 		= get_post_meta($id,'_seopress_pro_rich_snippets_service_slogan',true);
			$check_service_slogan = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['slogan']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['slogan'] : NULL;
			
			$seopress_pro_rich_snippets_service_street_addr = get_post_meta($id,'_seopress_pro_rich_snippets_service_street_addr',true);
			$check_service_street_addr = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['street_addr']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['street_addr'] : NULL;
			
			$seopress_pro_rich_snippets_service_city = get_post_meta($id,'_seopress_pro_rich_snippets_service_city',true);
			$check_service_city = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['city']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['city'] : NULL;
			
			$seopress_pro_rich_snippets_service_state = get_post_meta($id,'_seopress_pro_rich_snippets_service_state',true);
			$check_service_state = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['state']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['state'] : NULL;
			
			$seopress_pro_rich_snippets_service_pc = get_post_meta($id,'_seopress_pro_rich_snippets_service_pc',true);
			$check_service_pc = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['pc']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['pc'] : NULL;
			
			$seopress_pro_rich_snippets_service_country = get_post_meta($id,'_seopress_pro_rich_snippets_service_country',true);
			$check_service_country = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['country']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['country'] : NULL;
			
			$seopress_pro_rich_snippets_service_lat = get_post_meta($id,'_seopress_pro_rich_snippets_service_lat',true);
			$check_service_lat = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['lat']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['lat'] : NULL;
			
			$seopress_pro_rich_snippets_service_lon = get_post_meta($id,'_seopress_pro_rich_snippets_service_lon',true);
			$check_service_lon = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['lon']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['lon'] : NULL;
			
			$seopress_pro_rich_snippets_service_tel = get_post_meta($id,'_seopress_pro_rich_snippets_service_tel',true);
			$check_service_tel = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['tel']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['tel'] : NULL;
			
			$seopress_pro_rich_snippets_service_price = get_post_meta($id,'_seopress_pro_rich_snippets_service_price',true);
			$check_service_price = isset($seopress_pro_schemas[0][$id]['rich_snippets_service']['price']) ? $seopress_pro_schemas[0][$id]['rich_snippets_service']['price'] : NULL;
		}

		//Review
		if ($seopress_pro_rich_snippets_type == 'review') {
			$seopress_pro_rich_snippets_review_item 		= get_post_meta($id,'_seopress_pro_rich_snippets_review_item',true);
			$check_review_item = isset($seopress_pro_schemas[0][$id]['rich_snippets_review']['item']) ? $seopress_pro_schemas[0][$id]['rich_snippets_review']['item'] : NULL;
			
			$seopress_pro_rich_snippets_review_item_type 	= get_post_meta($id,'_seopress_pro_rich_snippets_review_item_type',true);
			$check_review_item_type = isset($seopress_pro_schemas[0][$id]['rich_snippets_review']['item_type']) ? $seopress_pro_schemas[0][$id]['rich_snippets_review']['item_type'] : NULL;

			$seopress_pro_rich_snippets_review_img 			= get_post_meta($id,'_seopress_pro_rich_snippets_review_img',true);
			$check_review_img = isset($seopress_pro_schemas[0][$id]['rich_snippets_review']['img']) ? $seopress_pro_schemas[0][$id]['rich_snippets_review']['img'] : NULL;

			$seopress_pro_rich_snippets_review_rating 		= get_post_meta($id,'_seopress_pro_rich_snippets_review_rating',true);
			$check_review_rating = isset($seopress_pro_schemas[0][$id]['rich_snippets_review']['rating']) ? $seopress_pro_schemas[0][$id]['rich_snippets_review']['rating'] : NULL;
		}

		//Custom
		if ($seopress_pro_rich_snippets_type == 'custom') {
			$seopress_pro_rich_snippets_custom 		= get_post_meta($id,'_seopress_pro_rich_snippets_custom',true);
			$check_custom = isset($seopress_pro_schemas[0][$id]['rich_snippets_custom']['custom']) ? $seopress_pro_schemas[0][$id]['rich_snippets_custom']['custom'] : NULL;
		}

		if ($seopress_pro_rich_snippets_type != 'none' || $seopress_pro_rich_snippets_type !='') {
			echo '<p class="schema_type">'.$seopress_pro_rich_snippets_type;

			if (current_user_can('manage_options') && is_admin()) {
				echo '<span><a href="'.admin_url('post.php?post='.$id.'&action=edit').'">'.__('Edit','wp-seopress-pro').'</a></span>';
			}

			echo '</p>';
		}

		//Article
		if ($seopress_pro_rich_snippets_type == 'articles') {
			if ($seopress_pro_rich_snippets_article_title == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_article][title]_meta">
							'. __( 'Headline <em>(max limit: 110)</em>', 'wp-seopress-pro' ) .'</label>
						'.__('Default value if empty: Post title','wp-seopress-pro').'
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_article][title]" name="seopress_pro_schemas['.$id.'][rich_snippets_article][title]" placeholder="'.esc_html__('The headline of the article','wp-seopress-pro').'" aria-label="'.__('Headline <em>(max limit: 110)</em>','wp-seopress-pro').'" value="'.esc_html($check_article_title).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_article_img == 'manual_img_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_article][img]_meta">
							'. __( 'Image', 'wp-seopress-pro' ) .'</label>
							'.__('Default value if empty: Post thumbnail (featured image)','wp-seopress-pro').'
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_article][img]" name="seopress_pro_schemas['.$id.'][rich_snippets_article][img]" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Image','wp-seopress-pro').'" value="'.esc_html($check_article_img).'" />
					</p>';
			}
		}

		//Local Business
		if ($seopress_pro_rich_snippets_type == 'localbusiness') {
			if ($seopress_pro_rich_snippets_lb_name == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][name]_meta">
							'. __( 'Name of your business', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][name]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][name]" placeholder="'.esc_html__('eg: SEOPress','wp-seopress-pro').'" aria-label="'.__('Name of your business','wp-seopress-pro').'" value="'.esc_html($check_lb_name).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_type == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][type]_meta">
							'. __( 'Select a business type', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][type]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][type]" placeholder="'.esc_html__('eg: TravelAgency','wp-seopress-pro').'" aria-label="'.__('Select a business type','wp-seopress-pro').'" value="'.esc_html($check_lb_type).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_img == 'manual_img_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][img]_meta">
							'. __( 'Image', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][img]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][img]" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Select your image','wp-seopress-pro').'" value="'.esc_html($check_lb_img).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_street_addr == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][street_addr]_meta">
							'. __( 'Street Address', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][street_addr]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][street_addr]" placeholder="'.esc_html__('eg: Place Bellevue','wp-seopress-pro').'" aria-label="'.__('Street Address','wp-seopress-pro').'" value="'.esc_html($check_lb_street_addr).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_city == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][city]_meta">
							'. __( 'City', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][city]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][city]" placeholder="'.esc_html__('eg: Biarritz','wp-seopress-pro').'" aria-label="'.__('City','wp-seopress-pro').'" value="'.esc_html($check_lb_city).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_state == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][state]_meta">
							'. __( 'State', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][state]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][state]" placeholder="'.esc_html__('eg: Pyrenees Atlantiques','wp-seopress-pro').'" aria-label="'.__('State','wp-seopress-pro').'" value="'.esc_html($check_lb_state).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_pc == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][pc]_meta">
							'. __( 'Postal code', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][pc]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][pc]" placeholder="'.esc_html__('eg: 64200','wp-seopress-pro').'" aria-label="'.__('Postal code','wp-seopress-pro').'" value="'.esc_html($check_lb_pc).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_country == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][country]_meta">
							'. __( 'Country', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][country]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][country]" placeholder="'.esc_html__('eg: France','wp-seopress-pro').'" aria-label="'.__('Country','wp-seopress-pro').'" value="'.esc_html($check_lb_country).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_lat == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][lat]_meta">
							'. __( 'Latitude', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][lat]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][lat]" placeholder="'.esc_html__('eg: 43.4831389','wp-seopress-pro').'" aria-label="'.__('Latitude','wp-seopress-pro').'" value="'.esc_html($check_lb_lat).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_lon == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][lon]_meta">
							'. __( 'Longitude', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][lon]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][lon]" placeholder="'.esc_html__('eg: -1.5630987','wp-seopress-pro').'" aria-label="'.__('Longitude','wp-seopress-pro').'" value="'.esc_html($check_lb_lon).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_website == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][website]_meta">
							'. __( 'URL', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][website]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][website]" placeholder="'.get_home_url().'" aria-label="'.__('URL','wp-seopress-pro').'" value="'.esc_html($check_lb_website).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_tel == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][tel]_meta">
							'. __( 'Telephone', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][tel]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][tel]" placeholder="'.esc_html__('eg: +33559240138','wp-seopress-pro').'" aria-label="'.__('Telephone','wp-seopress-pro').'" value="'.esc_html($check_lb_tel).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_lb_price == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][price]_meta">
							'. __( 'Price range', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_lb][price]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][price]" placeholder="'.esc_html__('eg: $$, €€€, or ££££...','wp-seopress-pro').'" aria-label="'.__('Price range','wp-seopress-pro').'" value="'.esc_html($check_lb_price).'" />
					</p>';
			}
			echo '<p>
				<label for="seopress_pro_rich_snippets_lb_opening_hours_meta">
					'. __( 'Opening hours', 'wp-seopress-pro' ) .'</label>
			</p>';

			$options = $check_lb_opening_hours;
			
			$days = array(__('Monday','wp-seopress-pro'), __('Tuesday','wp-seopress-pro'), __('Wednesday','wp-seopress-pro'), __('Thursday','wp-seopress-pro'), __('Friday','wp-seopress-pro'), __('Saturday','wp-seopress-pro'), __('Sunday','wp-seopress-pro') );

			$hours = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');

			$mins = array('00', '15', '30', '45', '59');

			echo '<ul class="wrap-opening-hours">';

			foreach ($days as $key => $day) {

				$check_day = isset($options[$key]['open']);
				
				$check_day_am = isset($options[$key]['am']['open']);

				$check_day_pm = isset($options[$key]['pm']['open']);

				$selected_start_hours = isset($options[$key]['am']['start']['hours']) ? $options[$key]['am']['start']['hours'] : NULL;

				$selected_start_mins = isset($options[$key]['am']['start']['mins']) ? $options[$key]['am']['start']['mins'] : NULL;
				
				echo '<li>';

					echo '<span class="day"><strong>'.$day.'</strong></span>';

					echo '<ul>';
							//Closed?
						echo '<li>';

							echo '<input id="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][open]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][open]" type="checkbox"';
								if ('1' == $check_day) echo 'checked="yes"'; 
								echo ' value="1"/>';
							
							echo '<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][open]">'. __( 'Closed all the day?', 'wp-seopress-pro' ) .'</label> ';
							
							if (isset($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['open'])) {
								esc_attr($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['open']);
							}
						echo '</li>';

						//AM
						echo '<li>';
							echo '<input id="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][am][open]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][am][open]" type="checkbox"';
								if ('1' == $check_day_am) echo 'checked="yes"'; 
								echo ' value="1"/>';                            
							
							echo '<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][am][open]">'. __( 'Open in the morning?', 'wp-seopress-pro' ) .'</label> ';

							if (isset($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['am']['open'])) {
								esc_attr($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['am']['open']);
							}

							echo '<select id="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][am][start][hours]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][am][start][hours]">';

								foreach ($hours as $hour) {
									echo '<option '; 
									if ($hour == $selected_start_hours) echo 'selected="selected"'; 
									echo ' value="'.$hour.'">'. $hour .'</option>';
								}

							echo '</select>';

							echo ' : ';

							echo '<select id="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][am][start][mins]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][am][start][mins]">';

								foreach ($mins as $min) {
									echo '<option '; 
									if ($min == $selected_start_mins) echo 'selected="selected"'; 
									echo ' value="'.$min.'">'. $min .'</option>';
								}

							echo '</select>';

							if (isset($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['am']['start']['hours'])) {
								esc_attr( $options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['am']['start']['hours']);
							}

							if (isset($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['am']['start']['mins'])) {
								esc_attr( $options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['am']['start']['mins']);
							}

							echo ' - ';

							$selected_end_hours = isset($options[$key]['am']['end']['hours']) ? $options[$key]['am']['end']['hours'] : NULL;

							$selected_end_mins = isset($options[$key]['am']['end']['mins']) ? $options[$key]['am']['end']['mins'] : NULL;

							echo '<select id="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][am][end][hours]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][am][end][hours]">';

								foreach ($hours as $hour) {
									echo '<option '; 
									if ($hour == $selected_end_hours) echo 'selected="selected"'; 
									echo ' value="'.$hour.'">'. $hour .'</option>';
								}

							echo '</select>';

							echo ' : ';

							echo '<select id="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][am][end][mins]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][am][end][mins]">';

								foreach ($mins as $min) {
									echo '<option '; 
									if ($min == $selected_end_mins) echo 'selected="selected"'; 
									echo ' value="'.$min.'">'. $min .'</option>';
								}

							echo '</select>';
						echo '</li>';
						
						//PM
						echo '<li>';
							$selected_start_hours2 = isset($options[$key]['pm']['start']['hours']) ? $options[$key]['pm']['start']['hours'] : NULL;

							$selected_start_mins2 = isset($options[$key]['pm']['start']['mins']) ? $options[$key]['pm']['start']['mins'] : NULL;

							echo '<input id="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][pm][open]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][pm][open]" type="checkbox"';
								if ('1' == $check_day_pm) echo 'checked="yes"'; 
								echo ' value="1"/>';

							echo '<label for="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][pm][open]">'. __( 'Open in the afternoon?', 'wp-seopress-pro' ) .'</label> ';

							if (isset($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['pm']['open'])) {
								esc_attr($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['pm']['open']);
							}

							echo '<select id="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][pm][start][hours]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][pm][start][hours]">';

								foreach ($hours as $hour) {
									echo '<option '; 
									if ($hour == $selected_start_hours2) echo 'selected="selected"'; 
									echo ' value="'.$hour.'">'. $hour .'</option>';
								}

							echo '</select>';

							echo ' : ';

							echo '<select id="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][pm][start][mins]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][pm][start][mins]">';

								foreach ($mins as $min) {
									echo '<option '; 
									if ($min == $selected_start_mins2) echo 'selected="selected"'; 
									echo ' value="'.$min.'">'. $min .'</option>';
								}

							echo '</select>';

							if (isset($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['pm']['start']['hours'])) {
								esc_attr( $options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['pm']['start']['hours']);
							}

							if (isset($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['pm']['start']['mins'])) {
								esc_attr( $options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['pm']['start']['mins']);
							}

							echo ' - ';

							$selected_end_hours2 = isset($options[$key]['pm']['end']['hours']) ? $options[$key]['pm']['end']['hours'] : NULL;

							$selected_end_mins2 = isset($options[$key]['pm']['end']['mins']) ? $options[$key]['pm']['end']['mins'] : NULL;

							echo '<select id="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][pm][end][hours]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][pm][end][hours]">';

								foreach ($hours as $hour) {
									echo '<option '; 
									if ($hour == $selected_end_hours2) echo 'selected="selected"'; 
									echo ' value="'.$hour.'">'. $hour .'</option>';
								}

							echo '</select>';

							echo ' : ';

							echo '<select id="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][pm][end][mins]" name="seopress_pro_schemas['.$id.'][rich_snippets_lb][opening_hours]['.$key.'][pm][end][mins]">';

								foreach ($mins as $min) {
									echo '<option '; 
									if ($min == $selected_end_mins2) echo 'selected="selected"'; 
									echo ' value="'.$min.'">'. $min .'</option>';
								}

							echo '</select>';

						echo '</li>';
					echo '</ul>';

				if (isset($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['pm']['end']['hours'])) {
					esc_attr( $options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['pm']['end']['hours']);
				}

				if (isset($options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['pm']['end']['mins'])) {
					esc_attr( $options['seopress_pro_schemas'][$id]['rich_snippets_lb']['opening_hours'][$key]['pm']['end']['mins']);
				}

				$check_lb_opening_hours = $options;
				echo '</li>';
			}
			echo '</ul>';
		}

		//FAQ
		if ($seopress_pro_rich_snippets_type == 'faq') {
			if ($seopress_pro_rich_snippets_faq_q == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_faq][q]_meta">
							'. __( 'Question', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_faq][q]" name="seopress_pro_schemas['.$id.'][rich_snippets_faq][q]" placeholder="'.esc_html__('Your question','wp-seopress-pro').'" aria-label="'.__('Question','wp-seopress-pro').'" value="'.esc_html($check_faq_q).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_faq_a == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_faq][a]_meta">
							'. __( 'Answer', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_faq][a]" name="seopress_pro_schemas['.$id.'][rich_snippets_faq][a]" placeholder="'.esc_html__('Your answer','wp-seopress-pro').'" aria-label="'.__('Answer','wp-seopress-pro').'" value="'.esc_html($check_faq_a).'" />
					</p>';
			}
		}

		//Courses
		if ($seopress_pro_rich_snippets_type == 'courses') {
			if ($seopress_pro_rich_snippets_courses_title == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_courses][title]_meta">
							'. __( 'Title', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_courses][title]" name="seopress_pro_schemas['.$id.'][rich_snippets_courses][title]" placeholder="'.esc_html__('The title of your lesson, course...','wp-seopress-pro').'" aria-label="'.__('Title','wp-seopress-pro').'" value="'.esc_html($check_courses_title).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_courses_desc == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_courses][desc]_meta">
							'. __( 'Course description', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_courses][desc]" name="seopress_pro_schemas['.$id.'][rich_snippets_courses][desc]" placeholder="'.esc_html__('Enter your course/lesson description','wp-seopress-pro').'" aria-label="'.__('Course description','wp-seopress-pro').'" value="'.esc_html($check_courses_desc).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_courses_school == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_courses][school]_meta">
							'. __( 'School/Organization', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_courses][school]" name="seopress_pro_schemas['.$id.'][rich_snippets_courses][school]" placeholder="'.esc_html__('Name of university, organization...','wp-seopress-pro').'" aria-label="'.__('School/Organization','wp-seopress-pro').'" value="'.esc_html($check_courses_school).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_courses_website == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_courses][website]_meta">
							'. __( 'School/Organization Website', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_courses][website]" name="seopress_pro_schemas['.$id.'][rich_snippets_courses][website]" placeholder="'.esc_html__('Enter the URL like https://example.com/','wp-seopress-pro').'" aria-label="'.__('School/Organization Website','wp-seopress-pro').'" value="'.esc_html($check_courses_website).'" />
					</p>';
			}
		}

		//Recipes
		if ($seopress_pro_rich_snippets_type == 'recipes') {
			if ($seopress_pro_rich_snippets_recipes_name == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][name]_meta">
							'. __( 'Recipe name', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][name]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][name]" placeholder="'.esc_html__('The name of your dish','wp-seopress-pro').'" aria-label="'.__('Recipe name','wp-seopress-pro').'" value="'.esc_html($check_recipes_name).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_recipes_desc == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][desc]_meta">
							'. __( 'Short recipe description', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][desc]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][desc]" placeholder="'.esc_html__('A short summary describing the dish.','wp-seopress-pro').'" aria-label="'.__('Short recipe description','wp-seopress-pro').'" value="'.esc_html($check_recipes_desc).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_recipes_cat == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][cat]_meta">
							'. __( 'Recipe category', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][cat]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][cat]" placeholder="'.esc_html__('Eg: appetizer, entree, or dessert','wp-seopress-pro').'" aria-label="'.__('Recipe category','wp-seopress-pro').'" value="'.esc_html($check_recipes_cat).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_recipes_img == 'manual_img_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][img]_meta">
							'. __( 'Image', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][img]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][img]" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Image','wp-seopress-pro').'" value="'.esc_html($check_recipes_img).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_recipes_prep_time == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][prep_time]_meta">
							'. __( 'Preparation time (in minutes)', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][prep_time]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][prep_time]" placeholder="'.esc_html__('Eg: 30','wp-seopress-pro').'" aria-label="'.__('Preparation time (in minutes)','wp-seopress-pro').'" value="'.esc_html($check_recipes_prep_time).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_recipes_cook_time == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][cook_time]_meta">
							'. __( 'Cooking time (in minutes)', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][cook_time]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][cook_time]" placeholder="'.esc_html__('Eg: 45','wp-seopress-pro').'" aria-label="'.__('Cooking time (in minutes)','wp-seopress-pro').'" value="'.esc_html($check_recipes_cook_time).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_recipes_calories == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][calories]_meta">
							'. __( 'Calories', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][calories]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][calories]" placeholder="'.esc_html__('Number of calories','wp-seopress-pro').'" aria-label="'.__('Calories','wp-seopress-pro').'" value="'.esc_html($check_recipes_calories).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_recipes_yield == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][yield]_meta">
							'. __( 'Recipe yield', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][yield]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][yield]" placeholder="'.esc_html__('Eg: number of people served, or number of servings','wp-seopress-pro').'" aria-label="'.__('Recipe yield','wp-seopress-pro').'" value="'.esc_html($check_recipes_yield).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_recipes_keywords == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][keywords]_meta">
							'. __( 'Keywords (separated by commas)', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][keywords]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][keywords]" placeholder="'.esc_html__('Eg: winter apple pie, nutmeg crust (NOT recommended: dessert, American)','wp-seopress-pro').'" aria-label="'.__('Keywords','wp-seopress-pro').'" value="'.esc_html($check_recipes_keywords).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_recipes_cuisine == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][cuisine]_meta">
							'. __( 'Recipe cuisine', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][cuisine]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][cuisine]" placeholder="'.esc_html__('The region associated with your recipe. For example, "French", Mediterranean", or "American".','wp-seopress-pro').'" aria-label="'.__('Recipe cuisine','wp-seopress-pro').'" value="'.esc_html($check_recipes_cuisine).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_recipes_ingredient == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][ingredient]_meta">
							'. __( 'Recipe ingredients (one per line)', 'wp-seopress-pro' ) .'</label>
						<textarea rows="12" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][ingredient]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][ingredient]" placeholder="'.esc_html__('Ingredients used in the recipe. One ingredient per line. Include only the ingredient text that is necessary for making the recipe. Don\'t include unnecessary information, such as a definition of the ingredient.','wp-seopress-pro').'" aria-label="'.__('Recipe ingredients','wp-seopress-pro').'" value="'.esc_html($check_recipes_ingredient).'">'.esc_html($check_recipes_ingredient).'</textarea>
					</p>';
			}
			if ($seopress_pro_rich_snippets_recipes_instructions == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_recipes][instructions]_meta">
							'. __( 'Recipe instructions (one per line)', 'wp-seopress-pro' ) .'</label>
						<textarea rows="12" id="seopress_pro_schemas['.$id.'][rich_snippets_recipes][instructions]" name="seopress_pro_schemas['.$id.'][rich_snippets_recipes][instructions]" placeholder="'.esc_html__('eg: Heat oven to 425°F. Include only text on how to make the recipe and don\'t include other text such as "Directions", "Watch the video", "Step 1".','wp-seopress-pro').'" aria-label="'.__('Recipe instructions','wp-seopress-pro').'" value="'.esc_html($check_recipes_instructions).'">'.esc_html($check_recipes_instructions).'</textarea>
					</p>';
			}
		}

		//Recipes
		if ($seopress_pro_rich_snippets_type == 'jobs') {
			if ($seopress_pro_rich_snippets_jobs_name == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][name]_meta">
							'. __( 'Job title', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][name]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][name]" placeholder="'.esc_html__('The title of the job (not the title of the posting). For example, "Software Engineer" or "Barista".','wp-seopress-pro').'" aria-label="'.__('Job title','wp-seopress-pro').'" value="'.esc_html($check_jobs_name).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_desc == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][desc]_meta">
							'. __( 'Job description', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][desc]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][desc]" placeholder="'.esc_html__('The full description of the job in HTML format.','wp-seopress-pro').'" aria-label="'.__('Job description','wp-seopress-pro').'" value="'.esc_html($check_jobs_desc).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_date_posted == 'manual_date_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][date_posted]_meta">
							'. __( 'Published date', 'wp-seopress-pro' ) .'</label>
						<input type="text" class="seopress-date-picker" autocomplete="false" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][date_posted]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][date_posted]" placeholder="'.esc_html__('The original date that employer posted the job in ISO 8601 format. For example, "2017-01-24" or "2017-01-24T19:33:17+00:00".','wp-seopress-pro').'" aria-label="'.__('Published date','wp-seopress-pro').'" value="'.esc_html($check_jobs_date_posted).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_valid_through == 'manual_date_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][valid_through]_meta">
							'. __( 'Expiration date', 'wp-seopress-pro' ) .'</label>
						<input type="text" class="seopress-date-picker" autocomplete="false" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][valid_through]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][valid_through]" placeholder="'.esc_html__('The date when the job posting will expire in ISO 8601 format. For example, "2017-02-24" or "2017-02-24T19:33:17+00:00".','wp-seopress-pro').'" aria-label="'.__('Expiration date','wp-seopress-pro').'" value="'.esc_html($check_jobs_valid_through).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_employment_type == 'manual_single') {
				echo '<p class="seopress_pro_rich_snippets_jobs_employment_type_p">
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][employment_type]_meta">
							'. __( 'Type of employment', 'wp-seopress-pro' ) .'</label>
						<input type="text" class="seopress_pro_rich_snippets_jobs_employment_type" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][employment_type]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][employment_type]" placeholder="'.esc_html__('Type of employment, You can include more than one employmentType property.','wp-seopress-pro').'" aria-label="'.__('Type of employment','wp-seopress-pro').'" value="'.esc_html($check_jobs_employment_type).'" />
						<span class="wrap-tags">';
                            echo '<span id="seopress-tag-employment-1" class="tag-title" data-tag="FULL_TIME"><span class="dashicons dashicons-plus"></span>'.__('FULL TIME','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-2" class="tag-title" data-tag="PART_TIME"><span class="dashicons dashicons-plus"></span>'.__('PART TIME','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-3" class="tag-title" data-tag="CONTRACTOR"><span class="dashicons dashicons-plus"></span>'.__('CONTRACTOR','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-4" class="tag-title" data-tag="TEMPORARY"><span class="dashicons dashicons-plus"></span>'.__('TEMPORARY','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-5" class="tag-title" data-tag="INTERN"><span class="dashicons dashicons-plus"></span>'.__('INTERN','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-6" class="tag-title" data-tag="VOLUNTEER"><span class="dashicons dashicons-plus"></span>'.__('VOLUNTEER','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-7" class="tag-title" data-tag="PER_DIEM"><span class="dashicons dashicons-plus"></span>'.__('PER_DIEM','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-8" class="tag-title" data-tag="OTHER"><span class="dashicons dashicons-plus"></span>'.__('OTHER','wp-seopress-pro').'</span>';
                        echo '</span>
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_identifier_name == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][identifier_name]_meta">
							'. __( 'Identifier name', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][identifier_name]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][identifier_name]" placeholder="'.esc_html__('The hiring organization\'s unique identifier name for the job','wp-seopress-pro').'" aria-label="'.__('Identifier name','wp-seopress-pro').'" value="'.esc_html($check_jobs_identifier_name).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_identifier_value == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][identifier_value]_meta">
							'. __( 'Identifier value', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][identifier_value]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][identifier_value]" placeholder="'.esc_html__('The hiring organization\'s unique identifier value for the job','wp-seopress-pro').'" aria-label="'.__('Identifier value','wp-seopress-pro').'" value="'.esc_html($check_jobs_identifier_value).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_hiring_organization == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][hiring_organization]_meta">
							'. __( 'Organization that hires', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][hiring_organization]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][hiring_organization]" placeholder="'.esc_html__('The organization offering the job position. This should be the name of the company.','wp-seopress-pro').'" aria-label="'.__('Organization that hires','wp-seopress-pro').'" value="'.esc_html($check_jobs_hiring_organization).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_hiring_same_as == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][hiring_same_as]_meta">
							'. __( 'Organization URL', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][hiring_same_as]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][hiring_same_as]" placeholder="'.esc_html__('The organization website URL offering the job position.','wp-seopress-pro').'" aria-label="'.__('Organization URL','wp-seopress-pro').'" value="'.esc_html($check_jobs_hiring_same_as).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_hiring_logo == 'manual_img_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][hiring_logo]_meta">
							'. __( 'Organization logo', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][hiring_logo]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][hiring_logo]" placeholder="'.esc_html__('The organization logo offering the job position.','wp-seopress-pro').'" aria-label="'.__('Organization logo','wp-seopress-pro').'" value="'.esc_html($check_jobs_hiring_logo).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_address_street == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][address_street]_meta">
							'. __( 'Street address', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][address_street]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][address_street]" placeholder="'.esc_html__('Street address','wp-seopress-pro').'" aria-label="'.__('Street address','wp-seopress-pro').'" value="'.esc_html($check_jobs_address_street).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_address_locality == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][address_locality]_meta">
							'. __( 'Locality address', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][address_locality]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][address_locality]" placeholder="'.esc_html__('Locality address','wp-seopress-pro').'" aria-label="'.__('Locality address','wp-seopress-pro').'" value="'.esc_html($check_jobs_address_locality).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_address_region == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][address_region]_meta">
							'. __( 'Region', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][address_region]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][address_region]" placeholder="'.esc_html__('Region','wp-seopress-pro').'" aria-label="'.__('Region','wp-seopress-pro').'" value="'.esc_html($check_jobs_address_region).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_postal_code == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][postal_code]_meta">
							'. __( 'Postal code', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][postal_code]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][postal_code]" placeholder="'.esc_html__('Postal code','wp-seopress-pro').'" aria-label="'.__('Postal code','wp-seopress-pro').'" value="'.esc_html($check_jobs_postal_code).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_country == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][country]_meta">
							'. __( 'Country', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][country]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][country]" placeholder="'.esc_html__('Country','wp-seopress-pro').'" aria-label="'.__('Country','wp-seopress-pro').'" value="'.esc_html($check_jobs_country).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_remote == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][remote]_meta">
							'. __( 'Remote job?', 'wp-seopress-pro' ) .'</label>
						<input type="checkbox" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][remote]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][remote]" placeholder="'.esc_html__('Remote job?','wp-seopress-pro').'" aria-label="'.__('Remote job?','wp-seopress-pro').'"';
                        if ('1' == esc_html($check_jobs_remote)) echo 'checked="yes"'; 
                        	echo ' value="1"/>
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_salary == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][salary]_meta">
							'. __( 'Salary', 'wp-seopress-pro' ) .'</label>
						<input type="number" step="0.01" min="0" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][salary]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][salary]" placeholder="'.esc_html__('50','wp-seopress-pro').'" aria-label="'.__('Salary','wp-seopress-pro').'" value="'.esc_html($check_jobs_salary).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_salary_currency == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][salary_currency]_meta">
							'. __( 'Currency', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][salary_currency]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][salary_currency]" placeholder="'.esc_html__('Currency','wp-seopress-pro').'" aria-label="'.__('Currency','wp-seopress-pro').'" value="'.esc_html($check_jobs_salary_currency).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_jobs_salary_unit == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_jobs][salary_unit]_meta">
							'. __( 'Select your unit text', 'wp-seopress-pro' ) .'</label>
						<select id="seopress_pro_schemas['.$id.'][rich_snippets_jobs][salary_unit]" name="seopress_pro_schemas['.$id.'][rich_snippets_jobs][salary_unit]">
                            <option ' . selected( 'HOUR', esc_html($check_jobs_salary_unit), false ) . ' value="HOUR">'. __( 'HOUR', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'DAY', esc_html($check_jobs_salary_unit), false ) . ' value="DAY">'. __( 'DAY', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'WEEK', esc_html($check_jobs_salary_unit), false ) . ' value="WEEK">'. __( 'WEEK', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'MONTH', esc_html($check_jobs_salary_unit), false ) . ' value="MONTH">'. __( 'MONTH', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'YEAR', esc_html($check_jobs_salary_unit), false ) . ' value="YEAR">'. __( 'YEAR', 'wp-seopress-pro' ) .'</option>
                        </select>
					</p>';
			}
		}

		//Videos
		if ($seopress_pro_rich_snippets_type == 'videos') {
			if ($seopress_pro_rich_snippets_videos_name == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_videos][name]_meta">
							'. __( 'Video name', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_videos][name]" name="seopress_pro_schemas['.$id.'][rich_snippets_videos][name]" placeholder="'.esc_html__('The title of your video','wp-seopress-pro').'" aria-label="'.__('Video name','wp-seopress-pro').'" value="'.esc_html($check_videos_name).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_videos_description == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_videos][description]_meta">
							'. __( 'Video description', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_videos][description]" name="seopress_pro_schemas['.$id.'][rich_snippets_videos][description]" placeholder="'.esc_html__('The description of the video','wp-seopress-pro').'" aria-label="'.__('Video description','wp-seopress-pro').'" value="'.esc_html($check_videos_description).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_videos_img == 'manual_img_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_videos][img]_meta">
							'. __( 'Video thumbnail', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_videos][img]" name="seopress_pro_schemas['.$id.'][rich_snippets_videos][img]" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Video thumbnail','wp-seopress-pro').'" value="'.esc_html($check_videos_img).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_videos_duration == 'manual_time_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_videos][duration]_meta">
							'. __( 'Duration of your video (in minutes)', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_videos][duration]" name="seopress_pro_schemas['.$id.'][rich_snippets_videos][duration]" placeholder="'.esc_html__('eg: 120 min','wp-seopress-pro').'" aria-label="'.__('Duration of your video (in minutes)','wp-seopress-pro').'" value="'.esc_html($check_videos_duration).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_videos_url == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_videos][url]_meta">
							'. __( 'Video URL', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_videos][url]" name="seopress_pro_schemas['.$id.'][rich_snippets_videos][url]" placeholder="'.esc_html__('Eg: https://example.com/video.mp4','wp-seopress-pro').'" aria-label="'.__('Video URL','wp-seopress-pro').'" value="'.esc_html($check_videos_url).'" />
					</p>';
			}
		}

		//Events
		if ($seopress_pro_rich_snippets_type == 'events') {
			if ($seopress_pro_rich_snippets_events_type == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][type]_meta">
							'. __( 'Event type', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][type]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][type]" placeholder="'.esc_html__('Select your event type','wp-seopress-pro').'" aria-label="'.__('Event type','wp-seopress-pro').'" value="'.esc_html($check_events_type).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_name == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][name]_meta">
							'. __( 'Event name', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][name]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][name]" placeholder="'.esc_html__('The name of your event','wp-seopress-pro').'" aria-label="'.__('Event name','wp-seopress-pro').'" value="'.esc_html($check_events_name).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_desc == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][desc]_meta">
							'. __( 'Event description', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][desc]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][desc]" placeholder="'.esc_html__('Enter your event description','wp-seopress-pro').'" aria-label="'.__('Event description','wp-seopress-pro').'" value="'.esc_html($check_events_desc).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_img == 'manual_img_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][img]_meta">
							'. __( 'Image thumbnail', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][img]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][img]" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Image thumbnail','wp-seopress-pro').'" value="'.esc_html($check_events_img).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_start_date == 'manual_date_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][start_date]_meta">
							'. __( 'Start date', 'wp-seopress-pro' ) .'</label>
						<input type="text" class="seopress-date-picker" id="seopress_pro_schemas['.$id.'][rich_snippets_events][start_date]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][start_date]" placeholder="'.esc_html__('Eg: YYYY-MM-DD','wp-seopress-pro').'" aria-label="'.__('Start date','wp-seopress-pro').'" value="'.esc_html($check_events_start_date).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_start_time == 'manual_time_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][start_time]_meta">
							'. __( 'Start time', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][start_time]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][start_time]" placeholder="'.esc_html__('Eg: HH:MM','wp-seopress-pro').'" aria-label="'.__('Start time','wp-seopress-pro').'" value="'.esc_html($check_events_start_time).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_end_date == 'manual_date_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][end_date]_meta">
							'. __( 'End date', 'wp-seopress-pro' ) .'</label>
						<input type="text" class="seopress-date-picker" id="seopress_pro_schemas['.$id.'][rich_snippets_events][end_date]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][end_date]" placeholder="'.esc_html__('Eg: YYYY-MM-DD','wp-seopress-pro').'" aria-label="'.__('End date','wp-seopress-pro').'" value="'.esc_html($check_events_end_date).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_end_time == 'manual_time_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][end_time]_meta">
							'. __( 'End time', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][end_time]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][end_time]" placeholder="'.esc_html__('Eg: HH:MM','wp-seopress-pro').'" aria-label="'.__('End time','wp-seopress-pro').'" value="'.esc_html($check_events_end_time).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_location_name == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][location_name]_meta">
							'. __( 'Location name', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][location_name]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][location_name]" placeholder="'.esc_html__('Eg: Hotel du Palais','wp-seopress-pro').'" aria-label="'.__('Location name','wp-seopress-pro').'" value="'.esc_html($check_events_location_name).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_location_url == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][location_url]_meta">
							'. __( 'Location Website', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][location_url]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][location_url]" placeholder="'.esc_html__('Eg: http://www.hotel-du-palais.com/','wp-seopress-pro').'" aria-label="'.__('Location Website','wp-seopress-pro').'" value="'.esc_html($check_events_location_url).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_location_address == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][location_address]_meta">
							'. __( 'Location Address', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][location_address]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][location_address]" placeholder="'.esc_html__('Eg: 1 Avenue de l\'Imperatrice, 64200 Biarritz','wp-seopress-pro').'" aria-label="'.__('Location Address','wp-seopress-pro').'" value="'.esc_html($check_events_location_address).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_offers_name == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_name]_meta">
							'. __( 'Offer name', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_name]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_name]" placeholder="'.esc_html__('Eg: General admission','wp-seopress-pro').'" aria-label="'.__('Offer name','wp-seopress-pro').'" value="'.esc_html($check_events_offers_name).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_offers_cat == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_cat]_meta">
							'. __( 'Offer category', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_cat]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_cat]" placeholder="'.esc_html__('Select your offer category','wp-seopress-pro').'" aria-label="'.__('Offer category','wp-seopress-pro').'" value="'.esc_html($check_events_offers_cat).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_offers_price == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_price]_meta">
							'. __( 'Offer price', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_price]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_price]" placeholder="'.esc_html__('Eg: 10','wp-seopress-pro').'" aria-label="'.__('Offer price','wp-seopress-pro').'" value="'.esc_html($check_events_offers_price).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_offers_price_currency == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_price_currency]_meta">
							'. __( 'Offer price currency', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_price_currency]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_price_currency]" placeholder="'.esc_html__('Eg: USD, EUR...','wp-seopress-pro').'" aria-label="'.__('Offer price currency','wp-seopress-pro').'" value="'.esc_html($check_events_offers_price_currency).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_offers_availability == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_availability]_meta">
							'. __( 'Availability', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_availability]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_availability]" placeholder="'.esc_html__('Eg: InStock, SoldOut, PreOrder','wp-seopress-pro').'" aria-label="'.__('Availability','wp-seopress-pro').'" value="'.esc_html($check_events_offers_availability).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_offers_valid_from_date == 'manual_date_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_valid_from_date]_meta">
							'. __( 'Valid From', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_valid_from_date]" class="seopress-date-picker" name="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_valid_from_date]" placeholder="'.esc_html__('The date when tickets go on sale','wp-seopress-pro').'" aria-label="'.__('Valid From','wp-seopress-pro').'" value="'.esc_html($check_events_offers_valid_from_date).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_offers_valid_from_time == 'manual_time_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_valid_from_time]_meta">
							'. __( 'Time', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_valid_from_time]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_valid_from_time]" placeholder="'.esc_html__('The time when tickets go on sale','wp-seopress-pro').'" aria-label="'.__('Time','wp-seopress-pro').'" value="'.esc_html($check_events_offers_valid_from_time).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_offers_url == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_url]_meta">
							'. __( 'Website to buy tickets', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_url]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][offers_url]" placeholder="'.esc_html__('Eg: https://fnac.com/','wp-seopress-pro').'" aria-label="'.__('Website to buy tickets','wp-seopress-pro').'" value="'.esc_html($check_events_offers_url).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_events_performer == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_events][performer]_meta">
							'. __( 'Performer name', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_events][performer]" name="seopress_pro_schemas['.$id.'][rich_snippets_events][performer]" placeholder="'.esc_html__('Eg: Lana Del Rey','wp-seopress-pro').'" aria-label="'.__('Performer name','wp-seopress-pro').'" value="'.esc_html($check_events_performer).'" />
					</p>';
			}
		}

		//Products
		if ($seopress_pro_rich_snippets_type == 'products') {
			if ($seopress_pro_rich_snippets_product_name == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][name]_meta">
							'. __( 'Product name', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_product][name]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][name]" placeholder="'.esc_html__('The name of your product','wp-seopress-pro').'" aria-label="'.__('Product name','wp-seopress-pro').'" value="'.esc_html($check_product_name).'" />
						<span class="description">'.__('Default: product title','wp-seopress-pro').'</span>
					</p>';
			}
			if ($seopress_pro_rich_snippets_product_description == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][description]_meta">
							'. __( 'Product description', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_product][description]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][description]" placeholder="'.esc_html__('The description of the product','wp-seopress-pro').'" aria-label="'.__('Product description','wp-seopress-pro').'" value="'.esc_html($check_product_description).'" />
						<span class="description">'.__('Default: product excerpt','wp-seopress-pro').'</span>
					</p>';
			}
			if ($seopress_pro_rich_snippets_product_img == 'manual_img_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][img]_meta">
							'. __( 'Thumbnail', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_product][img]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][img]" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Thumbnail','wp-seopress-pro').'" value="'.esc_html($check_product_img).'" />
						<span class="description">'.__('Default: product image','wp-seopress-pro').'</span>
					</p>';
			}
			if ($seopress_pro_rich_snippets_product_price == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][price]_meta">
							'. __( 'Product price', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_product][price]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][price]" placeholder="'.esc_html__('Eg: 30','wp-seopress-pro').'" aria-label="'.__('Product price','wp-seopress-pro').'" value="'.esc_html($check_product_price).'" />
						<span class="description">'.__('Default: active product price','wp-seopress-pro').'</span>
					</p>';
			}
			if ($seopress_pro_rich_snippets_product_price_valid_date == 'manual_date_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][price_valid_date]_meta">
							'. __( 'Product price valid until', 'wp-seopress-pro' ) .'</label>
						<input type="text" class="seopress-date-picker" id="seopress_pro_schemas['.$id.'][rich_snippets_product][price_valid_date]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][price_valid_date]" placeholder="'.esc_html__('Eg: YYYY-MM-DD','wp-seopress-pro').'" aria-label="'.__('Product price valid until','wp-seopress-pro').'" value="'.esc_html($check_product_price_valid_date).'" />
						<span class="description">'.__('Default: sale price dates To field','wp-seopress-pro').'</span>
					</p>';
			}
			if ($seopress_pro_rich_snippets_product_sku == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][sku]_meta">
							'. __( 'Product SKU', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_product][sku]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][sku]" placeholder="'.esc_html__('Eg: 0446310786','wp-seopress-pro').'" aria-label="'.__('Product SKU','wp-seopress-pro').'" value="'.esc_html($check_product_sku).'" />
						<span class="description">'.__('Default: product SKU','wp-seopress-pro').'</span>
					</p>';
			}
			if ($seopress_pro_rich_snippets_product_global_ids == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][global_ids]_meta">
							'. __( 'Product Global Identifiers type', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_product][global_ids]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][global_ids]" placeholder="'.esc_html__('Eg: gtin8','wp-seopress-pro').'" aria-label="'.__('Product Global Identifiers type','wp-seopress-pro').'" value="'.esc_html($check_product_global_ids).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_product_global_ids_value == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][global_ids_value]_meta">
							'. __( 'Product Global Identifiers', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_product][global_ids_value]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][global_ids_value]" placeholder="'.esc_html__('Eg: 925872','wp-seopress-pro').'" aria-label="'.__('Product Global Identifiers','wp-seopress-pro').'" value="'.esc_html($check_product_global_ids_value).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_product_brand == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][brand]_meta">
							'. __( 'Select a brand', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_product][brand]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][brand]" placeholder="'.esc_html__('eg: category','wp-seopress-pro').'" aria-label="'.__('Select a brand','wp-seopress-pro').'" value="'.esc_html($check_product_brand).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_product_price_currency == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][currency]_meta">
							'. __( 'Product currency', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_product][currency]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][currency]" placeholder="'.esc_html__('Eg: USD, EUR','wp-seopress-pro').'" aria-label="'.__('Product currency','wp-seopress-pro').'" value="'.esc_html($check_product_currency).'" />
						<span class="description">'.__('Default: USD','wp-seopress-pro').'</span>
					</p>';
			}
			if ($seopress_pro_rich_snippets_product_condition == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][condition]_meta">
							'. __( 'Product Condition', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_product][condition]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][condition]" placeholder="'.esc_html__('Eg: NewCondition, UsedCondition...','wp-seopress-pro').'" aria-label="'.__('Product Condition','wp-seopress-pro').'" value="'.esc_html($check_product_condition).'" />
						<span class="description">'.__('Default: new','wp-seopress-pro').'</span>
					</p>';
			}
			if ($seopress_pro_rich_snippets_product_availability == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_product][availability]_meta">
							'. __( 'Product Availability', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_product][availability]" name="seopress_pro_schemas['.$id.'][rich_snippets_product][availability]" placeholder="'.esc_html__('Eg: InStock, InStoreOnly...','wp-seopress-pro').'" aria-label="'.__('Product Availability','wp-seopress-pro').'" value="'.esc_html($check_product_availability).'" />
						<span class="description">'.__('Default: In Stock','wp-seopress-pro').'</span>
					</p>';
			}
		}

		//Service
		if ($seopress_pro_rich_snippets_type == 'services') {
			if ($seopress_pro_rich_snippets_service_name == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][name]_meta">
							'. __( 'Service name', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][name]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][name]" placeholder="'.esc_html__('The name of your service','wp-seopress-pro').'" aria-label="'.__('Service name','wp-seopress-pro').'" value="'.esc_html($check_service_name).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_type == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][type]_meta">
							'. __( 'Service type', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][type]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][type]" placeholder="'.esc_html__('The type of service','wp-seopress-pro').'" aria-label="'.__('Service type','wp-seopress-pro').'" value="'.esc_html($check_service_type).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_description == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][description]_meta">
							'. __( 'Service description', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][description]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][description]" placeholder="'.esc_html__('The description of your service','wp-seopress-pro').'" aria-label="'.__('Service description','wp-seopress-pro').'" value="'.esc_html($check_service_description).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_img == 'manual_img_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][img]_meta">
							'. __( 'Thumbnail', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][img]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][img]" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Image','wp-seopress-pro').'" value="'.esc_html($check_service_img).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_area == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][area]_meta">
							'. __( 'Area served', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][area]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][area]" placeholder="'.esc_html__('The area served by your service','wp-seopress-pro').'" aria-label="'.__('Area served','wp-seopress-pro').'" value="'.esc_html($check_service_area).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_provider_name == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][provider_name]_meta">
							'. __( 'Provider name', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][provider_name]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][provider_name]" placeholder="'.esc_html__('The provider name of your service','wp-seopress-pro').'" aria-label="'.__('Provider name','wp-seopress-pro').'" value="'.esc_html($check_service_provider_name).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_lb_img == 'manual_img_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][lb_img]_meta">
							'. __( 'Location image', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][lb_img]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][lb_img]" placeholder="'.esc_html__('Select your location image','wp-seopress-pro').'" aria-label="'.__('Location image','wp-seopress-pro').'" value="'.esc_html($check_service_lb_img).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_provider_mobility == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][provider_mobility]_meta">
							'. __( 'Provider mobility (static or dynamic)', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][provider_mobility]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][provider_mobility]" placeholder="'.esc_html__('The provider mobility of your service','wp-seopress-pro').'" aria-label="'.__('Provider mobility (static or dynamic)','wp-seopress-pro').'" value="'.esc_html($check_service_provider_mobility).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_slogan == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][slogan]_meta">
							'. __( 'Slogan', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][slogan]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][slogan]" placeholder="'.esc_html__('The slogan of your service','wp-seopress-pro').'" aria-label="'.__('Slogan','wp-seopress-pro').'" value="'.esc_html($check_service_slogan).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_street_addr == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][street_addr]_meta">
							'. __( 'Street Address', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][street_addr]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][street_addr]" placeholder="'.esc_html__('The street address of your service','wp-seopress-pro').'" aria-label="'.__('Street Address','wp-seopress-pro').'" value="'.esc_html($check_service_street_addr).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_city == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][city]_meta">
							'. __( 'City', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][city]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][city]" placeholder="'.esc_html__('The city of your service','wp-seopress-pro').'" aria-label="'.__('City','wp-seopress-pro').'" value="'.esc_html($check_service_city).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_state == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][state]_meta">
							'. __( 'State', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][state]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][state]" placeholder="'.esc_html__('The state of your service','wp-seopress-pro').'" aria-label="'.__('State','wp-seopress-pro').'" value="'.esc_html($check_service_state).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_pc == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][pc]_meta">
							'. __( 'Postal code', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][pc]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][pc]" placeholder="'.esc_html__('The postal code of your service','wp-seopress-pro').'" aria-label="'.__('Postal code','wp-seopress-pro').'" value="'.esc_html($check_service_pc).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_country == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][country]_meta">
							'. __( 'Country', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][country]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][country]" placeholder="'.esc_html__('The country of your service','wp-seopress-pro').'" aria-label="'.__('Country','wp-seopress-pro').'" value="'.esc_html($check_service_country).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_lat == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][lat]_meta">
							'. __( 'Latitude', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][lat]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][lat]" placeholder="'.esc_html__('The latitude of your service','wp-seopress-pro').'" aria-label="'.__('Latitude','wp-seopress-pro').'" value="'.esc_html($check_service_lat).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_lon == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][lon]_meta">
							'. __( 'Longitude', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][lon]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][lon]" placeholder="'.esc_html__('The longitude of your service','wp-seopress-pro').'" aria-label="'.__('Longitude','wp-seopress-pro').'" value="'.esc_html($check_service_lon).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_tel == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][tel]_meta">
							'. __( 'Telephone', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][tel]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][tel]" placeholder="'.esc_html__('The telephone of your service','wp-seopress-pro').'" aria-label="'.__('Telephone','wp-seopress-pro').'" value="'.esc_html($check_service_tel).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_service_price == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_service][price]_meta">
							'. __( 'Price range', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_service][price]" name="seopress_pro_schemas['.$id.'][rich_snippets_service][price]" placeholder="'.esc_html__('The price range of your service','wp-seopress-pro').'" aria-label="'.__('Price range','wp-seopress-pro').'" value="'.esc_html($check_service_price).'" />
					</p>';
			}
		}

		//Review
		if ($seopress_pro_rich_snippets_type == 'review') {
			if ($seopress_pro_rich_snippets_review_item == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_review][item]_meta">
							'. __( 'Review item name', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_review][item]" name="seopress_pro_schemas['.$id.'][rich_snippets_review][item]" placeholder="'.esc_html__('The item name reviewed','wp-seopress-pro').'" aria-label="'.__('Review item name','wp-seopress-pro').'" value="'.esc_html($check_review_item).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_review_item_type == 'manual_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_review][item_type]_meta">
							'. __( 'Review item type', 'wp-seopress-pro' ) .'</label>
							<select id="seopress_pro_schemas['.$id.'][rich_snippets_review][item_type]" name="seopress_pro_schemas['.$id.'][rich_snippets_review][item_type]">
								<option ' . selected( 'CreativeWorkSeason', esc_html($check_review_item_type), false ) . ' value="CreativeWorkSeason">'. __( 'CreativeWorkSeason', 'wp-seopress-pro' ) .'</option>
								<option ' . selected( 'CreativeWorkSeries', esc_html($check_review_item_type), false ) . ' value="CreativeWorkSeries">'. __( 'CreativeWorkSeries', 'wp-seopress-pro' ) .'</option>
								<option ' . selected( 'Episode', esc_html($check_review_item_type), false ) . ' value="Episode">'. __( 'Episode', 'wp-seopress-pro' ) .'</option>
								<option ' . selected( 'Game', esc_html($check_review_item_type), false ) . ' value="Game">'. __( 'Game', 'wp-seopress-pro' ) .'</option>
								<option ' . selected( 'MediaObject', esc_html($check_review_item_type), false ) . ' value="MediaObject">'. __( 'MediaObject', 'wp-seopress-pro' ) .'</option>
								<option ' . selected( 'MusicPlaylist', esc_html($check_review_item_type), false ) . ' value="MusicPlaylist">'. __( 'MusicPlaylist', 'wp-seopress-pro' ) .'</option>
								<option ' . selected( 'MusicRecording', esc_html($check_review_item_type), false ) . ' value="MusicRecording">'. __( 'MusicRecording', 'wp-seopress-pro' ) .'</option>
								<option ' . selected( 'Organization', esc_html($check_review_item_type), false ) . ' value="Organization">'. __( 'Organization', 'wp-seopress-pro' ) .'</option>
							</select>
					</p>';
			}
			if ($seopress_pro_rich_snippets_review_img == 'manual_img_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_review][img]_meta">
							'. __( 'Review item image', 'wp-seopress-pro' ) .'</label>
						<input type="text" id="seopress_pro_schemas['.$id.'][rich_snippets_review][img]" name="seopress_pro_schemas['.$id.'][rich_snippets_review][img]" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Review item image','wp-seopress-pro').'" value="'.esc_html($check_review_img).'" />
					</p>';
			}
			if ($seopress_pro_rich_snippets_review_rating == 'manual_rating_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_review][rating]_meta">
							'. __( 'Your rating', 'wp-seopress-pro' ) .'</label>
						<input type="number" step="0.1" min="0" max="5" id="seopress_pro_schemas['.$id.'][rich_snippets_review][rating]" name="seopress_pro_schemas['.$id.'][rich_snippets_review][rating]" placeholder="'.esc_html__('The item rating','wp-seopress-pro').'" aria-label="'.__('Your rating','wp-seopress-pro').'" value="'.esc_attr($check_review_rating).'" />
					</p>';
			}
		}

		//Custom
		if ($seopress_pro_rich_snippets_type == 'custom') {
			if ($seopress_pro_rich_snippets_custom == 'manual_custom_single') {
				echo '<p>
						<label for="seopress_pro_schemas['.$id.'][rich_snippets_custom][custom]_meta">
							'. __( 'Custom schema', 'wp-seopress-pro' ) .'</label>
						<textarea rows="25" id="seopress_pro_schemas['.$id.'][rich_snippets_custom][custom]" name="seopress_pro_schemas['.$id.'][rich_snippets_custom][custom]" placeholder="'.esc_html__('eg: <script type="application/ld+json">{
                            "@context": "https://schema.org/",
                            "@type": "Review",
                            "itemReviewed": {
                              "@type": "Restaurant",
                              "image": "http://www.example.com/seafood-restaurant.jpg",
                              "name": "Legal Seafood",
                              "servesCuisine": "Seafood",
                              "telephone": "1234567",
                              "address" :{
                                "@type": "PostalAddress",
                                "streetAddress": "123 William St",
                                "addressLocality": "New York",
                                "addressRegion": "NY",
                                "postalCode": "10038",
                                "addressCountry": "US"
                              }
                            },
                            "reviewRating": {
                              "@type": "Rating",
                              "ratingValue": "4"
                            },
                            "name": "A good seafood place.",
                            "author": {
                              "@type": "Person",
                              "name": "Bob Smith"
                            },
                            "reviewBody": "The seafood is great.",
                            "publisher": {
                              "@type": "Organization",
                              "name": "Washington Times"
                            }
                          }</script>','wp-seopress-pro').'" aria-label="'.__('Custom schema','wp-seopress-pro').'" value="'.esc_html($check_custom).'">'.htmlspecialchars($check_custom).'</textarea>
					</p>';
			}
		}
	}
} else {
	echo '<p>'.__('No automatic schema created for this content.','wp-seopress-pro').'</p>';

	echo '<p><a class="button" href="'.admin_url('post-new.php?post_type=seopress_schemas').'">'.__('Add a schema','wp-seopress-pro').'</a></p>';
}