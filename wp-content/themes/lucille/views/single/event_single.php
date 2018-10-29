<?php

	$event_date = esc_html(get_post_meta(get_the_ID(), 'event_date', true));
	$event_time = esc_html(get_post_meta(get_the_ID(), 'event_time', true));
	
	$event_venue = esc_html(get_post_meta(get_the_ID(), 'event_venue', true));
	$event_venue_url = esc_html(get_post_meta(get_the_ID(), 'event_venue_url', true));
	$venue_target = esc_html(get_post_meta(get_the_ID(), 'event_venue_target', true));
	if (empty($venue_target)) {
		$venue_target = "_blank";
	}
	
	$event_location = esc_html(get_post_meta(get_the_ID(), 'event_location', true));
	
	$event_buy_tickets_message = esc_html(get_post_meta(get_the_ID(), 'event_buy_tickets_message', true));
	$event_buy_tickets_url = esc_html(get_post_meta(get_the_ID(), 'event_buy_tickets_url', true));
	$tickets_target = esc_html(get_post_meta(get_the_ID(), 'event_buy_tickets_target', true));
	if (empty($tickets_target)) {
		$tickets_target = "_blank";
	}
	
	$event_fb_message = esc_html(get_post_meta(get_the_ID(), 'event_fb_message', true));
	$event_fb_url  = esc_html(get_post_meta(get_the_ID(), 'event_fb_url', true));
	
	$event_map_url  = get_post_meta(get_the_ID(), 'event_map_url', true);
	
	
	$event_videos_link  = esc_html(get_post_meta(get_the_ID(), 'event_videos_link', true));			
	$event_gallery_link  = esc_html(get_post_meta(get_the_ID(), 'event_gallery_link', true));

	$event_youtube_url  = esc_url(get_post_meta(get_the_ID(), 'event_youtube_url', true));	
	$event_vimeo_url  = esc_url(get_post_meta(get_the_ID(), 'event_vimeo_url', true));

	/*data processing*/
	@$event_date = str_replace("/","-", $event_date);
	@$dateObject = new DateTime($event_date);
	$output_date = date_i18n(get_option('date_format'), $dateObject->format('U'));
	/*default schema time stamp - if time is not specified*/
	$schema_time = $dateObject->format(DateTime::ATOM);

	$output_time = '';
	if ($event_time != '') {
		$build_time = $event_date." ".$event_time.":00";
		if (strtotime($build_time)) {
			$time_obj =  new DateTime($build_time);
			$output_time = $time_obj->format(get_option('time_format'));
			$schema_time = $time_obj->format(DateTime::ATOM);
		} else {
			$output_time = $event_time;
		}		
	}

	/*multiday & end date*/
	$event_multiday	= get_post_meta(get_the_ID(), 'event_multiday', true);
	if (!empty($event_multiday)) {
		$event_end_date = esc_html(get_post_meta(get_the_ID(), 'event_end_date', true));
		if ($event_end_date != "") {
			@$event_end_date = str_replace("/","-", $event_end_date);
			@$endDateObject = new DateTime($event_end_date);
			$output_end_date = date_i18n(get_option('date_format'), $endDateObject->format('U'));
		}
	}

	$left_class = 'event_left';
	if (!has_post_thumbnail()) {
		$left_class = 'event_left_full';
	}

	/*if buy tickets message is empty - give it a default value*/
	if (empty($event_buy_tickets_message) && !empty($event_buy_tickets_url)) {
		$event_buy_tickets_message = esc_html__('Tickets', 'lucille');
	}

	if (empty($event_fb_message) && !empty($event_fb_url)) {
		$event_fb_message = esc_html__('Facebook Event ', 'lucille');	
	}
	

?>

<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">
	<div class="<?php echo esc_attr($left_class); ?>">
		<div class="event_short_details" itemscope itemtype="http://schema.org/Event">
			<div class="lc_event_entry" itemprop="startDate" content="<?php echo $schema_time; ?>">
				<i class="fa fa-calendar" aria-hidden="true"></i>
				<?php 
					echo esc_html($output_date); 
					if (!empty($event_multiday)) {
						echo esc_html("&#32;&#45;&#32;" . $output_end_date);
					}
				?>
			</div>

			<?php if ($output_time != '') { ?>
			<div class="lc_event_entry">
				<i class="fa fa-clock-o" aria-hidden="true"></i>
				<?php echo esc_html($output_time); ?>
			</div>
			<?php }?>

			<?php if ($event_location != '') { ?>
			<div class="lc_event_entry" itemprop="location" itemscope itemtype="http://schema.org/Place">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
				 <span itemprop="name"> <?php echo esc_html($event_location); ?> </span>
			</div>
			<?php } ?>

			<?php if ($event_venue) { ?>
			<div class="lc_event_entry">
				<i class="fa fa-map-pin" aria-hidden="true"></i>
				<a href="<?php echo esc_url($event_venue_url); ?>" target="<?php echo esc_attr($venue_target); ?>">
					<?php echo esc_html($event_venue); ?>
				</a>
			</div>

			<div class="lc_event_entry display_none" itemprop="name">
				<?php the_title(); ?>
			</div>
			<a itemprop="url" href="<?php the_permalink(); ?>" class="display_none">Event</a>
		</div>
		<?php } ?>


		<div class="small_content_padding">
			<?php if ((!empty($event_buy_tickets_url)) || (!empty($event_fb_url))) { ?>
			<div class="lc_event_entry">
				<?php if (!empty($event_buy_tickets_url)) { ?>
				<div class="lc_button">
					<a href="<?php echo esc_url($event_buy_tickets_url); ?>" target="<?php echo esc_attr($tickets_target); ?>">
						<?php echo esc_html($event_buy_tickets_message); ?>
					</a>
				</div>
				<?php } ?>

				<?php if (!empty($event_fb_url)) { ?>
					<div class="lc_button">
						<a href="<?php echo esc_url($event_fb_url); ?>" target="_blank">
							<?php echo esc_html($event_fb_message); ?>
						</a>
					</div>
				<?php } ?>
			</div>
			<?php } ?>



			<?php the_content(); ?>
			<?php get_template_part('views/utils/sharing_icons'); ?>
		</div>
	</div>

	<?php if (has_post_thumbnail() || ($event_youtube_url != "") || ($event_vimeo_url != "")) { ?>
	<div class="event_right">
		<?php 
		if (has_post_thumbnail()) {
			the_post_thumbnail('large'); 
		}
		?>

		<?php if (($event_youtube_url != "") || ($event_vimeo_url != "")) { ?>
			<div class="lc_embed_video_container_full">
			<?php
				$website_protocol = is_ssl() ? 'https' : 'http';
				if ($event_youtube_url != "") {
					?>
						<iframe src="<?php echo esc_attr($website_protocol); ?>://www.youtube.com/embed/<?php echo LUCILLE_SWP_getIDFromShortURL(esc_url($event_youtube_url)); ?>?autoplay=0&amp;enablejsapi=1&amp;wmode=transparent&amp;rel=0&amp;showinfo=0" allowfullscreen></iframe>';
					<?php
				} else {
					if ($event_vimeo_url != "") {
						?>
						<iframe src="<?php echo esc_attr($website_protocol); ?>://player.vimeo.com/video/<?php echo LUCILLE_SWP_getIDFromShortURL(esc_url($event_vimeo_url)); ?>?autoplay=0&amp;byline=0&amp;title=0&amp;portrait=0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						<?php
					}
				}
			?>
			</div>
		<?php } ?>
	</div>
	<?php } ?>



	<div class="clearfix"></div>

</div>

<div class="lc_swp_boxed">
	<?php if (!empty($event_map_url)) { ?>
	<div class="lc_content_full gmap_container event_gmap">
		<?php 
			$allowedTags = array(
					'iframe'	=> array(
							'src'			=> array(),
							'width'			=> array(),
							'height'		=> array(),
							'frameborder'	=> array(),
							'style'			=> array()
						)
				);
			
			$escaped_map = wp_kses($event_map_url, $allowedTags);
			/*run do_shortcode in case of JetPack shortcode*/
			echo (0 == strpos($escaped_map, "[googlemaps")) ? do_shortcode($escaped_map) : $escaped_map;
		?>
	</div>
	<?php } ?>
</div>

<?php if (LUCILLE_SWP_has_cpt_comments()) { ?>
	<div class="lc_swp_boxed">
		<?php comments_template(); ?>
	</div>
<?php } ?>

