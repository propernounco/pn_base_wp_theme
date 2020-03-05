<?php 
/** Template Name: FAQs */  
get_header(); 

$faqs = new WP_Query(
		    array(
		        'post_type' => 'faqs',
		        'posts_per_page' => -1,
		        'order' => 'ASC'		        		   
		    )
		);

$page_links = '';

$cats_arr = array();
$cats_data = array();	

$a = 0;
while($faqs->have_posts()){
	$faqs->the_post();
	
	// $categories = get_terms([
	//     'taxonomy' => 'faq_categories',
	//     'hide_empty' => false,
	//     'orderby' => 'name'
	// ]);
	
	$categories = wp_get_post_terms(get_the_id(), 'faq_categories');

	// $cats_arr = array();
	$first_cat = '';


	foreach($categories as $cat){

		$first_cat = $categories[0]->slug;
		
		if(!in_array(strtolower($cat->slug), $cats_arr)){			
			$cats_arr[] = strtolower($cat->slug);
			$cats_data[] = array('cat_name'=>$cat->name, 'cat_slug'=> strtolower($cat->slug));
			$page_links .= '<li><a href="#'.$cat->slug.'">'. $cat->name .'</a></li>';
		}
		

		// if(!in_array(strtolower($cat->name), $cats_arr) && strtolower($cat->name) !== 'uncategorized'){						
		// 	$cats_arr[] = $cat->name;

		// 	// var_dump($cat->slug);

		// 	$page_links .= '<li><a href="">'. $cat->name .'</a></li>';
		
		// }
	
		$allFaqs[$cat->slug] .= '<div class="accordion-step ">
									<a href="" class="title">
										'. get_the_title() .'
									</a>
									<div class="content">
										<p>
											'.get_the_content() .'
										</p>
									</div>
								</div>';
	}

	$a++;
}

wp_reset_query();

// die();
?>
<div class="faqs">
	<div class="hero small <?php if(get_field('hero_color') == 'light'): ?>light<?php endif; if(get_field('hero_color') == 'dark'): ?>dark<?php endif; ?>">
		<?php echo get_template_part('partials/hero'); ?>		
	</div>
	
	<div class="page-section-links bordered">
		<div class="container">
			<ul>
				
				<?php echo $page_links; ?>
			</ul>
		</div>
	</div>
	
	<section class="section">
		<div class="container">

			<?php 
				foreach($cats_data as $sec){					
					echo '<div class="med-contain toppad-5 bottompad-5" id="'.$sec['cat_slug'].'">
							<h2 class="bottommargin-4">'.$sec['cat_name'].'</h2>
							<div class="faq-accordion accordion">
								'. $allFaqs[$sec['cat_slug']].'
							</div>
						</div>	
						';
				}
			?>
			
		</div>
	</section>
	
	
</div>
<?php get_footer(); ?>
