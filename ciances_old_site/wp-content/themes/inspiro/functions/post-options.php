<?php


/* Registering metaboxes
============================================*/

add_action( 'admin_head-post-new.php', array( 'WPZOOM_Video_Thumb', 'admin_newpost_head' ), 100 );
add_action( 'admin_head-post.php', array( 'WPZOOM_Video_Thumb', 'admin_newpost_head' ), 100 );

add_action( 'admin_menu', 'wpzoom_options_box' );

function wpzoom_options_box() {

	add_meta_box( 'wpzoom_top_button', 'Slideshow Options', 'wpzoom_top_button_options', 'slider', 'side', 'high' );

	add_meta_box(
		'wpzoom_slideshow_video_settings',
		'Video Settings',
		'wpzoom_slideshow_video_settings',
		'slider',
		'normal',
		'high'
	);

	add_meta_box(
		'wpzoom_portfolio_video_settings',
		'Video Settings',
		'wpzoom_portfolio_video_settings',
		'portfolio_item',
		'normal',
		'high'
	);
}

function wpz_newpost_head() {
	?>
	<style type="text/css">
		fieldset.fieldset-show {
			padding: 0.3em 0.8em 1em;
			margin-top: 20px;
			border: 1px solid rgba(0, 0, 0, 0.2);
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			border-radius: 3px;
		}

		fieldset.fieldset-show p {
			margin: 0 0 1em;
		}

		fieldset.fieldset-show p:last-child {
			margin-bottom: 0;
		}

		.wpz_list {
			font-size: 12px;
		}

		.wpz_border {
			border-bottom: 1px solid #EEEEEE;
			padding: 0 0 10px;
		}

	</style><?php
}

add_action( 'admin_head-post-new.php', 'wpz_newpost_head', 100 );
add_action( 'admin_head-post.php', 'wpz_newpost_head', 100 );

/**
 * Inline styles for tabs that a rendered in metaboxes.
 */
function get_tabs_inline_style(){
	?>
	<style type="text/css">
		ul.metabox-tabs {
			margin-bottom: 0;
			padding: 0 10px 0 10px;
			height: 30px;
			padding-top: 5px;
		}

		ul.metabox-tabs li {
			list-style: none;
			display: inline;
			font-size: 12px;
		}

		ul.metabox-tabs li.tab a {
			display: block;
			float: left;
			margin-right: 4px;
			margin-bottom: -1px;
			padding: 6px 10px;
			filter: alpha(opacity=50);
			opacity: .5;
			-webkit-opacity: .5;
			-moz-opacity: .5;
			background: #fff;
			color: #000;
			outline: none;
			font-weight: bold;
			text-decoration: none;
			zoom: 1;
			border: 1px solid #e1e1e1;
			border-bottom: none;
			background: #e1e1e1;
		}

		ul.metabox-tabs li.tab a.active,
		ul.metabox-tabs li.tab a:hover {
			background: #fff;
			opacity: 1;
			-webkit-opacity: 1;
			-moz-opacity: 1;
			filter: alpha(opacity=100);
		}

		ul.metabox-tabs li.tab a:hover {
			background: #e1e1e1;
		}

		ul.metabox-tabs li.tab a.active:hover {
			background: #fff;
		}

		ul.metabox-tabs li.link {
			margin-left: 4px;
		}

		ul.metabox-tabs li.link a {
			text-decoration: none;
		}

		ul.metabox-tabs li.link a:hover {
			text-decoration: underline;
		}

		ul.metabox-tabs {
		}

		ul.metabox-tabs li.tab a {
			color: #4545459;
		}

		ul.metabox-tabs li.tab a {
			background: #f0f0f09; \9;
		}

		ul.metabox-tabs li.tab a.active,
		ul.metabox-tabs li.tab a:hover {
			color: #454545;
		}

		.zoom-tab {
			border: 1px solid #e1e1e1;
			padding: 10px 15px 15px;
		}

		.preview-video-input-span {
			position: relative;
		}

		.preview-video-input-span img.wpzoom-preloader {
			position: absolute;
			right: 6px;
			top: 0;
		}

	</style>
	<?php
}
/**
 * Portfolio metabox content
 */

function wpzoom_portfolio_video_settings() {
	global $post;

	$postmeta_videotype = get_post_meta( $post->ID, 'wpzoom_portfolio_popup_video_type', true );
	$post_meta          = empty( $postmeta_videotype ) ? 'self_hosted' : $postmeta_videotype;
	$tab_order          = get_post_meta( $post->ID, 'wpzoom_portfolio_tab_order', true ) === false ? 0 : get_post_meta( $post->ID, 'wpzoom_portfolio_tab_order', true );
	?>
	<?php get_tabs_inline_style() ?>

	<div class="portfolio-tabs">
		<ul class="metabox-tabs">
			<li data-tab-order="0" class="tab">
				<a class="<?php echo $tab_order == 0 ? 'active': '' ?>" href="#portfolio-popup">Video Lightbox</a>
			</li>
			<li data-tab-order="1" class="tab">
				<a class="<?php echo $tab_order == 1 ? 'active': '' ?>" href="#portfolio-background">Video Background on Hover</a>
			</li>
			<input type="hidden" name="wpzoom_portfolio_tab_order" value="<?php echo esc_attr( $tab_order ); ?>" />
		</ul>
		<div class="zoom-tab" id="portfolio-popup">
			<div class="radio-switcher">

				<p class="description">Using this option you can display a video in a lightbox which can be opened
					clicking on
					the <strong>Play</strong> button.</p>

				<label><input type="radio" name="wpzoom_portfolio_popup_video_type"
				              value="self_hosted" <?php checked( $post_meta, 'self_hosted' ); ?>> <?php _e( 'Self Hosted File', 'wpzoom' ) ?>
				</label>
				<label>&nbsp;&nbsp;&nbsp;<input type="radio" name="wpzoom_portfolio_popup_video_type"
				                                value="external_hosted" <?php checked( $post_meta, 'external_hosted' ); ?>> <?php _e( 'YouTube / Vimeo', 'wpzoom' ) ?>
				</label>
			</div>

			<div class="wpzoom_self_hosted switch-wrapper">

				<br/>
				<div class="wp-media-buttons" data-button="Set Video" data-title="Set Video"
				     data-target="#wpzoom_portfolio_video_popup_url">
					<a href="#" class="button add_media wpz-upload-video-control" title="Upload Video">
						<span class="wp-media-buttons-icon"></span>
						<?php _e( 'Upload Video', 'wpzoom' ); ?>
					</a>
				</div>

				<div class="clear"></div>

				<p>
					<label>
						<strong><?php _e( 'MP4 (h.264) video URL', 'wpzoom' ); ?></strong>
						<input type="text" name="wpzoom_portfolio_video_popup_url_mp4"
						       id="wpzoom_portfolio_video_popup_url_mp4"
						       class="widefat"
						       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_portfolio_video_popup_url_mp4', true ) ); ?>"/>

				<p class="description"><?php _e( 'This format is supported by most of the browsers and mobile devices.', 'wpzoom' ); ?>
					</label>
				</p>

				<div class="wpz_border"></div>

				<p>
					<label>
						<strong><?php _e( 'WebM video URL', 'wpzoom' ); ?></strong> <em>(optional)</em>
						<input type="text" name="wpzoom_portfolio_video_popup_url_webm"
						       id="wpzoom_portfolio_video_popup_url_webm" class="widefat"
						       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_portfolio_video_popup_url_webm', true ) ); ?>"/>

				<p class="description"><?php _e( 'This format is optional for old versions of <strong>Mozilla Firefox</strong> that don\'t support <strong>MP4</strong> (v.21 and older).', 'wpzoom' ); ?>
					</label>
				</p>


                <div class="wpz_border"></div>
                <p>
                    <em><strong>Tips:</strong></em><br/>
                <ol class="wpz_list">
                    <li>If your server can't play MP4 videos, check this <a
                            href="https://www.wpzoom.com/docs/enable-mp4-video-support-linuxapache-server/"
                            target="_blank">tutorial</a> for a fix.
                    </li>
                    <li>Your <strong>MP4</strong> videos must have the <em>H.264</em> encoding. You can convert your videos with <a
                            href="https://handbrake.fr/downloads.php" target="_blank">HandBrake</a> video converter.
                    </li>
                </ol>
                </p>

			</div>

			<div class="wpzoom_external_hosted switch-wrapper" style="display: inline-block; width: 100%;">
				<p>
					<label
						for="wpzoom_portfolio_video_popup_url"><strong><?php _e( 'Insert Video Url', 'wpzoom' ); ?></strong>
						<em>(YouTube and Vimeo only)</em></label>
					<span class="preview-video-input-span">
					<input type="text"
					       id="wpzoom_portfolio_video_popup_url"
					       class="preview-video-input widefat"
					       name="wpzoom_portfolio_video_popup_url"
					       data-response-type="thumb"
					       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_portfolio_video_popup_url', true ) ); ?>"/>
						<img src="<?php echo esc_url( admin_url( 'images/spinner-2x.gif' ) ); ?>" width="16" height="16"
						     alt=""
						     class="wpzoom-preloader hidden"/>
					</span>
				</p>
				<div class="wpzoom_video_external_preview">

				</div>
			</div>

		</div>
		<div class="zoom-tab" id="portfolio-background">

            <p class="description">Here you can add a short self-hosted video that will play automatically when hovering current Portfolio post in the Portfolio page or Portfolio widgets on the homepage.</p>


			<div class="wp-media-buttons" data-button="Set Video" data-title="Set Video"
			     data-target="#wpzoom_portfolio_video_background">
				<a href="#" class="button add_media wpz-upload-video-control" title="Upload Video">
					<span class="wp-media-buttons-icon"></span>
					<?php _e( 'Upload Video', 'wpzoom' ); ?>
				</a>
			</div>

			<div class="clear"></div>

			<p>
				<label>
					<strong><?php _e( 'MP4 (h.264) video URL', 'wpzoom' ); ?></strong>
					<input type="text" name="wpzoom_portfolio_video_background_mp4" id="wpzoom_portfolio_video_background_mp4"
					       class="widefat"
					       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_portfolio_video_background_mp4', true ) ); ?>"/>

			<p class="description"><?php _e( 'This format is supported by most of the browsers and mobile devices.', 'wpzoom' ); ?>
				</label>
			</p>

			<div class="wpz_border"></div>

			<p>
				<label>
					<strong><?php _e( 'WebM video URL', 'wpzoom' ); ?></strong> <em>(optional)</em>
					<input type="text" name="wpzoom_portfolio_video_background_webm" id="wpzoom_portfolio_video_background_webm"
					       class="widefat"
					       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_portfolio_video_background_webm', true ) ); ?>"/>

			<p class="description"><?php _e( 'This format is optional for old versions of <strong>Mozilla Firefox</strong> that don\'t support <strong>MP4</strong> (v.21 and older).', 'wpzoom' ); ?>
				</label>
			</p>
		</div>
	</div>

	<?php
}

/* Slideshow Options
============================================*/
function wpzoom_top_button_options() {
	global $post;

	?>

	<div>
		<strong><label for="wpzoom_slide_url"><?php _e( 'Slide URL', 'wpzoom' ); ?></label></strong>
		(<?php _e( 'optional', 'wpzoom' ); ?>)<br/>
		<p><input type="text" name="wpzoom_slide_url" id="wpzoom_slide_url" class="widefat"
		          value="<?php echo esc_url( get_post_meta( $post->ID, 'wpzoom_slide_url', true ) ); ?>"/></p>
		<p class="description"><?php _e( 'When a URL is added, the title of the current slide will become clickable', 'wpzoom' ); ?></p>

	</div>

	<fieldset class="fieldset-show">
		<legend><strong><?php _e( 'Slide Button', 'wpzoom' ); ?></strong> <?php _e( '(optional)', 'wpzoom' ); ?>
		</legend>

		<p>
			<label>
				<strong><?php _e( 'Title', 'wpzoom' ); ?></strong>
				<input type="text" name="wpzoom_slide_button_title" id="wpzoom_slide_button_title" class="widefat"
				       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_slide_button_title', true ) ); ?>"/>
			</label>
		</p>

		<p>
			<label>
				<strong><?php _e( 'URL', 'wpzoom' ); ?></strong>
				<input type="text" name="wpzoom_slide_button_url" id="wpzoom_slide_button_url" class="widefat"
				       value="<?php echo esc_url( get_post_meta( $post->ID, 'wpzoom_slide_button_url', true ) ); ?>"/>
			</label>
		</p>
	</fieldset>

	<?php
}

function wpzoom_slideshow_video_settings() {
	global $post;

	$tab_order                     = get_post_meta( $post->ID, 'wpzoom_slider_tab_order', true ) === false ? 0 : get_post_meta( $post->ID, 'wpzoom_slider_tab_order', true );
	$postmeta_videotype_background = get_post_meta( $post->ID, 'wpzoom_home_slider_video_type', true );
	$post_meta_background          = empty( $postmeta_videotype_background ) ? 'self_hosted' : $postmeta_videotype_background;
	$postmeta_videotype_popup      = get_post_meta( $post->ID, 'wpzoom_home_slider_popup_video_type', true );
	$post_meta_popup               = empty( $postmeta_videotype_popup ) ? 'self_hosted' : $postmeta_videotype_popup;
	?>
	<?php get_tabs_inline_style() ?>

	<div class="slider-tabs">
		<ul class="metabox-tabs">
			<li data-tab-order="0" class="tab">
				<a class="<?php echo $tab_order == 0 ? 'active': '' ?>" href="#slider-popup">Video Lightbox</a>
			</li>
			<li data-tab-order="1" class="tab">
				<a class="<?php echo $tab_order == 1 ? 'active': '' ?>" href="#slider-background">Video Background</a>
			</li>
			<input type="hidden" name="wpzoom_slider_tab_order" value="<?php echo esc_attr( $tab_order ); ?>" />
		</ul>
		<div class="zoom-tab" id="slider-popup">
			<div class="radio-switcher">

				<p class="description">Using this option you can display a video in a lightbox which can be opened clicking on
					the <strong>Play</strong> button.</p>

				<label><input type="radio" name="wpzoom_home_slider_popup_video_type"
				              value="self_hosted" <?php checked( $post_meta_popup, 'self_hosted' ); ?>> <?php _e( 'Self Hosted File', 'wpzoom' ) ?>
				</label>
				<label>&nbsp;&nbsp;&nbsp;<input type="radio" name="wpzoom_home_slider_popup_video_type"
				                                value="external_hosted" <?php checked( $post_meta_popup, 'external_hosted' ); ?>> <?php _e( 'YouTube / Vimeo', 'wpzoom' ) ?>
				</label>
			</div>

			<div class="wpzoom_self_hosted switch-wrapper">

				<br/>
				<div class="wp-media-buttons" data-button="Set Video" data-title="Set Video"
				     data-target="#wpzoom_home_slider_video_popup_url">
					<a href="#" id="wpzoom-home-slider-video-bg-insert-media-button"
					   class="button add_media wpz-upload-video-control" title="Upload Video">
						<span class="wp-media-buttons-icon"></span>
						<?php _e( 'Upload Video', 'wpzoom' ); ?>
					</a>
				</div>

				<div class="clear"></div>

				<p>
					<label>
						<strong><?php _e( 'MP4 (h.264) video URL', 'wpzoom' ); ?></strong>
						<input type="text" name="wpzoom_home_slider_video_popup_url_mp4"
						       id="wpzoom_home_slider_video_popup_url_mp4" class="widefat"
						       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_home_slider_video_popup_url_mp4', true ) ); ?>"/>

				<p class="description"><?php _e( 'This format is supported by most of the browsers and mobile devices.', 'wpzoom' ); ?>
					</label>
				</p>

				<div class="wpz_border"></div>

				<p>
					<label>
						<strong><?php _e( 'WebM video URL', 'wpzoom' ); ?></strong> <em>(optional)</em>
						<input type="text" name="wpzoom_home_slider_video_popup_url_webm"
						       id="wpzoom_home_slider_video_popup_url_webm" class="widefat"
						       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_home_slider_video_popup_url_webm', true ) ); ?>"/>

				<p class="description"><?php _e( 'This format is optional for old versions of <strong>Mozilla Firefox</strong> that don\'t support <strong>MP4</strong> (v.21 and older).', 'wpzoom' ); ?>
					</label>
				</p>

			</div>

			<div class="wpzoom_external_hosted switch-wrapper" style="display: inline-block; width: 100%;">
				<p>
					<label
						for="wpzoom_home_slider_video_popup_url"><strong><?php _e( 'Insert Video Url', 'wpzoom' ); ?></strong>
						<em>(YouTube and Vimeo only)</em></label>
					<span class="preview-video-input-span">
					<input type="text"
					       id="wpzoom_home_slider_video_popup_url"
					       class="preview-video-input widefat"
					       name="wpzoom_home_slider_video_popup_url"
					       data-response-type="thumb"
					       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_home_slider_video_popup_url', true ) ); ?>"/>

						<img src="<?php echo esc_url( admin_url( 'images/spinner-2x.gif' ) ); ?>" width="16" height="16"
						     alt=""
						     class="wpzoom-preloader hidden"/>
					</span>
				</p>
				<div class="wpzoom_video_external_preview" >

				</div>
			</div>
		</div>
		<div class="zoom-tab" id="slider-background">
			<p class="description"><?php _e( 'In this area you can upload a video which will play on the desktop computers in the background of the current slide continuously and muted by default.', 'wpzoom' ); ?></p>

			<div class="radio-switcher">

				<h3>Select Video Source:</h3>

				<label><input type="radio" name="wpzoom_home_slider_video_type"
				              value="self_hosted" <?php checked( $post_meta_background, 'self_hosted' ); ?>> <?php _e( 'Self Hosted File', 'wpzoom' ) ?>
				</label>
				<label>&nbsp;&nbsp;&nbsp;<input type="radio" name="wpzoom_home_slider_video_type"
				                                value="external_hosted" <?php checked( $post_meta_background, 'external_hosted' ); ?>> <?php _e( 'YouTube', 'wpzoom' ) ?>
				</label>
                <label>&nbsp;&nbsp;&nbsp;<input type="radio" name="wpzoom_home_slider_video_type"
                                                value="vimeo_pro" <?php checked( $post_meta_background, 'vimeo_pro' ); ?>> <?php _e( 'Vimeo', 'wpzoom' ) ?>
                </label>
			</div>


			<div class="wpzoom_self_hosted switch-wrapper">

				<br/>
				<div class="wp-media-buttons" data-button="Set Video" data-title="Set Video"
				     data-target="#wpzoom_home_slider_video_bg_url">
					<a href="#" id="wpzoom-home-slider-video-bg-insert-media-button"
					   class="button add_media wpz-upload-video-control" title="Upload Video">
						<span class="wp-media-buttons-icon"></span>
						<?php _e( 'Upload Video', 'wpzoom' ); ?>
					</a>
				</div>

				<div class="clear"></div>

				<p>
					<label>
						<strong><?php _e( 'MP4 (h.264) video URL', 'wpzoom' ); ?></strong>
						<input type="text" name="wpzoom_home_slider_video_bg_url_mp4" id="wpzoom_home_slider_video_bg_url_mp4"
						       class="widefat"
						       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_home_slider_video_bg_url_mp4', true ) ); ?>"/>

				<p class="description"><?php _e( 'This format is supported by most of the browsers and mobile devices.', 'wpzoom' ); ?>
					</label>
				</p>

				<div class="wpz_border"></div>

				<p>
					<label>
						<strong><?php _e( 'WebM video URL', 'wpzoom' ); ?></strong> <em>(optional)</em>
						<input type="text" name="wpzoom_home_slider_video_bg_url_webm" id="wpzoom_home_slider_video_bg_url_webm"
						       class="widefat"
						       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_home_slider_video_bg_url_webm', true ) ); ?>"/>

				<p class="description"><?php _e( 'This format is optional for old versions of <strong>Mozilla Firefox</strong> that don\'t support <strong>MP4</strong> (v.21 and older).', 'wpzoom' ); ?>
					</label>
				</p>

			</div>


			<div class="wpzoom_external_hosted switch-wrapper" style="display: inline-block; width: 100%;">
				<p>
					<label
						for="wpzoom_home_slider_video_external_url"><strong><?php _e( 'Insert Video URL', 'wpzoom' ); ?></strong>
						<em>(YouTube only. If you have a <strong>Vimeo PRO</strong> account, insert video file URL in the <strong>Self Hosted</strong> option)</em></label>
					<span class="preview-video-input-span">
					<input type="text"
					       id="wpzoom_home_slider_video_external_url"
					       name="wpzoom_home_slider_video_external_url"
					       data-response-type="thumb"
					       class="preview-video-input widefat"
					       value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_home_slider_video_external_url', true ) ); ?>"/>
						<img src="<?php echo esc_url( admin_url( 'images/spinner-2x.gif' ) ); ?>" width="16" height="16"
						     alt=""
						     class="wpzoom-preloader hidden"/>
					</span>
				</p>
				<div class="wpzoom_video_external_preview">
				</div>
			</div>

            <div class="wpzoom_vimeo_pro switch-wrapper" style="display: inline-block; width: 100%;">
                <p>
                    <label
                        for="wpzoom_home_slider_video_vimeo_pro"><strong><?php _e( 'Insert Video URL', 'wpzoom' ); ?></strong>
                        <em>(This method works best if you have a <strong>Vimeo PLUS, PRO or Business</strong> account)</em></label>
                    <span class="preview-video-input-span">
                    <input type="text"
                           id="wpzoom_home_slider_video_vimeo_pro"
                           name="wpzoom_home_slider_video_vimeo_pro"
                           data-response-type="thumb"
                           class="preview-video-input widefat"
                           value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_home_slider_video_vimeo_pro', true ) ); ?>"/>
                        <img src="<?php echo esc_url( admin_url( 'images/spinner-2x.gif' ) ); ?>" width="16" height="16"
                             alt=""
                             class="wpzoom-preloader hidden"/>
                    </span>
                </p>
                <div class="wpzoom_video_external_preview">
                </div>
            </div>

			<div class="wpz_border"></div>

			<h3><?php _e( 'Video Background Controls', 'wpzoom' ) ?></h3>

			<p class="description">Video controls will appear in the bottom right corner</p>

			<p>
				<label>

					<input type="hidden" name="wpzoom_slide_play_button" value="0"/>
					<input type="checkbox" name="wpzoom_slide_play_button" id="wpzoom_slide_play_button" class="widefat"
					       value="1" <?php checked( get_post_meta( $post->ID, 'wpzoom_slide_play_button', true ) == '' ? true : get_post_meta( $post->ID, 'wpzoom_slide_play_button', true ) ); ?>/> <?php _e( 'Show Play/Pause Button', 'wpzoom' ) ?>

				</label>
			</p>
			<p>
				<label>

					<input type="hidden" name="wpzoom_slide_mute_button" value="0"/>
					<input type="checkbox" name="wpzoom_slide_mute_button" id="wpzoom_slide_mute_button" class="widefat"
					       value="1" <?php checked( get_post_meta( $post->ID, 'wpzoom_slide_mute_button', true ) == '' ? true : get_post_meta( $post->ID, 'wpzoom_slide_mute_button', true ) ); ?>/> <?php _e( 'Show Mute/Unmute Button', 'wpzoom' ) ?>
				</label>
			</p>

			<div class="wpz_border"></div>


			<h3><?php _e( 'Video Background Options', 'wpzoom' ) ?></h3>

			<p>
				<label>


					<input type="hidden" name="wpzoom_slide_autoplay_video_action" value="0"/>
					<input type="checkbox" name="wpzoom_slide_autoplay_video_action" id="wpzoom_slide_autoplay_video_action"
					       class="widefat"
					       value="1" <?php checked( get_post_meta( $post->ID, 'wpzoom_slide_autoplay_video_action', true ) == '' ? true : get_post_meta( $post->ID, 'wpzoom_slide_autoplay_video_action', true ) ); ?>/> <?php _e( 'Autoplay Video', 'wpzoom' ) ?>
				</label>
			</p>
			<p>
				<label>

					<input type="hidden" name="wpzoom_slide_mute_video_action" value="0"/>
					<input type="checkbox" name="wpzoom_slide_mute_video_action" id="wpzoom_slide_mute_video_action"
					       class="widefat"
					       value="1" <?php checked( get_post_meta( $post->ID, 'wpzoom_slide_mute_video_action', true ) == '' ? true : get_post_meta( $post->ID, 'wpzoom_slide_mute_video_action', true ) ); ?>/> <?php _e( 'Mute Video', 'wpzoom' ) ?>
				</label>
			</p>
			<p>
				<label>

					<input type="hidden" name="wpzoom_slide_loop_video_action" value="0"/>
					<input type="checkbox" name="wpzoom_slide_loop_video_action" id="wpzoom_slide_loop_video_action"
					       class="widefat"
					       value="1" <?php checked( get_post_meta( $post->ID, 'wpzoom_slide_loop_video_action', true ) == '' ? true : get_post_meta( $post->ID, 'wpzoom_slide_loop_video_action', true ) ); ?>/> <?php _e( 'Loop Video <em>(if unchecked, then the video will play just once)</em>', 'wpzoom' ) ?>
				</label>
			</p>
			</fieldset>


			<div class="wpz_border"></div>
			<p>
				<em><strong>Good to know:</strong></em><br/>
			<ol class="wpz_list">
				<li>If your server can't play MP4 videos, check this <a
						href="http://www.wpzoom.com/docs/enable-mp4-video-support-linuxapache-server/"
						target="_blank">tutorial</a> for a fix.
				</li>
				<li>Your <strong>MP4</strong> videos must have the <em>H.264</em> encoding. You can convert your videos with <a
						href="http://handbrake.fr/downloads.php" target="_blank">HandBrake</a> video converter.
				</li>
				<li>Mobile devices & tablets <strong>don't support</strong> video background in order to prevent unsolicited data consumption, so we <a href="https://www.wpzoom.com/documentation/inspiro/#video" target="_blank">recommend</a> you to set a GIF file as Featured Image, and this will act as a video fallback on these devices.</li>
				</li>

			</ol>
			</p>
			<br/>
		</div>
	</div>
	<?php
}

add_filter( 'upload_mimes', 'inspiro_add_custom_mime_types' );
function inspiro_add_custom_mime_types( $mimes ) {
	return array_merge( $mimes, array(
		'webm' => 'video/webm',
	) );
}

add_action( 'save_post', 'custom_add_save' );

function custom_add_save( $postID ) {

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
        return $postID;
    }

	// called after a post or page is saved
	if ( $parent_id = wp_is_post_revision( $postID ) ) {
		$postID = $parent_id;
	}


    if ( isset( $_POST['post_type'] ) && ( $post_type_object = get_post_type_object( $_POST['post_type'] ) ) && $post_type_object->public ) {
        if ( current_user_can( 'edit_post', $postID ) ) {

    		if ( isset( $_POST['wpzoom_home_slider_video_type'] ) ) {
    			update_custom_meta( $postID, $_POST['wpzoom_home_slider_video_type'], 'wpzoom_home_slider_video_type' );
    		}

    		if ( isset( $_POST['wpzoom_home_slider_popup_video_type'] ) ) {
    			update_custom_meta( $postID, $_POST['wpzoom_home_slider_popup_video_type'], 'wpzoom_home_slider_popup_video_type' );
    		}

    		if ( isset( $_POST['wpzoom_slide_url'] ) ) {
    			update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_slide_url'] ), 'wpzoom_slide_url' );
    		}

    		if ( isset( $_POST['wpzoom_slide_button_title'] ) ) {
    			update_custom_meta( $postID, $_POST['wpzoom_slide_button_title'], 'wpzoom_slide_button_title' );
    		}

    		if ( isset( $_POST['wpzoom_slide_button_url'] ) ) {
    			update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_slide_button_url'] ), 'wpzoom_slide_button_url' );
    		}

    		if ( isset( $_POST['wpzoom_slide_play_button'] ) ) {
    			update_custom_meta( $postID, $_POST['wpzoom_slide_play_button'], 'wpzoom_slide_play_button' );
    		}

    		if ( isset( $_POST['wpzoom_slide_mute_button'] ) ) {
    			update_custom_meta( $postID, $_POST['wpzoom_slide_mute_button'], 'wpzoom_slide_mute_button' );
    		}

    		if ( isset( $_POST['wpzoom_slide_autoplay_video_action'] ) ) {
    			update_custom_meta( $postID, $_POST['wpzoom_slide_autoplay_video_action'], 'wpzoom_slide_autoplay_video_action' );
    		}

    		if ( isset( $_POST['wpzoom_slide_loop_video_action'] ) ) {
    			update_custom_meta( $postID, $_POST['wpzoom_slide_loop_video_action'], 'wpzoom_slide_loop_video_action' );
    		}

    		if ( isset( $_POST['wpzoom_slide_mute_video_action'] ) ) {
    			update_custom_meta( $postID, $_POST['wpzoom_slide_mute_video_action'], 'wpzoom_slide_mute_video_action' );
    		}

    		if ( isset( $_POST['wpzoom_home_slider_video_bg_url_mp4'] ) ) {
    			update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_home_slider_video_bg_url_mp4'] ), 'wpzoom_home_slider_video_bg_url_mp4' );
    		}

    		if ( isset( $_POST['wpzoom_home_slider_video_bg_url_webm'] ) ) {
    			update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_home_slider_video_bg_url_webm'] ), 'wpzoom_home_slider_video_bg_url_webm' );
    		}

    		if ( isset( $_POST['wpzoom_home_slider_video_popup_url_mp4'] ) ) {
    			update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_home_slider_video_popup_url_mp4'] ), 'wpzoom_home_slider_video_popup_url_mp4' );
    		}

    		if ( isset( $_POST['wpzoom_home_slider_video_popup_url_webm'] ) ) {
    			update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_home_slider_video_popup_url_webm'] ), 'wpzoom_home_slider_video_popup_url_webm' );
    		}

    		if ( isset( $_POST['wpzoom_home_slider_video_external_url'] ) ) {
    			update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_home_slider_video_external_url'] ), 'wpzoom_home_slider_video_external_url' );
    		}

            if ( isset( $_POST['wpzoom_home_slider_video_vimeo_pro'] ) ) {
                update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_home_slider_video_vimeo_pro'] ), 'wpzoom_home_slider_video_vimeo_pro' );

                $oembed   = _wp_oembed_get_object();
                $data     = $oembed->get_data( $_POST['wpzoom_home_slider_video_vimeo_pro'] );
                $video_id = ! empty( $data->video_id ) ? $data->video_id : false;

                update_custom_meta( $postID, $video_id, 'wpzoom_home_slider_video_vimeo_pro_video_id' );
            }

    		if ( isset( $_POST['wpzoom_home_slider_video_popup_url'] ) ) {
    			update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_home_slider_video_popup_url'] ), 'wpzoom_home_slider_video_popup_url' );
    		}

    		if ( isset( $_POST['wpzoom_slider_tab_order'] ) ) {
    			update_post_meta( $postID, 'wpzoom_slider_tab_order', $_POST['wpzoom_slider_tab_order'] );
    		}


    		// Porfolio metakeys
    		if ( isset( $_POST['wpzoom_portfolio_tab_order'] ) ) {
    			update_post_meta( $postID, 'wpzoom_portfolio_tab_order', $_POST['wpzoom_portfolio_tab_order'] );
    		}

    		if ( isset( $_POST['wpzoom_portfolio_popup_video_type'] ) ) {
    			update_post_meta( $postID, 'wpzoom_portfolio_popup_video_type', $_POST['wpzoom_portfolio_popup_video_type'] );
    		}

    		if ( isset( $_POST['wpzoom_portfolio_video_popup_url_mp4'] ) ) {
    			update_post_meta( $postID, 'wpzoom_portfolio_video_popup_url_mp4', esc_url_raw( $_POST['wpzoom_portfolio_video_popup_url_mp4'] ) );
    		}

    		if ( isset( $_POST['wpzoom_portfolio_video_popup_url_webm'] ) ) {
    			update_post_meta( $postID, 'wpzoom_portfolio_video_popup_url_webm', esc_url_raw( $_POST['wpzoom_portfolio_video_popup_url_webm'] ) );
    		}

    		if ( isset( $_POST['wpzoom_portfolio_video_external_url'] ) ) {
    			update_post_meta( $postID, 'wpzoom_portfolio_video_external_url', esc_url_raw( $_POST['wpzoom_portfolio_video_external_url'] ) );
    		}

    		if ( isset( $_POST['wpzoom_portfolio_video_popup_url'] ) ) {
    			update_post_meta( $postID, 'wpzoom_portfolio_video_popup_url', esc_url_raw( $_POST['wpzoom_portfolio_video_popup_url'] ) );
    		}

    		if ( isset( $_POST['wpzoom_portfolio_video_background_mp4'] ) ) {
    			update_post_meta( $postID, 'wpzoom_portfolio_video_background_mp4', esc_url_raw( $_POST['wpzoom_portfolio_video_background_mp4'] ) );
    		}

    		if ( isset( $_POST['wpzoom_portfolio_video_background_webm'] ) ) {
    			update_post_meta( $postID, 'wpzoom_portfolio_video_background_webm', esc_url_raw( $_POST['wpzoom_portfolio_video_background_webm'] ) );
    		}
        }
	}
}

function update_custom_meta( $postID, $value, $field ) {
	// To create new meta
	if ( ! get_post_meta( $postID, $field ) ) {
		add_post_meta( $postID, $field, $value );
	} else {
		// or to update existing meta
		update_post_meta( $postID, $field, $value );
	}
}

function load_admin_js() {

	global $post;

	wp_enqueue_script( 'slider-admin-js', get_template_directory_uri() . '/js/slider.admin.js', array( 'jquery', 'jquery-ui-tabs' ), WPZOOM::$themeVersion, true );
	wp_enqueue_script( 'wpzoom-home-slider-video-background', get_template_directory_uri() . '/js/admin-video-background.js', array( 'jquery' ), WPZOOM::$themeVersion );
	wp_localize_script( 'wpzoom-home-slider-video-background', 'inspiro_embed_option_type', array(
		'text-when-enabled'      => __( 'Use This as the Featured Image', 'wpzoom' ),
		'text-when-disabled'     => __( 'This is the Featured Image', 'wpzoom' ),
		'wpzoom_post_embed_info' => __( '<strong>NOTICE!&nbsp;&nbsp;Unable to fetch video thumbnail</strong><br/>' .
		                                'Either an invalid oembed code was provided, or there is no thumbnail available for the specified video&hellip;<br/>' .
		                                '<small id="wpz_autothumb_remind"><strong>REMINDER:</strong>' .
		                                'You can always manually upload a featured image via the WordPress Media Uploader.</small>', 'wpzoom' ),

		'nonce'          => wp_create_nonce( '_action_get_oembed_response' ),
		'nonce-button'   => wp_create_nonce( '_attach_remote_video_thumb' ),
		'nonce-featured' => wp_create_nonce( 'set_post_thumbnail-' . $post->ID )
	) );
}

function check_current_screen() {
	$current_screen = get_current_screen();

	if ( $current_screen->id === 'slider' || $current_screen->id === 'portfolio_item' ) {
		add_action( 'admin_enqueue_scripts', 'load_admin_js' );
	}
}

add_action( 'current_screen', 'check_current_screen' );

if ( ! function_exists( '_action_get_oembed_response' ) ) {
	function _action_get_oembed_response() {
		if ( wp_verify_nonce( $_POST['_nonce'], '_action_get_oembed_response' ) ) {
			$url      = ( filter_var( $_POST['url'], FILTER_VALIDATE_URL ) !== false ) ? $_POST['url'] : WPZOOM_Video_API::convert_embed_url( WPZOOM_Video_API::extract_url_from_embed( trim( stripslashes( $_POST['url'] ) ) ) );
			$width    = 460;
			$height   = 259;
			$instance = _wp_oembed_get_object();
			$provider = $instance->get_provider( $url, compact( 'width', 'height' ) );

			if ( ! $provider || false === $data = $instance->fetch( $provider, $url, compact( 'width', 'height' ) ) ) {
				$oembed_object = false;
			}

			$oembed_object = ! empty( $data->thumbnail_url ) ? $data->thumbnail_url : false;

			//if is youtube-url replace hqdefault with maxresdefault
			if ( $oembed_object && ( strpos( $provider, 'youtube' ) !== false ) ) {
				$stripped_url  = str_replace( basename( $oembed_object ), '', $oembed_object );
				$oembed_object = $stripped_url . 'maxresdefault.jpg';

				$response = wp_safe_remote_get( $oembed_object );

				if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
					$oembed_object = $data->thumbnail_url;
				}
			}

			$iframe               = wp_oembed_get( $url, compact( 'width', 'height' ) );
			$embed_url            = WPZOOM_Video_API::extract_url_from_embed( $iframe );
			$is_featured_response = WPZOOM_Video_Thumb::fetch_video_thumbnail( $embed_url, $_POST['post_id'] );
			wp_send_json_success( array(
				'response'          => $iframe,
				'thumbnail'         => $oembed_object,
				'featured_response' => $is_featured_response
			) );
		}
		wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
	}
}

add_action( 'wp_ajax_get_oembed_response', '_action_get_oembed_response' );

if ( ! function_exists( '_attach_remote_video_thumb' ) ):
	function _attach_remote_video_thumb() {

		if ( wp_verify_nonce( $_POST['_nonce'], '_attach_remote_video_thumb' ) ) {

			$url    = ( filter_var( $_POST['url'], FILTER_VALIDATE_URL ) !== false ) ? $_POST['url'] : WPZOOM_Video_API::convert_embed_url( WPZOOM_Video_API::extract_url_from_embed( trim( stripslashes( $_POST['url'] ) ) ) );
			$url    = WPZOOM_Video_API::extract_url_from_embed( wp_oembed_get( $url ) );
			$postid = $_POST['postid'];
			$id     = WPZOOM_Video_Thumb::attach_remote_video_thumb( $url, $postid, null );

			wp_send_json_success( array( 'response' => true, 'id' => $id ) );
		}

		wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
	}
endif;

add_action( 'wp_ajax_attach_remote_video_thumb', '_attach_remote_video_thumb' );



