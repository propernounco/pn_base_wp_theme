<!-- <?php 
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
			<?php if(get_field('hero_title')){
				echo '<h1>'. get_field('hero_title', get_the_id()) .'</h1>';
			}else{
				echo '<h1>'. get_the_title() . '</h1>';
			} ?>
		<?php if(get_field('hero_title_position', get_the_id())):?> 
			</div>
		<?php endif; ?>			
		
	</div>
</div> -->