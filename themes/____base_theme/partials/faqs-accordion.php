<div class="faq-accordion accordion">
	
	<?php 
	 	$b = 0;
		$posts = new WP_Query(
				    array(
				        'post_type' => 'faqs',
				        'posts_per_page' => 12,
				        'order' => 'ASC'				    
				    )
				);
		while ( $posts->have_posts() ) : $posts->the_post();
	?>			
	<div class="accordion-step ">
		<a href="" class="title">
			<?php echo get_the_title(); ?>
		</a>
		<div class="content <?php if($b == 0): ?><?php endif; ?>">
			<p>
				<?php echo get_the_content(); ?>
			</p>
		</div>
	</div>
	<?php $b++; endwhile; ?> 

	
</div>