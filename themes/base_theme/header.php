<!DOCTYPE html>
<html lang="en">
<head>	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<?php wp_head(); ?>
</head>
<body >

<div id="top"></div>
<?php 
	$logo_light = wpbb_get_image(get_field('logo_light', 'option'),'logo')['img'];	
	$logo_dark = wpbb_get_image(get_field('logo_dark', 'option'),'logo')['img'];	
	$secondary = false;					
	// if(wpbb_get_template_name() == 'Our Services' || is_singular('post')){
	// 	$secondary = true;
	// }
	if(get_field('header_type') == 'secondary'){
		$secondary = true;
	}
?>

<header class="header <?php if(get_field('header_color') == 'light'): ?>light<?php endif;  if(get_field('header_color') == 'dark'): ?> dark<?php endif; if($secondary): ?> secondary<?php endif; ?>">
	
	<div class="main">
		<div class="container">
			
			<a href="<?php echo get_home_url(); ?>" class="logo logo-light">	
				<img src="<?php echo $logo_light; ?>" alt="Mynt Agency">
			</a> 

			<a href="<?php echo get_home_url(); ?>" class="logo logo-dark">			
				<img src="<?php echo $logo_dark; ?>" alt="Mynt Agency">
			</a> 
			
			<nav class="nav">
				
				<ul>
					<?php echo wpbb_page_nav('primary-nav'); ?>	
				</ul>				
			</nav>

			<a href="" class="mobile-nav-trigger">
				<i data-feather="menu"></i>
			</a>
		</div>
		
	</div>

</header>

<div id="header-trigger"></div>
