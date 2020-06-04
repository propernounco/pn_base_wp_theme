<?php
function wpbb_get_svg($filename){
	$contentUrl = dirname(__DIR__) . '/assets/' . $filename;
	// die();
	$svg_file = file_get_contents( $contentUrl );
	$find_string   = '<svg';
	$position = strpos($svg_file, $find_string);
	$svg_file_new = substr($svg_file, $position);
	echo $svg_file_new;
}

function wpbb_get_template_name( $page_id = null ) {
    if ( ! $template = get_page_template_slug( $page_id ) )
        return;
    if ( ! $file = locate_template( $template ) )
        return;

    $data = get_file_data(
        $file,
        array(
            'Name' => 'Template Name',
        )
    );

    return $data['Name'];
}

/**
 * Encrypt Text
 */
function wpbb_encrypt_text( $plain_text ){
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $h_key = hash('sha256', wp_salt(), TRUE);
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $h_key, $plain_text, MCRYPT_MODE_ECB, $iv));
}
 
/**
 * Decrypt Text
 */
function wpbb_decrypt_text( $encrypted_text ){
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $h_key = hash('sha256', wp_salt(), TRUE);
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $h_key, base64_decode( $encrypted_text ), MCRYPT_MODE_ECB, $iv));
}

function wpbb_buildTree( array &$elements, $parentId = 0 )
{
    $branch = array();
    foreach ( $elements as &$element )
    {
        if ( $element->menu_item_parent == $parentId )
        {
            $children = wpbb_buildTree( $elements, $element->ID );
            if ( $children )
                $element->wpse_children = $children;

            $branch[$element->ID] = $element;
            unset( $element );
        }
    }
    return $branch;
}


function wpbb_page_nav($menu_name){
	
	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);	
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		$link_arr = array();
		$nav_block = '';

		$sub_block = '';

		$items = wpbb_buildTree($menu_items, 0);

		foreach($items as $item){
			$itemclass = $item->classes[0];
			// var_dump($item->wpse_children);			

			if($item->wpse_children){

				// var_dump('option-skskksk');
				
				

				$nav_block .= "<li class='nav-item top-level children'><a class='$itemclass' href='". $item->url ."'>". $item->title ."</a>";

				$nav_block .= "<ul class='sub-links'>";
				$a = 0;				
				
				foreach($item->wpse_children as $child){							

					
					if(is_array($child->wpse_children)){					
						
						if(count($child->wpse_children) > 0){

							// var_dump($a);
							// var_dump($child->wpse_children);

							$nav_block .= "<li class='split-items'><a class='$itemclass' href='". $child->url ."'>".$child->title . "</a>";

							$nav_block .= "<ul class='sub-sub-links'>";
							
							foreach($child->wpse_children as $gchild){					
								$nav_block .= "<li><a class='$classes' href='". $gchild->url ."'>".$gchild->title . "</a></li>";	
							}
							$nav_block .= "</ul></li>";
							
						}	
						else{						

							$nav_block .= "<li><a class='$itemclass' href='". $child->url ."'>".$child->title."</a></li>";			
						}


					}
					else{
						$nav_block .= "<li><a class='$itemclass' href='". $child->url ."'>".$child->title . "</a></li>";
					}
					
					$a++;
				
				}
				$nav_block .= "</ul></li>";
				
			}
			else{								
				$nav_block .= "<li class='nav-item top-level no-children'><a class='$itemclass' href='". $item->url ."'>". $item->title ."</a></li>";
			}
		}

		
	} else {
		// $menu_list = '<!-- no list defined -->';
	}

	return $nav_block;		
}


function wpbb_get_asset_url($file){
	// $url = get_template_directory_uri() . '/assets/' . $file;
	$url = get_template_directory_uri() . '/assets/' . $file;
	return $url;
}


function wpbb_get_img_url($file){
	// $url = get_template_directory_uri() . '/assets/' . $file;
	$url = get_template_directory_uri() . '/assets/dist/images/' . $file;
	return $url;
}


//Function to convert ACF Image to url and size
function wpbb_get_image($image, $size, $class = NULL){
	// vars
	$url = $image['url'];
	$title = $image['title'];
	$alt = $image['alt'];
	$caption = $image['caption'];

	// thumbnail
	$size = $size;
	$thumb = $image['sizes'][ $size ];
	$width = $image['sizes'][ $size . '-width' ];
	$height = $image['sizes'][ $size . '-height' ];
	$elem = "<img src='$thumb' alt='$alt' title='$title' width='$width' height='$height' >";

	return array(
		'alt' => $alt,
		'title' => $title, 
		'img' => $thumb,
		'width' => $width,
		'height' => $height,
		'elem' => $elem
	);
}

function wpbb_get_social_links(){

	$social_links_arr = array();
	$social_options = get_field('social_links', 'option');


	if($site_phone = get_field('phone', 'option')){
		array_push($social_links_arr, array(
			'social_title' => 'phone',
			'icon_key' => 'phone',
			'value' => $site_phone,
			'social_handle' => get_field('social_handle', 'option')
		)); 
	}			


	if(isset($social_options['houzz'])){
		array_push($social_links_arr, array(
			'social_title' => 'houzz',
			'icon_key' => 'houzz',
			'value' => $social_options['houzz'],
			'social_handle' => get_field('social_handle', 'option')
		));
	}		

	if(isset($social_options['facebook'])){
		array_push($social_links_arr, array(
			'social_title' => 'facebook',
			'icon_key' => 'facebook',
			'value' => $social_options['facebook'],
			'social_handle' => get_field('social_handle', 'option')
		));
	}

	if(isset($social_options['instagram'])){
		array_push($social_links_arr, array(
			'social_title' => 'instagram',
			'icon_key' => 'instagram',
			'value' => $social_options['instagram'],
			'social_handle' => get_field('social_handle', 'option')
		));
	}

	if(isset($social_options['twitter'])){
		array_push($social_links_arr, array(
			'social_title' => 'twitter',
			'icon_key' => 'twitter',
			'value' => $social_options['twitter'],
			'social_handle' => get_field('social_handle', 'option')
		));
	}

	if(isset($social_options['youtube'])){
		array_push($social_links_arr, array(
			'social_title' => 'youtube',
			'icon_key' => 'youtube',
			'value' => $social_options['youtube'],
			'social_handle' => get_field('social_handle', 'option')
		)); 
	}

	if($email = get_field('email', 'option')){
		array_push($social_links_arr, array(
			'social_title' => 'email',
			'icon_key' => 'mail',
			'value' => $email,
			'social_handle' => $email
		)); 
	}

	return $social_links_arr;

}

function wpbb_social_links_block(){
	$links = wpbb_get_social_links();
	$linkBlock = '';

	// $fb = wpbb_get_svg('images/svg/fb.svg');

	foreach($links as $link){		
		$linkVal = $link['value'];
		$linkIcon = $link['icon_key'];		
		$url = wpbb_get_asset_url('images/svg/fb.svg');

		if($linkIcon == 'facebook'){
			$linkBlock .= "<a class='social-link' href='$linkVal'><img src='$url'>";
		}
		else{
			$linkBlock .= "<a class='social-link' href='$linkVal'><i data-feather='$linkIcon'></i></a>";		
		}
		

	}

	return $linkBlock;
}


function wpbb_footer_social_links_block(){
	$links = wpbb_get_social_links();
	$linkBlock = '';


	$show_arr = array('facebook', 'instagram', 'houzz');

	// $fb = wpbb_get_svg('images/svg/fb.svg');

	foreach($links as $link){		

		if(!in_array($link['social_title'], $show_arr)){
			continue;
		}

		$linkVal = $link['value'];
		$linkIcon = $link['icon_key'];		
		$fburl = wpbb_get_asset_url('images/svg/fb.svg');
		$houzzurl = wpbb_get_asset_url('images/svg/houzz.svg');

		if($linkIcon == 'facebook'){
			$linkBlock .= "<a target='_blank' class='social-link' href='$linkVal'><img src='$fburl'>";
		}
		elseif($linkIcon == 'houzz'){
			$linkBlock .= "<a target='_blank' class='social-link' href='$linkVal'><img src='$houzzurl'>";	
		}
		else{
			$linkBlock .= "<a target='_blank' class='social-link' href='$linkVal'><i data-feather='$linkIcon'></i></a>";		
		}
		

	}

	return $linkBlock;
}