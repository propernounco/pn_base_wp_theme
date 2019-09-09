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

	<div class="hero small">
		<div class="background-image opacity-60">
			<?php 
				if(get_field('post_image')){
					echo get_image(get_field('post_image'), 'hero')['elem']; 
				}
				else{
					echo get_image(get_field('post_placeholder_image', 'option'), 'hero')['elem']; 
				}									
			?>
		</div>
		<div class="content">
			<div class="container">
				<div class="article-info med-contain">
					<h3 class="subheading top white">
						<?php 
							$categories = get_the_category();	
							echo $categories[0]->name;
						?>
					</h3>
					<h1><?php echo get_the_title(); ?></h1>

					<div class="action-links flex">
						<p>
							<i data-feather="clock"></i>
							<?php echo get_the_date(); ?>
						</p>						
					</div>

				</div>
			</div>
		</div>
	</div>
	
	<div class="section">
		<div class="container">		
			<div class="med-contain">
				<div class="body-text">
					<?php the_content(); ?>
				</div>
			</div>				
		</div>
	</div>

	
	<?php get_template_part('partials/page-cta'); ?>	





</div>


<?php endwhile; endif; ?>

<?php get_footer();