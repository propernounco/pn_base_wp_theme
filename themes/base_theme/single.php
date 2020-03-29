<?php
/**
 * Single post template
 *
 * @package WordPress
 * @version 1.0
 */
get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
 
	<div class="single-article">

	<div class="section">
		<div class="container">		
			
			<div class="large-contain">

				<div class="post-body">
					<div class="responsive-image post-image">
						
						<?php 
							if(get_field('post_image')){
								echo get_image(get_field('post_image'), 'hero')['elem']; 
							}
							else{
								echo get_image(get_field('post_placeholder_image', 'option'), 'hero')['elem']; 
							}									
						?>
				
					</div>
					<div class="post-text">

						<div class="title-sec">
							

							<div class="action-links flex">

								<span class="pretitle dark rightpad-2 block">
									<?php 
										$categories = get_the_category();	
										echo $categories[0]->name;
									?>
								</span>

								<span class="pretitle dark">				
									<?php echo get_the_date(); ?>
								</span>						
							</div>
							
							<h1><?php echo get_the_title(); ?></h1>

							<div class="addthis_inline_share_toolbox"></div>

						</div>
						<?php the_content(); ?>
					</div>
				</div>
				<div class="post-sidebar">
					<div class="item">
						<h3>Recent Posts</h3>

						<ul class="recent-posts-list">
							<?php
								wp_reset_query();
								$recent_posts = new WP_Query(
								    array(
								        'post_type' => 'post',
								        'posts_per_page' => 4
								    )
								);
								while ( $recent_posts->have_posts() ) : $recent_posts->the_post();						
							?>
							<li>
								<a href="<?php echo get_the_permalink(); ?>" class="post-thumb-image">
									<?php
									if(get_field('post_image')){
										echo get_image(get_field('post_image'), 'hero')['elem']; 
									}
									else{
										echo get_image(get_field('post_placeholder_image', 'option'), 'hero')['elem']; 
									}		
									?>
								</a>
								<div class="post-details">
									<a href="#">
										<?php echo get_the_title(); ?>
									</a>
								</div>
							</li>
							<?php endwhile; wp_reset_query(); ?>
						</ul>
					</div>

					<div class="item ad-item">
						<a href="<?php echo get_field('sidebar_ad_link', 'option')['url']; ?>" class="ad-image">
							<?php 					
							echo get_image(get_field('sidebar_ad_image', 'option'), 'square')['elem']; ?>
						</a>
					</div>
				</div>
				
			</div>
					
		</div>
	</div>


</div>


<?php endwhile; endif; ?>
