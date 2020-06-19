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