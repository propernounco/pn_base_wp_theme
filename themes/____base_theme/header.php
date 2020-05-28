<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<?php wp_head(); ?>
</head>
<body >
<div id="top"></div>
<header class="header <?php if(get_field('header_color') == 'light'): ?>light<?php endif;  if(get_field('header_color') == 'dark'): ?> dark<?php endif; if($secondary): ?> secondary<?php endif; ?>">
	
	<div class="main">
		<div class="container">
			
			<a href="<?php echo get_home_url(); ?>" class="logo">
				LOGO
				<!-- <img src="<?php echo get_image(get_field('logo', 'option'),'logo')['img']; ?>" alt="SFL Partners"> -->
			</a> 
			
			<nav class="nav">
				
				<ul>
					<?php echo page_nav('primary-nav'); ?>	
				</ul>				
			</nav>

			<a href="" class="mobile-nav-trigger">
				<i data-feather="menu"></i>
			</a>
		</div>
		
	</div>

</header>

<div id="header-trigger"></div>
