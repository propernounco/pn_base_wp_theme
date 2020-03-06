<div class="footer">
	<div class="container flex">
		
		<div class="branding">
			<a href="<?php echo get_home_url(); ?>" class="">
					image
			</a>	
			<p>
				Temp
			</p>
		</div>

		<div class="links ">
			<h3>Links One</h3>			
			
			<ul>
				<?php echo page_nav('footer-links-one'); ?>	
			</ul>

		</div>		

		<div class="links">
			<h3>Link Two</h3>

			<ul>
				<?php echo page_nav('footer-links-two'); ?>	
			</ul>			
		</div>

		<div class="links">
			<h3>Link Three</h3>
			<ul>
				<?php echo page_nav('footer-links-three'); ?>	
			</ul>
		</div>

		<div class="links">
			<h3>Our Location</h3>
			
		</div>

	</div>	
	<div class="bottom container">
		<div class="divider"></div>
		<div class="bottom-links">
			<span>© <?php echo date("Y"); ?> Website Name</span>			
		</div>
	</div>

	<a href="tel:<?php echo get_field('phone', 'option'); ?>" class="mobile-call"><span class="text">Click To Call Us Now </span> </a>
</div>

<?php 

	echo wp_footer(); 


?>

</body>
</html>
