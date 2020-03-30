<?php 
/** Template Name: Contact */  
get_header(); 

$opacity = get_field('hero_overlay_opacity', get_the_id());
$hero_title_position = get_field('hero_title_position', get_the_id());

?>
<div class="contact">
	<div class="hero">
		
		<div class="background-image opacity-<?php echo $opacity; ?>">
			<?php 
				echo get_image(get_field('hero_image', get_the_id()), 'hero')['elem'];		
			?>		
		</div>

		<div class="drop-line-small">
			<div class="container">
				<div class="med-contain toppad-6">
					<h3>Drop Us A Line</h3>				
					<p>
						<?php echo get_the_content(); ?>
					</p>		


					<button class="trigger-contact-modal desktop-hide topmargin-5" data-izimodal-open="#contact-modal">		Contact Us
					</button>

				</div>				
			</div>			
		</div>

		<div class="container">

			<div class="contact-content">
				
				<div class="drop-line-large">
					<h1>Drop Us A Line</h1>					
					<p>
						<?php echo get_the_content(); ?>
					</p>	
				</div>
				
				<div class="social-connect info-box">
					<h3>Let's Connect</h3>

					<div class="grid col-2 col-3-l">
						<?php if($site_phone = get_field('phone', 'option')):?>
						<div class="item">
							<a href="tel:<?php echo $site_phone; ?>">
								<i data-feather="phone"></i>
								<?php echo $site_phone; ?>
							</a>
						</div>
						<?php endif; ?>
								
						<?php 
						$social_options = get_field('social_links', 'option');
						if(isset($social_options['facebook'])): ?>
						<div class="item">
							<a class="filled" href="<?php echo $social_options['facebook']; ?>">
								<i data-feather="facebook"></i>
								<?php echo get_field('social_handle', 'option'); ?>
							</a>
						</div>
						<?php endif; ?>
	
						<?php if(isset($social_options['instagram'])): ?>
						<div class="item">
							<a href="<?php echo $social_options['instagram']; ?>">
								<i data-feather="instagram"></i>
								<?php echo get_field('social_handle', 'option'); ?>
							</a>
						</div>
						<?php endif; ?>

						<?php if(isset($social_options['twitter'])): ?>	
						<div class="item">
							<a href="<?php echo $social_options['twitter']; ?>">
								<i data-feather="twitter"></i>
								<?php echo get_field('social_handle', 'option'); ?>
							</a>
						</div>
						<?php endif; ?>

						<?php if(isset($social_options['youtube'])): ?>
						<div class="item">	
							<a href="<?php echo $social_options['youtube']; ?>">
								<i data-feather="youtube"></i>
								<?php echo get_field('social_handle', 'option'); ?>
							</a>
						</div>
						<?php endif; ?>

						<?php if($email = get_field('email', 'option')): ?>
						<div class="item">
							<a href="mailto:<?php echo $email; ?>">
								<i data-feather="mail"></i>
								<?php echo $email;  ?>
							</a>
						</div>
						<?php endif; ?>
					
					</div>
				</div>

				<div class="location-info info-box">
					<div class="grid col-1 col-2-mobile col-3-l toppad-8">
						<div class="item">
							<h3>Location</h3>
							<address>
								<strong>SFL Partners</strong> <br>
								<?php echo get_field('address', 'option'); ?>
							</address>
							<a target="_blank" href="<?php echo get_field('directions_link', 'option'); ?>" class="underline topmargin-3">Get Directions</a>
						</div>
						<div class="item">
							<h3>Phone Number</h3>							
							<?php 
								$phone = get_field('phone', 'option');
							?>
							<a href="tel:<?php echo str_replace('.', '', $phone) ; ?>" class="underline topmargin-3"><?php echo $phone; ?></a>
						</div>

						<div class="item">
							<h3>Hours</h3>
							<table>
								<tbody>
								<tr>
								<td class="strong">Monday								
								</td>
								<td>9AM&ndash;6PM</td>
								</tr>
								<tr>
								<td class="strong">Tuesday</td>
								<td>9AM&ndash;6PM</td>
								</tr>
								<tr>
								<td class="strong">Wednesday</td>
								<td>9AM&ndash;6PM</td>
								</tr>
								<tr>
								<td class="strong">Thursday</td>
								<td>9AM&ndash;6PM</td>
								</tr>
								<tr>
								<td class="strong">Friday</td>
								<td>9AM&ndash;6PM</td>
								</tr>
								<tr>
								<td class="strong">Saturday</td>
								<td>9AM&ndash;2PM</td>
								</tr>
								<tr>
								<td class="strong">Sunday</td>
								<td>Closed</td>
								</tr>
								</tbody>
							</table>								
						</div>
					</div>
				</div>

				<button class="trigger-contact-modal desktop-hide topmargin-5" data-izimodal-open="#contact-modal">		Contact Us
				</button>

			</div>
			<div class="contact-form">
				<div class="form-container">
					<?php echo do_shortcode('[gravityform id="4" title="false" description="false"]'); ?>
				</div>
			</div>
		</div>		


	</div>

	<section class="location-info-large section">

		<div class="container">
				
			<div class="item">
				<h3>Our Hours</h3>
			
				<table class="hours-table">
					<tbody>
					<tr>
					<td class="strong">Monday								
					</td>
					<td>9AM&ndash;6PM</td>
					</tr>
					<tr>
					<td class="strong">Tuesday</td>
					<td>9AM&ndash;6PM</td>
					</tr>
					<tr>
					<td class="strong">Wednesday</td>
					<td>9AM&ndash;6PM</td>
					</tr>
					<tr>
					<td class="strong">Thursday</td>
					<td>9AM&ndash;6PM</td>
					</tr>
					<tr>
					<td class="strong">Friday</td>
					<td>9AM&ndash;6PM</td>
					</tr>
					<tr>
					<td class="strong">Saturday</td>
					<td>9AM&ndash;2PM</td>
					</tr>
					<tr>
					<td class="strong">Sunday</td>
					<td>Closed</td>
					</tr>
					</tbody>
				</table>								
		
			</div>
			
	</section>

	<div class="location-map">
		<iframe src="<?php echo get_field('location_map_url', 'option'); ?>" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
	</div>
	
	<section class="section">
		<div class="container">
			<?php echo get_template_part('partials/faq-accordion'); ?>
		</div>
	</section>
</div>
<?php get_footer(); ?>
