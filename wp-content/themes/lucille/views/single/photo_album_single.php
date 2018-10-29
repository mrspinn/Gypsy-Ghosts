<?php  
	$images = esc_html(get_post_meta(get_the_ID(), 'js_swp_gallery_images_id', true));
	$id_array = explode(',', $images);
	$id_array = array_filter($id_array);

	if (!empty($id_array)) {
		foreach($id_array as $imgId) {
			$singleObj = array();
			
			$attachObj = get_post($imgId);
			if (has_excerpt($imgId)) {
				/*on single gallery might throw error*/
				$singleObj['caption'] =  $attachObj->post_excerpt;	
			} else {
				$singleObj['caption'] =  '';
			}
			
			if ($imageSrc = wp_get_attachment_image_src($imgId, 'full')) {
				$singleObj['href'] = $imageSrc[0];
			} else {
				$singleObj['href'] = '';
			}
			$singleObj['image']	= wp_get_attachment_image( $imgId, 'medium_large');
			
			$galleryImages[] = $singleObj;
		}
	}
?>

<?php
$content = trim(get_the_content());
if (!empty($content)) {
?>
	<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">
		<?php the_content(); ?>
		<?php get_template_part('views/utils/sharing_icons'); ?>
	</div>
<?php
}

$allowed_html = array(
	'img'	=> array(
		'width'		=> array(),
		'height'	=> array(),
		'src'		=> array(),
		'class'		=> array(),
		'alt'		=> array(),
		'srcset'	=> array(),
		'sizes'		=> array()
	)
);
?>

<div class="lc_masonry_container">
	<div class="brick-size"></div>
	<?php
	$show_download_button = LUCILLE_SWP_show_download_button() ? "true" : "false";

	foreach ($galleryImages as $imageObj) { 
	?>
		<div class="lc_masonry_brick clearfix lc_single_gallery_brick">
			<div class="gallery_brick_overlay"></div>
			<a href="<?php echo esc_url($imageObj['href']); ?>" data-lightbox="photo_album" 
				data-download-button="<?php echo esc_attr($show_download_button); ?>" >
				<?php echo wp_kses($imageObj['image'], $allowed_html); ?>
				
				<?php if (!empty($imageObj['caption'])) { ?>
					<div class="swp_img_caption">
						<?php echo esc_html($imageObj['caption']); ?>
					</div>
				<?php } ?>

			</a>
		</div>
	<?php
	} 
	?>
</div>

<?php if (LUCILLE_SWP_has_cpt_comments()) { ?>
	<div class="lc_swp_boxed">
		<?php comments_template(); ?>
	</div>
<?php } ?>



