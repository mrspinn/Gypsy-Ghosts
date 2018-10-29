<?php

/*
	Load needed js scripts and css styles
*/


if (!function_exists('LUCILLE_SWP_load_scripts_and_styles')) {
	function LUCILLE_SWP_load_scripts_and_styles() {

		/*color scheme*/
		$scheme_file_name = LUCILLE_SWP_get_default_color_scheme();
		$scheme_file_name .= ".css";
		wp_register_style('color_scheme_css', get_template_directory_uri(). '/core/css/'.$scheme_file_name);
		wp_enqueue_style('color_scheme_css');


		wp_register_script('lucille_swp', get_template_directory_uri().'/core/js/lucille_swp.js', array('jquery', 'masonry', 'debouncedresize', 'justified-gallery', 'unslider', 'wavesurfer'), '', true);
		wp_enqueue_script( 'lucille_swp');

		/*lightbox*/
		wp_register_script('lightbox', get_template_directory_uri().'/assets/lightbox2/js/lightbox.js', array('jquery'), '', true);
		wp_enqueue_script( 'lightbox');

		wp_register_style('lightbox', get_template_directory_uri(). '/assets/lightbox2/css/lightbox.css');
		wp_enqueue_style('lightbox');		

		/*masonry*/
		wp_enqueue_script('masonry');
		wp_enqueue_script('imagesloaded');

		/*font awesome*/
		wp_register_style('font_awesome', get_template_directory_uri(). '/assets/font-awesome-4.7.0/css/font-awesome.min.css');
		wp_enqueue_style('font_awesome');

		/*linear icons free*/
		wp_register_style('linearicons', get_template_directory_uri(). '/assets/linearicons/style.css');
		wp_enqueue_style('linearicons');

		/*debounce resize*/
		wp_register_script('debouncedresize', get_template_directory_uri().'/core/js/jquery.debouncedresize.js', array('jquery'), '', true);
		wp_enqueue_script( 'debouncedresize');

		/*justified gallery*/
		wp_register_script('justified-gallery', get_template_directory_uri().'/assets/justifiedGallery/js/jquery.justifiedGallery.min.js', array('jquery'), '', true);
		wp_enqueue_script( 'justified-gallery');

		wp_register_style('justified-gallery', get_template_directory_uri(). '/assets/justifiedGallery/css/justifiedGallery.min.css');
		wp_enqueue_style('justified-gallery');

		/*unslider*/
		wp_register_script('unslider', get_template_directory_uri().'/assets/unslider/unslider-min.js', array('jquery'), '', true);
		wp_enqueue_script( 'unslider');

		wp_register_style('unslider', get_template_directory_uri(). '/assets/unslider/unslider.css');
		wp_enqueue_style('unslider');

		/*wavesurfer*/
		wp_register_script('wavesurfer', get_template_directory_uri().'/assets/wavesurfer/wavesurfer.min.js', array('jquery'), '', true);
		wp_enqueue_script( 'wavesurfer');		
	}
}
add_action('wp_enqueue_scripts', 'LUCILLE_SWP_load_scripts_and_styles');


if (!function_exists('LUCILLE_SWP_load_admin_scripts_and_styles')) {
	function LUCILLE_SWP_load_admin_scripts_and_styles() {
		wp_enqueue_media();

		/*alpha color picker*/
		wp_register_script('alpha_color_picker',  get_template_directory_uri().'/core/js/alpha-color-picker.js', array('jquery', 'wp-color-picker'), '', true);
		wp_enqueue_script('alpha_color_picker');

		wp_register_style('alpha_color_picker', get_template_directory_uri(). '/core/css/alpha-color-picker.css', array('wp-color-picker'));
		wp_enqueue_style('alpha_color_picker');

		/* theme settings*/
		wp_register_script('theme_settings',  get_template_directory_uri().'/settings/js/theme_settings.js', array('jquery', 'alpha_color_picker'), '', true);
		wp_enqueue_script('theme_settings');

		wp_register_style('theme_settings', get_template_directory_uri(). '/settings/css/theme_settings.css', array('alpha_color_picker'));
		wp_enqueue_style('theme_settings');
	}
}
add_action('admin_enqueue_scripts', 'LUCILLE_SWP_load_admin_scripts_and_styles');

?>