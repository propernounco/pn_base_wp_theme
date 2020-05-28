<?php 
/** Template Name: Blog Index */  
get_header(); 


	 	$c = 0;
	 	$fc = 0;

	 	$featured_posts = '';
	 	$all_posts = '';

	 	$cat_list = '';
	 	$cat_arr = ['uncategorized'];

	 	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$posts = new WP_Query(
				    array(
				        'post_type' => 'post',
				        'posts_per_page' => 24,
				        'order' => 'ASC',
				        'paged' => $paged				    
				    )
				);
		while ( $posts->have_posts() ) {
					$posts->the_post();
					$categories = get_the_category(get_the_id());					
					$featured = false;				

					if(get_field('post_image')){
						$post_img = get_image(get_field('post_image'), 'hero')['elem']; 
					}
					else{
						$post_img = get_image(get_field('post_placeholder_image', 'option'), 'hero')['elem']; 
					}	

					foreach($categories as $category){
						

						if(!in_array(strtolower($category->name), $cat_arr)){
							$cat_list .= '<li><a href="'. get_category_link($category->term_id) .'">'.$category->name.'</a></li>';
							$cat_arr[] = strtolower($category->name);
						}

						if( strtolower($category->name) == 'featured'){
							$featured = true;
						}
					}
					if($featured && $fc < 3){

								

						$featured_posts .= '<div class="item">
												<div class="image-card">
													<a href="" class="image">
														'. $post_img .'
													</a>
													<div class="card-content">							
														<h2 class="card-title">'. get_the_title() .'</h2>
														<p>
															'. get_the_excerpt() .'
														</p>
														
														<a href="'. get_the_permalink() .'" class="arrow-link">Read The Article</a>
													</div>
												</div>
											</div>';
						
						$fc++;											
					}

					$all_posts .= '<div class="post">
										<a href='.get_the_permalink().' class="image">'.$post_img.'</a>
										<div class="contents">
											<h2>
												'.get_the_title().'
											</h2>

											<div class="addthis_inline_share_toolbox"></div>

											<p class="excerpt">
												'. get_the_excerpt() .'
											</p>

											<a href="'. get_the_permalink() .'" class="arrow-link">Read The Article</a>
										</div>
									</div>';
					// exit;

		} 

?>
<div class="blog-index">
	<div class="page-section-links">
		<div class="container">
			<ul>
				<?php echo $cat_list; ?>
			</ul>
		</div>
	</div>

	<section class="section featured-posts">
		<div class="container">
			<div class="text text-center small-contain">
				<?php if(get_field('hero_title')){
					echo '<h1 class="page-title">'. get_field('hero_title', get_the_id()) .'</h1>';
				}else{
					echo '<h1 class="page-title">SFL Partners Blog</h1>';
				} ?>
				<?php if($hero_content = get_field('hero_content')): ?>
					<div class="small-contain toppad-3">
						<p>
							<?php echo $hero_content; ?>
						</p>
					</div>
				<?php else: ?>
					<div class="small-contain toppad-3 bottompad-5">
						<p>
							News, resources, and local insights on the South Florida real estate market. 
						</p>
					</div>					
				<?php endif; ?>
			</div>
	
			<!-- Featured -->
			<div class="grid col-1 col-2-s col-3-m xxl-gap featured-posts-grid">
				<?php echo $featured_posts; ?>
			</div>

			<!-- All Posts -->
		</div>
	</section>

	<section class="all-posts-section section">
		<div class="container">
			<div class="med-contain">
				
				<h2 class="underline-title">Latest Posts</h2>

				<div class="all-posts">
					<!-- <div class="post">
						<a class="image"></a>
						<div class="contents">
							<h2>The standard Lorem Ipsum passage, used since the 1500s</h2>

							<div class="addthis_inline_share_toolbox"></div>

							<p class="excerpt">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.
							</p>

							<a href="" class="arrow-link">read the article</a>
						</div>
					</div> -->
					<?php echo $all_posts; ?>
				</div>
				
				<div class="pagination-container">
					<?php echo paginate_links( array(
								'base'               => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
								'format'             => '',
								'current'            => max( 1, get_query_var('paged') ),
								'total'              => $posts->max_num_pages,
								'prev_text'          => '<i data-feather="chevron-left"></i>',
								'next_text'          => '<i data-feather="chevron-right"></i>',
								'type'               => 'list',
								'end_size'           => 3,
								'mid_size'           => 3
							)
						); wp_reset_postdata(); wp_reset_query();
					?>
				</div>
			</div>
		</div>
	</section>
	
</div>

<?php echo get_template_part('partials/split-form'); ?>

<?php get_template_part('partials/sell-cta'); ?>

<?php get_footer(); ?>
<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e304b6761a3275c"></script>