<section class="section testimonials-slider-section">
		<!-- <div class="container"> -->
			<div class="testimonials-slider fade-in-content opaque">

				<?php 
				 	$a = 0;
					$posts = new WP_Query(
							    array(
							        'post_type' => 'testimonials',
							        'posts_per_page' => 12,
							        'order' => 'ASC'				    
							    )
							);
					while ( $posts->have_posts() ) : $posts->the_post();
				?>
				<div class="testimonial">
					<span class="text">
						<?php echo get_field('testimonial'); ?>
					</span>

					<span class="aq-lines"></span>

					<span class="person-line-one"><?php echo get_field('client'); ?></span>
					
				</div>
				<?php $a++; endwhile; wp_reset_query(); ?>  
				
			</div>
		<!-- </div> -->
	</section>