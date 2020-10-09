<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<?php 
	wp_head(); 
	$secondary = false;					
	if(is_singular('resources')){
		$secondary = true;
	}
	if(get_field('header_type') == 'secondary'){
		$secondary = true;
	}
	$white_action = false;
	if(get_field('white_action')){
		$white_action = true;
	}
	?>
</head>
<body >
<input id="root_url" type="hidden" value="<?php echo get_home_url(); ?>" />
<input id="template_url" type="hidden" value="<?php echo get_template_directory_uri(); ?>" />

<div id="top"></div>
<header class="header <?php if(get_field('header_color') == 'light'): ?>light<?php endif;  if(get_field('header_color') == 'dark'): ?> dark<?php endif; if($secondary): ?> secondary<?php endif; ?> <?php if($white_action): ?>white-action<?php endif; ?>">
	
	<div class="main">
		<div class="container">
			
			<a href="<?php echo get_home_url(); ?>" class="logo">				
				<?php echo wpbb_get_svg('images/reference-nexus-logo.svg') ?>
			</a> 
			
			<nav class="nav" id="site-nav">				
				<ul class="main-links">
					<?php echo wpbb_page_nav('primary-nav'); ?>	
				</ul>				
			</nav>
	
			<div class="action-links">
				<?php if(is_user_logged_in()): ?>
					<a href="<?php echo get_home_url(); ?>/membership-account/" class="login">Account</a>
				<?php else: ?>
					<a href="<?php echo get_home_url(); ?>/facility-login" class="login">Login</a>
				<?php endif; ?>
				
				<?php if(is_user_logged_in()): ?>
					<a href="<?php echo get_home_url(); ?>/create-a-listing" class="btn action-btn accent">Create Listing</a>
				<?php else: ?>
					<a href="<?php echo get_home_url(); ?>/pricing" class="btn action-btn accent">Create Listing</a>
				<?php endif; ?>
			</div>
			<a href="#site-nav" class="mobile-nav-trigger">

				<i data-feather="menu"></i>
			</a>
		</div>
		
	</div>

</header>

<div id="header-trigger"></div>
