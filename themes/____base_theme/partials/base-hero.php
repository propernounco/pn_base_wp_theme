<?php 
$opacity = get_field('hero_overlay_opacity', get_the_id());
$hero_title_position = get_field('hero_title_position', get_the_id());
?>

<div class="background-image opacity-<?php echo $opacity; ?>">
	<?php 
		echo get_image(get_field('hero_image', get_the_id()), 'hero')['elem'];		
	?>		
</div>

<div class="content">
	<div class="container">

		<?php if(get_field('hero_title_position', get_the_id())):?> 
			<div class="text center text-center">
		<?php endif; ?>		
			<?php if($pretitle = get_field('hero_pretitle')): ?>
				<h3 class="pretitle"><?php echo $pretitle; ?></h3>
			<?php endif; ?>
			<?php if(get_field('hero_title')){
				echo '<h1 class="page-title">'. get_field('hero_title', get_the_id()) .'</h1>';
			}else{
				echo '<h1 class="page-title">'. get_the_title() . '</h1>';
			} ?>
			<?php if($subtitle = get_field('hero_subtitle')): ?>
				<h3 class="pretitle"><?php echo $subtitle; ?></h3>
			<?php endif; ?>
		<?php if(get_field('hero_title_position', get_the_id())):?> 
			</div>
		<?php endif; ?>		

		<?php if($hero_content = get_field('hero_content')): ?>
			<div class="small-contain toppad-5">
				<p>
					<?php echo $hero_content; ?>
				</p>
			</div>
		<?php endif; ?>	

		<?php if($hero_cta_link = get_field('hero_cta')['link_url']): ?>
			<div class="small-contain toppad-5">
				<a class="sfl-arrow-btn" href="<?php echo $hero_cta_link; ?>">
					<?php echo get_field('hero_cta')['link_text']; ?>
				</a>
			</div>
		<?php endif; ?>	

	</div>
</div>