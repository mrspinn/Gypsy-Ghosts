<?php
/*
	Template Name: Artists
*/
?>

<?php get_header(); ?>

<?php
	if (get_query_var('paged')) {
		$paged = get_query_var('paged'); 
	} elseif (get_query_var('page')) { 
		$paged = get_query_var('page'); 
	} else {
		$paged = 1; 
	}

	$posts_per_page = get_option('posts_per_page');
	$offset = ($paged - 1) * $posts_per_page;

	$args = array(
		'numberposts'	=> -1,
		'posts_per_page'   => $posts_per_page,
		'paged'			   => $paged,
		'offset'           => $offset,
		'category'         => '',
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => array('js_artist'),
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => false
	);	
	$keep_old_wp_query = $wp_query;

	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);

	$items_on_row = 4;

	$single_item_template = "views/archive/artist_item";
	$item_count = 0;

	$archive_nav_classes = "blog_standard_nav discography_post_nav";
	$container_class = 'lc_content_full lc_basic_content_padding';
	if (3 == $items_on_row) {
		$container_class .= " lc_swp_boxed";
		$archive_nav_classes .= " lc_swp_boxed";
	} else {
		$container_class .= " lc_swp_full";
		$archive_nav_classes .= " lc_swp_full";
	}

	if ($wp_query->have_posts()) {
	?>	
		<div class="<?php echo esc_attr($container_class); ?>">
			<div class="albums_container clearfix">
				<?php
				while ($wp_query->have_posts()) : the_post();
					$item_count++;
					set_query_var('items_on_row', $items_on_row);
					set_query_var('item_count', $item_count);

					get_template_part($single_item_template);
				endwhile;
				?>
			</div>
		</div>
	<?php

		set_query_var("class_archive_nav", $archive_nav_classes);
		get_template_part('views/utils/archive_nav');
	}
	$wp_query = null; $wp_query = $keep_old_wp_query;
?>

<?php get_footer(); ?>