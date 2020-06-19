<?php
/**
 * Single page template
 *
 * @package WordPress
 * @version 1.0
 */
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post();?>

<div id="page-wrapper" class="general-page"> 
    <div class="container ">
    	<div class="small-contain body-content">
    		<?php if($hero_pretitle = get_field('hero_pretitle')): ?>
    			<span class="pretitle"><?php echo $hero_pretitle; ?></span>
    		<?php endif; ?>
    		<h1 class="page-title">
	    		<?php  
	    		if($hero_title = get_field('hero_title')){
	    			echo $hero_title;
	    		}
	    		else{
	    			get_the_title();
	    		}
	    		?>
	    	</h1>    	
	    	<div class="content">
	    		<?php the_content(); ?>    		
	    	</div>
    	</div>
    	
    	
    </div>
</div>

<?php endwhile; endif; ?>

<?php get_footer();
