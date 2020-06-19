<?php 
$logo_light = wpbb_get_image(get_field('logo_light', 'option'),'logo')['img'];	
echo get_template_part('partials/footer-cta'); ?>

<div class="footer">
	<div class="container flex">
		
		<div class="branding">
			<a href="<?php echo get_home_url(); ?>" class="logo logo-light">	
				<img src="<?php echo $logo_light; ?>" alt="Site Name">
			</a> 
			<p>
				<?php echo get_field('footer_text', 'option'); ?>
			</p>

			<ul class="flex social">
				<?php 
					$social_fields = get_field('social_links', 'option');			
					if(isset($social_fields['facebook']) && !empty($social_fields['facebook'])):
				?>
				<li>
					<a href="<?php echo $social_fields['facebook']; ?>">
						<?php wpbb_get_svg('images/icons/facebook.svg'); ?>
					</a>
				</li>
				<?php endif; ?>	

				<?php
				if(isset($social_fields['twitter']) && !empty($social_fields['twitter'])):
				?>
				<li>
					<a href="<?php echo $social_fields['twitter']; ?>">
						<?php wpbb_get_svg('images/icons/twitter.svg'); ?>
					</a>
				</li>
				<?php endif; ?>	

				<?php
				if(isset($social_fields['instagram']) && !empty($social_fields['instagram'])):
				?>
				<li>
					<a class="only-stroke" href="<?php echo $social_fields['instagram']; ?>">
						<?php wpbb_get_svg('images/icons/instagram.svg'); ?>
					</a>
				</li>
				<?php endif; ?>	

				<?php
				if(isset($social_fields['linkedin']) && !empty($social_fields['linkedin'])):
				?>
				<li>
					<a href="<?php echo $social_fields['linkedin']; ?>">
						<?php wpbb_get_svg('images/icons/linkedin.svg'); ?>
					</a>
				</li>
				<?php endif; ?>	

				<?php
				if(isset($social_fields['youtube']) && !empty($social_fields['youtube'])):
				?>
				<li>
					<a href="<?php echo $social_fields['youtube']; ?>">
						<?php wpbb_get_svg('images/icons/youtube.svg'); ?>
					</a>
				</li>
				<?php endif; ?>	
			</ul>
		</div>

		<div class="links ">
			<h3>Link List</h3>			
			
			<ul>
				<?php echo wpbb_page_nav('footer-links-one'); ?>	
			</ul>

		</div>		

		<div class="links">
			<h3>Link List</h3>

			<ul>
				<?php echo wpbb_page_nav('footer-links-two'); ?>	
			</ul>			
		</div>

		<div class="links">
			<h3>Link List</h3>
			<ul>
				<?php echo wpbb_page_nav('footer-links-three'); ?>	
			</ul>
		</div>

		<div class="links">
			<h3>Our Location</h3>
			
			<div class="text">
				<p class="strong">Mynt Agency</p>
				<addresss class="address body-text">
					<?php echo get_field('main_address', 'option'); ?>
				</addresss>

				<a href="https://www.google.com/maps/dir//121+N+2nd+St+Suite+J,+St.+Charles,+IL+60174/@41.8981176,-88.2403964,17z/data=!4m9!4m8!1m0!1m5!1m1!1s0x880f02afaaaead17:0xa31d2e7fe82e20a0!2m2!1d-88.3168317!2d41.914758!3e0" class="underline" target="_blank">
					Get Directions
				</a>
			</div>
		</div>

	</div>	
	<div class="bottom container">
		<div class="divider"></div>
		<div class="bottom-links">
			<span class="white">© <?php echo date("Y"); ?> Mynt Agency</span>			
		</div>
	</div>

	<a href="tel:<?php echo get_field('phone', 'option'); ?>" class="mobile-call"><span class="text">Click To Call Us Now </span> </a>
</div>

<?php 

	echo wp_footer(); 


?>

</body>
</html>
