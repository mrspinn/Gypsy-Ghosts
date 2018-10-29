<?php 

if (!function_exists('LUCILLE_SWP_setup')) {
	function LUCILLE_SWP_setup() {
		//theme textdomain for translation/localization support - load_theme_textdomain( $domain, $path )
		$domain = 'lucille';
		// wp-content/languages/themes/lucille-de_DE.mo
		if (!load_theme_textdomain( $domain, trailingslashit(WP_LANG_DIR).$domain)) {
			// wp-content/themes/lucille/languages
			load_theme_textdomain('lucille', get_template_directory().'/languages');
		}

		// add editor style
		add_editor_style('custom-editor-style.css');
		
		// enables post and comment RSS feed links to head
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');
	 
		// enable support for Post Thumbnails, 
		add_theme_support('post-thumbnails');
		
		// register Menu
		register_nav_menus(
			array(
			  'main-menu' => esc_html__('Main Menu', 'lucille'),
			)
		);
		
		// custom background support
		global $wp_version;
		if (version_compare( $wp_version, '3.4', '>=')) {
			$defaults = array(
				'default-color'          => '151515',
				'default-image'          => '',
				'wp-head-callback'       => 'LUCILLE_SWP_custom_background_cb',
				'admin-head-callback'    => '',
				'admin-preview-callback' => ''
			);
			
			add_theme_support('custom-background',  $defaults); 
		}	

	}
}
add_action( 'after_setup_theme', 'LUCILLE_SWP_setup' );


function LUCILLE_SWP_custom_background_cb()
{
        $background = get_background_image();  
        $color = get_background_color();  
      
        if (!$background && !$color) {
        	return;
        }
      
        $style = $color ? "background-color: #$color;" : '';  
      
        if ( $background ) {  
            $image = " background-image: url('$background');";  
      
            $repeat = get_theme_mod( 'background_repeat', 'repeat' );  
      
            if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )  
                $repeat = 'repeat';  
      
            $repeat = " background-repeat: $repeat;";  
      
            $position = get_theme_mod( 'background_position_x', 'left' );  
      
            if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )  
                $position = 'left';  
      
            $position = " background-position: top $position;";  
      
            $attachment = get_theme_mod( 'background_attachment', 'scroll' );  
      
            if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )  
                $attachment = 'scroll';  
      
            $attachment = " background-attachment: $attachment;";  
      
            $style .= $image . $repeat . $position . $attachment;  
        }

		?>  
		<style type="text/css">  
			body, .woocommerce .woocommerce-ordering select option { <?php echo trim($style); ?> }  
		</style>  
		<?php  	
}

/*
	Load the main stylesheet - style.css
*/
if (!function_exists( 'LUCILLE_SWP_load_main_stylesheet')) {
	function LUCILLE_SWP_load_main_stylesheet()
	{
		wp_enqueue_style('style', get_stylesheet_uri());
	}
}
add_action( 'wp_enqueue_scripts', 'LUCILLE_SWP_load_main_stylesheet' );

/*
	Load the font related css
*/
if (!function_exists( 'LUCILLE_SWP_load_fonts_css')) {
	function LUCILLE_SWP_load_fonts_css() {

		wp_enqueue_style('default_fonts', get_template_directory_uri() . "/core/css/fonts/default_fonts.css");	

		if (!LUCILLE_SWP_use_default_fonts()) {
			$primary_font = LUCILLE_SWP_get_user_primary_font();
			$secondary_font = LUCILLE_SWP_get_user_secondary_font();

			$user_fonts_css = '
				body, #heading_area.have_subtitle h1.title_full_color, #heading_area h1.title_transparent_color, 
				h3#comments-title,
				.woocommerce ul.products li.product h3,
				h2.section_title, h5.lc_reviewer_name, textarea {
					font-family: ' . $primary_font . ', sans-serif;
				}

				#logo, #mobile_logo, #heading_area h1, .heading_area_subtitle.title_full_color h2,
				input[type="submit"],
				.heading_area_subtitle.title_transparent_color h2,
				h3.footer-widget-title, h3.widgettitle,
				.lc_share_item_text, .lb-number, .lc_button, .woocommerce a.button, input.button, .woocommerce input.button, button.single_add_to_cart_button, h2.lc_post_title,
				.page_navigation,
				.eventlist_month, .emphasize_first .event_location, .emphasize_first .event_venue, .emphasize_first .event_buy, .lc_view_more, 
				h1, h2, h3, h4, h5, h6,  .wave_song_action, .artist_nickname, .swp_lightbox_downbutton {
					font-family: ' . $secondary_font . ', sans-serif;
				}
			';

			wp_add_inline_style( 'default_fonts', $user_fonts_css );
		} 
	}
}
add_action('wp_enqueue_scripts', 'LUCILLE_SWP_load_fonts_css');



/*
	Load Needed Google Fonts
*/
if ( !function_exists('LUCILLE_SWP_load_google_fonts') ) {
	function LUCILLE_SWP_load_google_fonts()
	{
		$google_fonts_family = LUCILLE_SWP_get_fonts_family_from_settings();

		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'jamsession-opensans-oswald', $protocol."://fonts.googleapis.com/css?family=".$google_fonts_family);
	}
}
add_action( 'wp_enqueue_scripts', 'LUCILLE_SWP_load_google_fonts' );


/*
	Control Excerpt Length
*/
if (!function_exists('LUCILLE_SWP_excerpt_length')) {
	function LUCILLE_SWP_excerpt_length($length)
	{
		return 40;
	}
}
add_filter( 'excerpt_length', 'LUCILLE_SWP_excerpt_length', 999);


/*
	Remove [...] string from excerpt
*/
if ( ! function_exists( 'LUCILLE_SWP_excerpt_more' ) ) {
	function LUCILLE_SWP_excerpt_more($more) {
		return '...';
	}
}
add_filter('excerpt_more', 'LUCILLE_SWP_excerpt_more');


/*
	Implement Custom Excerpt for pages as well
*/
function LUCILLE_SWP_add_excerpt_to_pages() {
	add_post_type_support('page', 'excerpt');
}
add_action('init', 'LUCILLE_SWP_add_excerpt_to_pages');

/*
	Make Sure Content Width is Set
*/
if (!isset($content_width)) {
	$content_width = 900;
}

/*
	Allow Shortcodes In Text Widget
*/
add_filter('widget_text', 'do_shortcode');

?>