<?php 
/** Template Name: About */  
get_header(); 

$opacity = get_field('hero_overlay_opacity', get_the_id());
$hero_title_position = get_field('hero_title_position', get_the_id());
$hero_title = get_field('hero_title');
$first_section = get_field('first_section');
$second_section = get_field('second_section');
$map_section = get_field('map_section');
$split_images_section = get_field('split_images_section');
?>
<div class="about">

	<section class="section first-section">
		<div class="container">
			<div class="med-contain text text-center">
				<h1 class="page-title opaque fade-in-content"><?php echo $first_section['title']; ?></h1>

				<div class="content topmargin-5 opaque fade-in-content animation-delay-1">
					<p class="med">
						<?php echo $first_section['text']; ?>
					</p>
				</div>
			</div>
			<div class="split-image opaque fade-in-content animation-delay-3">

				<?php 

				if($first_section['video']): ?>
					<?php // $poster = wpbb_get_image(get_field($first_section['image'], get_the_id()), 'hero')['img']; 
						$video = $first_section['video'];
					?>		
					<video 
						title="Mynt Agency"
					    webkit-playsinline="true"
					    playsinline="true"
					    muted="muted"
					    autoplay
					    loop
						id="hero-video" poster="<?php //echo $poster; ?>" alt="Mynt Agency">
							<!-- <source src="<?php //echo wpbb_get_asset_url('videos/hm-homes-homevideo.mp4'); ?>" type="video/mp4"> -->
								<source src="<?php echo $video; ?>" type="video/mp4">
					</video>
				<?php else: ?>
					<img src="<?php echo wpbb_get_image($first_section['image'], 'square_lg')['img']; ?>" alt="About Mynt Agency">
				<?php endif; ?>
				
			</div>
		</div>
	</section>

	<section class="section no-pad about-clients-section">
		<div class="container">
			<div class="background-image opaque fade-in-content animation-delay-9">
				<img src="<?php echo wpbb_get_img_url('partner-icons-graphic.png') ?>" alt="Mynt agency partners">
			</div>
			<div class="text text-center micro-contain">
				<span class="pretitle opaque fade-in-content"><?php echo $second_section['pretitle']; ?></span>
				<h2 class="section-title-medium opaque fade-in-content animation-delay-1"><?php echo $second_section['title']; ?></h2>

				<p class="opaque fade-in-content animation-delay-2">
					<?php echo $second_section['text']; ?>
				</p>

				<div class="buttons center topmargin-5 opaque fade-in-content animation-delay-3">
					<a href="<?php echo $second_section['link']['url']; ?>" class="arrow-link dark large"><?php echo $second_section['link']['title']; ?></a>
				</div>
			</div>
		</div>
	</section>

	<section class="section callout-numbers-section">
		<div class="container">
			<div class="med-contain">
				<?php echo get_template_part('partials/stats-counter'); ?>
			</div>
		</div>
	</section>

	<section class="section our-distributed-team-section">

		<div class="container">
			<div class="text text-center small-contain opaque fade-in-content ">
				<h2 class="section-title"><?php echo $map_section['title']; ?></h2>	
			</div>	
			
			<div class="text text-center small-contain opaque fade-in-content animation-delay-1">
				<p>
					<?php echo  $map_section['text']; ?>
				</p>
			</div>

			<diiv class="med-contain mynt-map opaque fade-in-content animation-delay-2">
				<img src="<?php echo wpbb_get_image($map_section['map_image'], 'square_lg')['img']; ?>" alt="Map of Mynt agency clients" class="responsive-img">
			</diiv>

			<div class="buttons center topmargin-9 opaque fade-in-content animation-delay-2">
				<a href="<?php echo $map_section['link']['url']; ?>" class="round-btn dark"><?php echo $map_section['link']['title']; ?></a>
			</div>
		</div>

	</section>

	<section class="section light split-images-section">
		<div class="container">
			<div class="small-contain text-center">
				<h3 class="section-title-small">
					<?php echo $split_images_section['title']; ?>
				</h3>
				<div class="text">
					<p>
						<?php echo $split_images_section['text']; ?>	
					</p>
				</div>
				<div class="buttons center topmargin-5">
					<a href="#rfp-request" class="round-btn primary rfp-request">request an rfp</a>
				</div>
			</div>

			<div class="split-images">
				<div class="image-left">
					<h3 class="section-title-small">
						<?php echo $split_images_section['image_title']; ?>
					</h3>

					<div class="image">
						<img src="<?php echo wpbb_get_image($split_images_section['image_left'], 'square_lg')['img']; ?>" alt="Remnant advertising agency">
					</div>
	

				</div>

				<div class="image-right">
					<div class="image">
							<img src="<?php echo wpbb_get_image($split_images_section['image_right'], 'square_lg')['img']; ?>" alt="Remnant advertising agency">
						</div>

				</div>
			</div>

			<?php 
			$bottom_callouts = $split_images_section['bottom_callouts'];
			?>
			<div class="grid col-1 col-3-m topmargin-8 xxl-gap">				
				<?php foreach($bottom_callouts as $callout): ?>
					<div class="item">
						<h3><?php echo $callout['title']; ?></h3>
						<p><?php echo $callout['text']; ?></p>
					</div>
				<?php endforeach; ?>
			</div>

		</div>
	</section>
		
	<?php echo get_template_part('partials/media-partners'); ?>

</div>
<?php get_footer(); ?>
