<?php 
$opacity = get_field('hero_overlay_opacity', get_the_id());
$hero_color = get_field('hero_color', get_the_id());
$hero_pretitle = get_field('hero_pretitle', get_the_id());
$hero_title = get_field('hero_title', get_the_id());
$hero_content = get_field('hero_content', get_the_id());
$hero_link = get_field('hero_link', get_the_id());
?>

<div class="background-image opacity-<?php echo $opacity; ?> <?php echo $hero_color; ?>">
	<?php if($home_video = get_field('home_video')):?>
		<?php $poster = wpbb_get_image(get_field('hero_image', get_the_id()), 'hero')['img']; ?>		
		<video 
			title="TBD"
		    webkit-playsinline="true"
		    playsinline="true"
		    muted="muted"
		    autoplay
		    loop
			id="hero-video" poster="<?php echo $poster; ?>" alt="TBD">		
					<source src="<?php echo $home_video; ?>" type="video/mp4">
		</video>
	<?php else: ?>
		<?php 
			echo wpbb_get_image(get_field('hero_image', get_the_id()), 'hero')['elem'];		
		?>		
	<?php endif; ?>
	
</div>

<div class="content <?php echo $hero_color; ?>">
	<div class="container">
		
			<?php if($hero_pretitle): ?>
				<h3 class="pretitle"><?php echo $pretitle; ?></h3>
			<?php endif; ?>
			<?php if(get_field('hero_title')){
				echo '<h1 class="page-title">'. get_field('hero_title', get_the_id()) .'</h1>';
			}else{
				echo '<h1 class="page-title">'. get_the_title() . '</h1>';
			} ?>
			
		
		<?php if($hero_content): ?>
			<div class="small-contain toppad-5">
				<p>
					<?php echo $hero_content; ?>
				</p>
			</div>
		<?php endif; ?>	

		<?php if($hero_link): ?>			
			<div class="small-contain toppad-5">
				<a class="stroke-btn large white" href="<?php echo $hero_link['url']; ?>">
					<?php echo $hero_link['title']; ?>
				</a>
			</div>
		<?php endif; ?>	

	</div>
</div>