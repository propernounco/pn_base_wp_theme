<?php 
/** Template Name: Contact */  
get_header(); 
wpbb_include_leaflet();
$hero_image = wpbb_get_image(get_field('hero_image', get_the_id()), 'hero');		
?>

<div class="contact">
	<div class="container">
		<section class="section first-section">

			<div class="title-contain">
				<h1 class="page-title"><?php echo get_field('hero_title'); ?></h1>	
				<div class="content">
					<p class="large">
						<?php echo get_field('hero_content'); ?>	
					</p>				
				</div>	
			</div>
			
		</section>


		<section class="section form-section no-pad">
			<div class="form-block">
				<?php echo do_shortcode('[gravityform id="1" title="false" description="false"]'); ?>
			</div>

			<div class="sidebar">

				Sidebar
			</div>
		</section>

		
	</div>

	<!-- This can be used with leaflet maps -->
	
	<!-- <section class="section no-pad map-section">
		<div class="location-map-container" id="location-map-container">
			
		</div>
	</section> -->
</div>



<?php get_footer(); ?>

