<?php


function pn_get_template_name( $page_id = null ) {
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
function encrypt_text( $plain_text ){
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $h_key = hash('sha256', wp_salt(), TRUE);
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $h_key, $plain_text, MCRYPT_MODE_ECB, $iv));
}
 
/**
 * Decrypt Text
 */
function decrypt_text( $encrypted_text ){
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $h_key = hash('sha256', wp_salt(), TRUE);
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $h_key, base64_decode( $encrypted_text ), MCRYPT_MODE_ECB, $iv));
}

function buildTree( array &$elements, $parentId = 0 )
{
    $branch = array();
    foreach ( $elements as &$element )
    {
        if ( $element->menu_item_parent == $parentId )
        {
            $children = buildTree( $elements, $element->ID );
            if ( $children )
                $element->wpse_children = $children;

            $branch[$element->ID] = $element;
            unset( $element );
        }
    }
    return $branch;
}


function page_nav($menu_name){
	
	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);	
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		$link_arr = array();
		$nav_block = '';

		$items = buildTree($menu_items, 0);
	
		foreach($items as $item){

			if($item->wpse_children){
				$nav_block .= "<li class='nav-item top-level'><a href='". $item->url ."'>". $item->title ."</a>";
				$nav_block .= "<ul class='sub-links'>";
				foreach($item->wpse_children as $child){					
					$nav_block .= "<li><a href='". $child->url ."'>".$child->title."</a></li>";						
				}
				$nav_block .= "</ul></li>";
			}
			else{
				$nav_block .= "<li class='nav-item top-level'><a href='". $item->url ."'>". $item->title ."</a></li>";
			}
		}
		
	} else {
		// $menu_list = '<!-- no list defined -->';
	}

	return $nav_block;	
}


function get_asset_url($file){
	// $url = get_template_directory_uri() . '/assets/' . $file;
	$url = get_template_directory_uri() . '/assets/' . $file;
	return $url;
}


//Function to convert ACF Image to url and size
function get_image($image, $size, $class = NULL){
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


function get_svg($filename){
	$svg_file = file_get_contents(get_asset_url("$filename"));

	$find_string   = '<svg';
	$position = strpos($svg_file, $find_string);

	$svg_file_new = substr($svg_file, $position);

	echo $svg_file_new;
}
