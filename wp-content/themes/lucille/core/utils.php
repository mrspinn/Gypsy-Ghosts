<?php

/*
	UTILITIES FUNCTIONS
*/
function LUCILLE_SWP_getIDFromShortURL($short_url) 
{
	@$elements = explode("/", $short_url);
	@$dim = count($elements); 
	
	if ($dim == 0) {
		return "";
	} else {
		return $elements[ $dim - 1];
	}
}

function LUCILLE_SWP_get_tax_name_by_post_type($post_type) {
	switch($post_type) {
		case "js_albums":
			return 'album_category';
		case 'js_events':
			return 'event_category';
		case 'js_photo_albums':
			return 'photo_album_category';
		case 'js_videos':
			return 'video_category';
		default:
			return 'category';
	}
}

function LUCILLE_SWP_get_tax_name_by_page_template($page_template) {
	switch ($page_template) {
		case 'template-events-past.php':
		case 'template-events-upcoming.php':
		case 'template-events-all.php':
			return LUCILLE_SWP_get_tax_name_by_post_type('js_events');
		case 'template-photo-gallery.php':
			return LUCILLE_SWP_get_tax_name_by_post_type('js_photo_albums');
		case 'template-videos.php':
			return LUCILLE_SWP_get_tax_name_by_post_type('js_videos');
		case 'template-discography.php':
			return LUCILLE_SWP_get_tax_name_by_post_type('js_albums');
		default:
			return 'category';
	}
}


function LUCILLE_SWP_emphasize_title_for_this_page() {
	$templates_to_match = array(
		'template-events-all.php',
		'template-events-past.php',
		'template-events-upcoming.php',
		'template-photo-gallery.php',
		'template-blog.php',
		'template-videos.php',
		'template-discography.php'
	);

	if (is_page_template($templates_to_match)) {
		return true;
	}

	return false;
}

function LUCILLE_SWP_get_translated_month($english_month_name) {

	switch (strtolower($english_month_name)) {
	    case "january":
			return esc_html__("january", "lucille");
	    case "february":
			return esc_html__("february", "lucille");
	    case "march":
			return esc_html__("march", "lucille");
	    case "april":
			return esc_html__("april", "lucille");
	    case "may":
			return esc_html__("may", "lucille");
	    case "june":
			return esc_html__("june", "lucille");
	    case "july":
			return esc_html__("july", "lucille");
	    case "august":
			return esc_html__("august", "lucille");
	    case "september":
			return esc_html__("september", "lucille");
	    case "october":
			return esc_html__("october", "lucille");
	    case "november":
			return esc_html__("november", "lucille");
	    case "december":
			return esc_html__("december", "lucille");
	}

	return $english_month_name;
}

function LUCILLE_SWP_is_sharing_visible() {
	/*always disable sharing for some pages*/
	if (function_exists("is_checkout")) {
		if (is_checkout() || is_cart()) {
			return false;
		}
	}

	return LUCILLE_SWP_show_sharing_icons_by_setting();
}

function LUCILLE_SWP_is_woocommerce_active()
{
	if (class_exists('woocommerce')) {
		return true;
	}

	return false;
}

function LUCILLE_SWP_is_woocommerce_special_page() {
	if (function_exists("is_shop")) {
		if (is_shop()) {
			return true;
		}
	}
	if (function_exists("is_product")) {
		if (is_product()) {
			return true;
		}
	}
	if (function_exists("is_cart")) {
		if (is_cart()) {
			return true;
		}
	}

	return false;
}

function LUCILLE_SWP_get_current_page_id() {
	if (LUCILLE_SWP_is_woocommerce_active()) {
		if (is_shop()) {
			return wc_get_page_id('shop');
		}
		if (is_account_page()) {
			return wc_get_page_id('myaccount');
		}
		if (is_checkout()) {
			return wc_get_page_id('checkout');	
		}
	}

	if (!in_the_loop()) {
    	/** @var $wp_query wp_query */
	    global $wp_query;
		return  $wp_query->get_queried_object_id();
	}

	return get_the_ID();
}

function LUCILLE_SWP_get_page_custom_menu_style(&$page_logo, &$menu_bar_bg, &$menu_txt_col) {
	$post_id 		= LUCILLE_SWP_get_current_page_id();
	$page_logo = $menu_bar_bg = $menu_txt_col = $above_menu_bg = $above_menu_txt_col = "";

	$page_logo 	= get_post_meta($post_id, 'lc_swp_meta_page_logo', true);
	$menu_bar_bg = get_post_meta($post_id, 'lc_swp_meta_page_menu_bg', true);
	$menu_txt_col = get_post_meta($post_id, 'lc_swp_meta_page_menu_txt_color', true);

	return (!empty($menu_bar_bg) ||
		!empty($menu_txt_col));
}

function LUCILLE_SWP_is_product_archive() {
	if (!LUCILLE_SWP_is_woocommerce_active()) {
		return false;
	}

	if (is_shop()) {
		return true;
	}

	return false;
}

if (! function_exists('LUCILLE_SWP_show_meta_header')) 
{
	function LUCILLE_SWP_show_meta_header() {
		$post_id = LUCILLE_SWP_get_current_page_id();
		$post_type = get_post_type($post_id);		

		if( $post_type == "js_videos" || $post_type == "js_events" ) {
			if (has_post_thumbnail()) {
				$picture_link = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
				if( $picture_link != "")
				{
					?>
					<meta property="og:image" content="<?php echo esc_attr($picture_link); ?>" />
					<?php
				}
			}				
			?>
			<meta property="og:description" content="<?php echo esc_attr(the_excerpt()); ?>" />
			<?php			
		}	
	}
}

?>
