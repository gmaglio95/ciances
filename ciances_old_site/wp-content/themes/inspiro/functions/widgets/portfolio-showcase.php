<?php

/*------------------------------------------*/
/* WPZOOM: Portfolio Showcase               */
/*------------------------------------------*/

class Wpzoom_Portfolio_Showcase extends WP_Widget {

	protected $defaults = array();

	function __construct() {
		/* Widget settings. */
		$widget_ops = array(
			'classname'   => 'portfolio-showcase',
			'description' => 'Portfolio posts shown as a gallery.'
		);

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'wpzoom-portfolio-showcase' );

		$this->defaults = array(
			'title'                   => '',
			'category'                => 0,
			'col_number'              => 4,
			'layout_type'             => 'full-width',
			'show_masonry'            => false,
			'show_popup'              => true,
			'show_popup_caption'      => false,
            'show_space'              => false,
			'show_categories'         => true,
			'enable_background_video' => true,
			'show_count'              => 6,
			'show_excerpt'            => true,
			'view_all_btn'            => true,
			'readmore_text'           => 'Read More',
			'view_all_enabled'        => true,
			'view_all_text'           => 'View All',
			'view_all_link'           => ''
		);

		/* Create the widget. */
		parent::__construct( 'wpzoom-portfolio-showcase', 'WPZOOM: Portfolio Showcase', $widget_ops, $control_ops );

		add_action( 'wp_ajax_nopriv_wpz_get_portfolio_items', array( $this, 'wpz_get_portfolio_items' ) );
		add_action( 'wp_ajax_wpz_get_portfolio_items', array( $this, 'wpz_get_portfolio_items' ) );
	}

	function widget( $args, $instance ) {

		$instance = wp_parse_args( (array) $instance, $this->defaults );
		extract( $args );

		/* User-selected settings. */
		$title              = apply_filters( 'widget_title', $instance['title'] );
		$category           = $instance['category'];
		$show_count         = $instance['show_count'];
		$col_number         = $instance['col_number'];
		$layout_type        = $instance['layout_type'];
		$show_masonry       = $instance['show_masonry'] == true;
		$show_popup         = $instance['show_popup'] == true;
		$show_popup_caption = $instance['show_popup_caption'] == true;
        $show_space         = $instance['show_space'] == true;
		$show_categories    = $instance['show_categories'] == true;
		$background_video   = $instance['enable_background_video'] == true;
		$show_excerpt       = $instance['show_excerpt'] == true;
		$view_all_btn       = $instance['view_all_btn'] == true;
		$view_all_enabled   = $instance['view_all_enabled'] == true;
		$readmore_text      = $instance['readmore_text'];
		$view_all_text      = $instance['view_all_text'];
		$view_all_link      = $instance['view_all_link'];

        if (! $view_all_link) {
            $all_link_url = get_page_link( option::get( 'portfolio_url' ) );
        } else {
            $all_link_url      = $view_all_link;
        }

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		$args = array(
			'post_type'      => 'portfolio_item',
			'posts_per_page' => $show_count,
            'orderby' =>'menu_order date'
		);

		if ( $category ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio',
					'terms'    => $category,
					'field'    => 'term_id',
				)
			);
		}

		$wp_query = new WP_Query( $args );
		?>

		<?php if ( $wp_query->have_posts() ) : ?>

			<?php if ( $show_masonry == true ) { ?>
				<div id="portfolio-masonry">
			<?php } ?>


            <?php if ( $show_categories == true ) { ?>

    			<nav class="portfolio-archive-taxonomies">
    				<ul class="portfolio-taxonomies portfolio-taxonomies-filter-by">
    					<li class="cat-item cat-item-all current-cat"><a
    							href="<?php echo get_page_link( option::get( 'portfolio_url' ) ); ?>"><?php _e( 'All', 'wpzoom' ); ?></a>
    					</li>

    					<?php wp_list_categories( array(
    						'title_li'     => '',
    						'hierarchical' => true,
    						'taxonomy'     => 'portfolio',
    						'depth'        => 1
    					) ); ?>
    				</ul>
    			</nav>

            <?php } ?>


			<?php if ( $layout_type == 'narrow' ) { ?>
			<div class="inner-wrap portfolio_template_clean">
		<?php } ?>


			<div data-nonce="<?php echo esc_attr( wp_create_nonce( 'wpz_get_portfolio_items' ) ) ?>"
			     data-instance="<?php echo esc_attr( wp_json_encode( array(
				     'layout_type'        => $layout_type,
				     'background_video'   => $background_video,
				     'show_masonry'       => $show_masonry,
				     'show_popup'         => $show_popup,
				     'show_popup_caption' => $show_popup_caption,
				     'show_excerpt'       => $show_excerpt,
				     'view_all_btn'       => $view_all_btn,
				     'readmore_text'      => $readmore_text,
				     'show_count'         => $show_count
			     ) ) ) ?>"
			     class="portfolio-grid <?php if ( $show_space == true ) { ?> portfolio_with_space<?php } ?> col_no_<?php echo $col_number; ?>">


			<?php

			$this->looper( $wp_query,
				array(
					'layout_type'        => $layout_type,
					'background_video'   => $background_video,
					'show_masonry'       => $show_masonry,
					'show_popup'         => $show_popup,
					'show_popup_caption' => $show_popup_caption,
					'show_excerpt'       => $show_excerpt,
					'view_all_btn'       => $view_all_btn,
					'readmore_text'      => $readmore_text
				)
			);

			?>

			</div>

			<?php if ( $layout_type == 'narrow' ) { ?>
				</div>
			<?php } ?>


			<?php if ( $show_masonry == true ) { ?>
				</div>
			<?php } ?>

        <?php else: ?>

            <div class="inner-wrap">

                <center>
                    <h3>No Portfolio Posts Found</h3>

                    <p class="description"><?php printf( __( 'Please add a few Portfolio Posts first <a href="%1$s">here</a>.', 'wpzoom' ), esc_url( admin_url( 'post-new.php?post_type=portfolio_item' ) ) ); ?></p>

                </center>

            </div>

		<?php endif; ?>

		<div class="portfolio-preloader">

            <div id="loading-39x">
                <div class="spinner">
                    <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div>
                </div>
            </div>
		</div>

		<?php if ( $view_all_enabled ) : ?>

			<?php if ( $layout_type == 'narrow' ) { ?>
				<div class="inner-wrap">
			<?php } ?>

			<div class="portfolio-view_all-link">
				<a class="btn" href="<?php echo esc_url( $all_link_url ); ?>"
				   title="<?php echo esc_attr( $view_all_text ); ?>">
					<?php echo esc_html( $view_all_text ); ?>
				</a>
			</div><!-- .portfolio-view_all-link -->

			<?php if ( $layout_type == 'narrow' ) { ?>
				</div>
			<?php } ?>

		<?php endif; ?>


		<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}


	function looper( $wp_query, $widget_settings ) {

		$show_masonry       = wp_validate_boolean( $widget_settings['show_masonry'] );
		$show_popup         = wp_validate_boolean( $widget_settings['show_popup'] );
		$layout_type        = $widget_settings['layout_type'];
		$show_popup_caption = wp_validate_boolean( $widget_settings['show_popup_caption'] );
		$show_excerpt       = wp_validate_boolean( $widget_settings['show_excerpt'] );
		$view_all_btn       = wp_validate_boolean( $widget_settings['view_all_btn'] );
		$readmore_text      = $widget_settings['readmore_text'];
		$background_video   = wp_validate_boolean( $widget_settings['background_video'] );

		while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

			<?php

			$post_thumbnail                    = get_the_post_thumbnail_url( get_the_ID() );
			$video_background_popup_url        = get_post_meta( get_the_ID(), 'wpzoom_portfolio_video_popup_url', true );
			$background_popup_url              = ! empty( $video_background_popup_url ) ? $video_background_popup_url : $post_thumbnail;
			$video_background_popup_url_mp4    = get_post_meta( get_the_ID(), 'wpzoom_portfolio_video_popup_url_mp4', true );
			$video_background_popup_url_webm   = get_post_meta( get_the_ID(), 'wpzoom_portfolio_video_popup_url_webm', true );
			$video_background_popup_video_type = get_post_meta( get_the_ID(), 'wpzoom_portfolio_popup_video_type', true );
			$popup_video_type                  = ! empty( $video_background_popup_video_type ) ? $video_background_popup_video_type : 'external_hosted';
			$video_background_mp4              = get_post_meta( get_the_ID(), 'wpzoom_portfolio_video_background_mp4', true );
			$video_background_webm             = get_post_meta( get_the_ID(), 'wpzoom_portfolio_video_background_webm', true );
			$is_video_popup                    = $video_background_popup_url_mp4 || $video_background_popup_url_webm;
			$is_video_background_source        = $video_background_mp4 || $video_background_webm;
			$is_video_background               = $background_video && $is_video_background_source;

			$final_background_src     = ! empty( $video_background_mp4 ) ? $video_background_mp4 : $video_background_webm;
			$popup_final_external_src = ! empty( $video_background_popup_url_mp4 ) ? $video_background_popup_url_mp4 : $video_background_popup_url_webm;

			$articleClass = ( ! has_post_thumbnail() && ! $is_video_background ) ? 'no-thumbnail ' : '';

			$portfolios = wp_get_post_terms( get_the_ID(), 'portfolio' );

			$size = ( $show_masonry == true ) ? "portfolio_item-masonry" : "portfolio_item-thumbnail";

			if ( $is_video_background ) {
				$filetype             = wp_check_filetype( $final_background_src );
				$video_atts           = array(
					'loop',
					'muted',
					//'preload="auto"',
					'poster="' . esc_attr( get_the_post_thumbnail_url( get_the_ID(), $size ) ) . '"'
				);
				$video_atts           = implode( ' ', $video_atts );
				$is_video_popup_class = $is_video_background ? ' is-portfolio-gallery-video-background' : '';
				$articleClass .= $is_video_popup_class;
			}


			if ( is_array( $portfolios ) ) {
				foreach ( $portfolios as $portfolio ) {
					$articleClass .= ' portfolio_' . $portfolio->term_id . '_item ';
				}
			}

			if ( wp_doing_ajax() ) {
				$articleClass .= ' ' . get_post_type( get_the_ID() );
			}

			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( $articleClass ); ?>>


				<?php if ( $layout_type == 'narrow' ) { ?>

					<div class="portfolio_item_top_wrap">

						<?php if ( $show_popup ) { ?>

							<div class="entry-thumbnail-popover">
								<div
									class="entry-thumbnail-popover-content lightbox_popup_insp popover-content--animated"
									data-show-caption="<?php echo $show_popup_caption ?>">
									<!-- start lightbox -->
									<?php if ( $popup_video_type === 'self_hosted' && $is_video_popup ): ?>
										<div id="zoom-popup-<?php echo $post->ID ?>" class="mfp-hide"
										     data-src="<?php echo $popup_final_external_src ?>">
											<div class="mfp-iframe-scaler">
												<?php
												echo wp_video_shortcode(
													array(
														'src'     => $popup_final_external_src,
														'preload' => 'none',
														//'autoplay' => 'on'
													) );
												?>
												<?php if ( $show_popup_caption ): ?>
													<div class="mfp-bottom-bar">
														<div class="mfp-title">
															<a href="<?php echo esc_url( get_permalink() ); ?>"
															   title="<?php echo esc_attr( get_the_title() ); ?>">
																<?php the_title(); ?>
															</a>
														</div>
													</div>
												<?php endif; ?>
											</div>

										</div>
										<a href="#zoom-popup-<?php echo $post->ID ?>"
										   class="mfp-inline portfolio-popup-video"></a>
									<?php elseif ( ! empty( $video_background_popup_url ) ): ?><a
										class="mfp-iframe portfolio-popup-video"
										href="<?php echo $video_background_popup_url ?>"></a>
									<?php else: ?>
										<?php if(has_post_thumbnail() && !option::is_on('lightbox_video_only') ): ?>
											<a class="mfp-image portfolio-popup-video popup_image_insp"
											   href="<?php echo $post_thumbnail ?>"></a>
										<?php endif; ?>
									<?php endif; ?>

								</div>
							</div>

							<?php if ( $is_video_background ): ?>
								<video class="portfolio-gallery-video-background" <?php echo $video_atts ?>
								       style=" width:100%; height:auto;vertical-align: middle; display:block;">
									<source src="<?php echo $final_background_src ?>"
									        type="<?php echo $filetype['type'] ?>">
								</video>

								<?php the_post_thumbnail( 'portfolio_item-thumbnail' ); ?>

							<?php elseif ( has_post_thumbnail() ): ?>

								<?php the_post_thumbnail( 'portfolio_item-thumbnail' ); ?>

							<?php else: ?>

								<img width="600" height="400"
								     src="<?php echo get_template_directory_uri() . '/images/portfolio_item-placeholder.gif'; ?>">

							<?php endif; ?>

						<?php } else { ?>

							<a href="<?php echo esc_url( get_permalink() ); ?>"
							   title="<?php echo esc_attr( get_the_title() ); ?>">

								<?php if ( $is_video_background ): ?>
									<video class="portfolio-gallery-video-background" <?php echo $video_atts ?>
									       style=" width:100%; height:auto;vertical-align: middle; display:block;">
										<source src="<?php echo $final_background_src ?>"
										        type="<?php echo $filetype['type'] ?>">
									</video>

									<?php the_post_thumbnail( 'portfolio_item-thumbnail' ); ?>

								<?php elseif ( has_post_thumbnail() ): ?>

									<?php the_post_thumbnail( 'portfolio_item-thumbnail' ); ?>

								<?php else: ?>

									<img width="600" height="400"
									     src="<?php echo get_template_directory_uri() . '/images/portfolio_item-placeholder.gif'; ?>">

								<?php endif; ?>

							</a>

						<?php } ?>

					</div>

					<div class="clean_skin_wrap_post">

						<?php if ( is_array( $tax_menu_items = get_the_terms( get_the_ID(), 'portfolio' ) ) ) : ?>
							<?php foreach ( $tax_menu_items as $tax_menu_item ) : ?>
								<a class="portfolio_sub_category"
								   href="<?php echo get_term_link( $tax_menu_item, $tax_menu_item->taxonomy ); ?>"><?php echo $tax_menu_item->name; ?></a>
							<?php endforeach; ?>
						<?php endif; ?>


						<?php the_title( sprintf( '<h3 class="portfolio_item-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>


					</div>
				<?php } else {
					if ( $show_popup ) {
						?>

						<div class="entry-thumbnail-popover">
							<div class="entry-thumbnail-popover-content lightbox_popup_insp popover-content--animated"
							     data-show-caption="<?php echo $show_popup_caption ?>">
								<!-- start lightbox --><?php if ( $popup_video_type === 'self_hosted' && $is_video_popup ): ?>
									<div id="zoom-popup-<?php echo the_ID(); ?>" class="animated slow mfp-hide">

										<div class="mfp-iframe-scaler">

											<?php
											echo wp_video_shortcode(
												array(
													'src'     => $popup_final_external_src,
													'preload' => 'none',
													//'autoplay' => 'on'
												) );
											?>
											<?php if ( $show_popup_caption ): ?>
												<div class="mfp-bottom-bar">
													<div class="mfp-title">
														<a href="<?php echo esc_url( get_permalink() ); ?>"
														   title="<?php echo esc_attr( get_the_title() ); ?>">
															<?php the_title(); ?>
														</a>
													</div>
												</div>
											<?php endif; ?>
										</div>
									</div>
									<a href="#zoom-popup-<?php echo the_ID(); ?>"
									   class="mfp-inline portfolio-popup-video"></a>
								<?php elseif ( ! empty( $video_background_popup_url ) ): ?><a
									class="mfp-iframe portfolio-popup-video"
									href="<?php echo $video_background_popup_url ?>"></a>
								<?php else: ?>
									<?php if(has_post_thumbnail() && !option::is_on('lightbox_video_only') ): ?>
										<a class="mfp-image portfolio-popup-video popup_image_insp"
										   href="<?php echo $post_thumbnail ?>"></a>
									<?php endif; ?>
								<?php endif; ?>

								<h3 class="portfolio_item-title">
									<a href="<?php echo esc_url( get_permalink() ); ?>"
									   title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a>
								</h3>

							</div>
						</div>

						<?php if ( $is_video_background ): ?>
							<video class="portfolio-gallery-video-background" <?php echo $video_atts ?>
							       style=" width:100%; height:auto;vertical-align: middle; display:block;">
								<source src="<?php echo $final_background_src ?>"
								        type="<?php echo $filetype['type'] ?>">
							</video>

							<?php the_post_thumbnail( $size ); ?>

						<?php elseif ( has_post_thumbnail() ): ?>

							<?php the_post_thumbnail( $size ); ?>

						<?php else: ?>

							<img width="600" height="400"
							     src="<?php echo get_template_directory_uri() . '/images/portfolio_item-placeholder.gif'; ?>">

						<?php endif; ?>


					<?php } else { ?>

						<a href="<?php echo esc_url( get_permalink() ); ?>"
						   title="<?php echo esc_attr( get_the_title() ); ?>">

							<div class="entry-thumbnail-popover">
								<div class="entry-thumbnail-popover-content popover-content--animated">
									<?php the_title( '<h3 class="portfolio_item-title">', '</h3>' ); ?>

									<?php if ( $show_excerpt == true ) : ?>

										<?php the_excerpt(); ?>

									<?php endif; ?>

									<?php if ( $view_all_btn == true ) : ?>

										<span class="btn"><?php echo esc_html( $readmore_text ); ?></span>

									<?php endif; ?>
								</div>
							</div>

							<?php if ( $is_video_background ): ?>
								<video class="portfolio-gallery-video-background" <?php echo $video_atts ?>
								       style=" width:100%; height:auto;vertical-align: middle; display:block;">
									<source src="<?php echo $final_background_src ?>"
									        type="<?php echo $filetype['type'] ?>">
								</video>

								<?php the_post_thumbnail( $size ); ?>

							<?php elseif ( has_post_thumbnail() ): ?>

								<?php the_post_thumbnail( $size ); ?>

							<?php else: ?>

								<img width="600" height="400"
								     src="<?php echo get_template_directory_uri() . '/images/portfolio_item-placeholder.gif'; ?>">

							<?php endif; ?>

						</a>

					<?php } ?>


				<?php } ?>

			</article><!-- #post-## -->

		<?php endwhile; ?>
	<?php }

	function wpz_get_portfolio_items() {

		ob_start();

		if ( ! wp_verify_nonce( $_POST['nonce'], 'wpz_get_portfolio_items' ) ) {
			wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
		}

		if ( ! empty( $_POST['category_id'] ) && ! empty( $_POST['widget_settings'] ) ) {

			$args = array(
				'post_type'      => 'portfolio_item',
                'orderby' =>'menu_order date',
				'posts_per_page' => empty( $_POST['widget_settings']['show_count'] ) ? 9 : $_POST['widget_settings']['show_count'],
				'tax_query'      => array(
					array(
						'taxonomy' => 'portfolio',
						'terms'    => $_POST['category_id'],
						'field'    => 'term_id',
					)
				)
			);

			$widget_settings = $_POST['widget_settings'];

			$wp_query = new WP_Query( $args );


			$this->looper( $wp_query, $widget_settings );

			$content = ob_get_clean();
		}

		wp_send_json_success( array( 'content' => $content ) );
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title']                   = strip_tags( $new_instance['title'] );
		$instance['category']                = $new_instance['category'];
		$instance['show_count']              = $new_instance['show_count'];
		$instance['col_number']              = $new_instance['col_number'];
		$instance['layout_type']             = $new_instance['layout_type'];
		$instance['show_masonry']            = isset( $new_instance['show_masonry'] );
		$instance['show_popup']              = isset( $new_instance['show_popup'] );
		$instance['show_popup_caption']      = isset( $new_instance['show_popup_caption'] );
        $instance['show_space']              = isset( $new_instance['show_space'] );
		$instance['show_categories']         = isset( $new_instance['show_categories'] );
		$instance['enable_background_video'] = isset( $new_instance['enable_background_video'] );
		$instance['show_excerpt']            = isset( $new_instance['show_excerpt'] );
		$instance['view_all_btn']            = isset( $new_instance['view_all_btn'] );
		$instance['view_all_enabled']        = isset( $new_instance['view_all_enabled'] );
		$instance['readmore_text']           = $new_instance['readmore_text'];
		$instance['view_all_text']           = $new_instance['view_all_text'];
		$instance['view_all_link']           = $new_instance['view_all_link'];

		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, $this->defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label><br/>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"
			       type="text" class="widefat"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>">Category:</label>
			<select id="<?php echo $this->get_field_id( 'category' ); ?>"
			        name="<?php echo $this->get_field_name( 'category' ); ?>">
				<option value="0" <?php if ( ! $instance['category'] ) {
					echo 'selected="selected"';
				} ?>>All
				</option>
				<?php
				$categories = get_categories( array( 'taxonomy' => 'portfolio' ) );

				foreach ( $categories as $cat ) {
					echo '<option value="' . $cat->cat_ID . '"';

					if ( $cat->cat_ID == $instance['category'] ) {
						echo ' selected="selected"';
					}

					echo '>' . $cat->cat_name . ' (' . $cat->category_count . ')';

					echo '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label
				for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e( 'Number of posts to show', 'wpzoom' ); ?>
				:</label>
			<input id="<?php echo $this->get_field_id( 'show_count' ); ?>"
			       name="<?php echo $this->get_field_name( 'show_count' ); ?>"
			       value="<?php echo $instance['show_count']; ?>" type="text" size="2"/>
		</p>


		<hr/>

		<div>
			<label
				for="<?php echo $this->get_field_id( 'layout_type' ); ?>"><strong><?php _e( 'Layout', 'wpzoom' ); ?></strong>:
			</label>
			<select id="<?php echo $this->get_field_id( 'layout_type' ); ?>"
			        name="<?php echo $this->get_field_name( 'layout_type' ); ?>">
				<option value="full-width" <?php if ( $instance['layout_type'] == 'full-width' ) {
					echo 'selected="selected"';
				} ?>><?php _e( 'Full-width', 'wpzoom' ); ?></option>
				<option value="narrow" <?php if ( $instance['layout_type'] == 'narrow' ) {
					echo 'selected="selected"';
				} ?>><?php _e( 'Narrow', 'wpzoom' ); ?></option>

			</select>
		</div>


		<hr/>


		<div>
			<label
				for="<?php echo $this->get_field_id( 'col_number' ); ?>"><?php _e( 'Number of Columns', 'wpzoom' ); ?>
				: </label>
			<select id="<?php echo $this->get_field_id( 'col_number' ); ?>"
			        name="<?php echo $this->get_field_name( 'col_number' ); ?>">
				<option value="2" <?php if ( $instance['col_number'] == '2' ) {
					echo 'selected="selected"';
				} ?>><?php _e( '2', 'wpzoom' ); ?></option>
				<option value="3" <?php if ( $instance['col_number'] == '3' ) {
					echo 'selected="selected"';
				} ?>><?php _e( '3', 'wpzoom' ); ?></option>
				<option value="4" <?php if ( $instance['col_number'] == '4' ) {
					echo 'selected="selected"';
				} ?>><?php _e( '4', 'wpzoom' ); ?></option>
				<option value="5" <?php if ( $instance['col_number'] == '5' ) {
					echo 'selected="selected"';
				} ?>><?php _e( '5', 'wpzoom' ); ?></option>

			</select>
			<span
				class="howto"><?php _e( 'The number of columns may vary depending on screen size', 'wpzoom' ); ?></span>
		</div>


		<p>
			<label>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_space'] ); ?>
				       id="<?php echo $this->get_field_id( 'show_space' ); ?>"
				       name="<?php echo $this->get_field_name( 'show_space' ); ?>"/>
				<?php _e( 'Add Margins between Posts (whitespace)', 'wpzoom' ); ?>
			</label>
		</p>

        <p>
            <label>
                <input class="checkbox" type="checkbox" <?php checked( $instance['show_categories'] ); ?>
                       id="<?php echo $this->get_field_id( 'show_categories' ); ?>"
                       name="<?php echo $this->get_field_name( 'show_categories' ); ?>"/>
                <?php _e( '<strong>Display Categories at the Top</strong>', 'wpzoom' ); ?>
            </label>
        </p>


		<p>
			<label>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_popup'] ); ?>
				       id="<?php echo $this->get_field_id( 'show_popup' ); ?>"
				       name="<?php echo $this->get_field_name( 'show_popup' ); ?>"/>
				<?php _e( 'Enable Lightbox', 'wpzoom' ); ?>
			</label>
		</p>

		<p>
			<label>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_popup_caption'] ); ?>
				       id="<?php echo $this->get_field_id( 'show_popup_caption' ); ?>"
				       name="<?php echo $this->get_field_name( 'show_popup_caption' ); ?>"/>
				<?php _e( 'Show Lightbox Caption', 'wpzoom' ); ?>
			</label>
		</p>

		<p>
			<label>
				<input class="checkbox" type="checkbox" <?php checked( $instance['enable_background_video'] ); ?>
				       id="<?php echo $this->get_field_id( 'enable_background_video' ); ?>"
				       name="<?php echo $this->get_field_name( 'enable_background_video' ); ?>"/>
				<?php _e( 'Enable Background Video on hover', 'wpzoom' ); ?>
			</label>
		</p>

		<p>
			<label>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_masonry'] ); ?>
				       id="<?php echo $this->get_field_id( 'show_masonry' ); ?>"
				       name="<?php echo $this->get_field_name( 'show_masonry' ); ?>"/>
				<?php _e( 'Display Posts in Masonry Layout <small><em>(doesn\'t work in Narrow Layout)</em></small>', 'wpzoom' ); ?>
			</label>
		</p>

		<p>
			<label>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_excerpt'] ); ?>
				       id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"
				       name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>"/>
				<?php _e( 'Display Excerpts <small><em>(doesn\'t work with Lightbox feature and Narrow Layout)</em></small>', 'wpzoom' ); ?>
			</label>
		</p>

        <hr />

        <h4><?php _e('"Read More" Button on Each Post', 'wpzoom'); ?>:</h4>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['view_all_btn'] ); ?>
			       id="<?php echo $this->get_field_id( 'view_all_btn' ); ?>"
			       name="<?php echo $this->get_field_name( 'view_all_btn' ); ?>"/>
			<label
				for="<?php echo $this->get_field_id( 'view_all_btn' ); ?>"><?php _e( 'Display Read More button <small><em>(doesn\'t work with Lightbox feature and Narrow Layout)</em></small>', 'wpzoom' ); ?></label>
		</p>

		<p>
			<label
				for="<?php echo $this->get_field_id( 'readmore_text' ); ?>"><?php _e( 'Text for Read More button', 'wpzoom' ); ?>:</label><br/>
			<input id="<?php echo $this->get_field_id( 'readmore_text' ); ?>"
			       name="<?php echo $this->get_field_name( 'readmore_text' ); ?>"
			       value="<?php echo $instance['readmore_text']; ?>" type="text" class="widefat"/>
		</p>


        <hr />

           <h4><?php _e('"View All" Button at the Bottom', 'wpzoom'); ?>:</h4>

    		<p>
    			<input class="checkbox" type="checkbox" <?php checked( $instance['view_all_enabled'] ); ?>
    			       id="<?php echo $this->get_field_id( 'view_all_enabled' ); ?>"
    			       name="<?php echo $this->get_field_name( 'view_all_enabled' ); ?>"/>
    			<label
    				for="<?php echo $this->get_field_id( 'view_all_enabled' ); ?>"><?php _e( 'Display View All button', 'wpzoom' ); ?></label>
    		</p>

    		<p>
    			<label
    				for="<?php echo $this->get_field_id( 'view_all_text' ); ?>"><?php _e( 'Text for View All button', 'wpzoom' ); ?>:</label><br/>
    			<input id="<?php echo $this->get_field_id( 'view_all_text' ); ?>"
    			       name="<?php echo $this->get_field_name( 'view_all_text' ); ?>"
    			       value="<?php echo $instance['view_all_text']; ?>" type="text" class="widefat"/>
    		</p>

    		<p>
    			<label
    				for="<?php echo $this->get_field_id( 'view_all_link' ); ?>"><?php _e( 'Link for View All button', 'wpzoom' ); ?>:</label><br/>
    			<input id="<?php echo $this->get_field_id( 'view_all_link' ); ?>"
    			       name="<?php echo $this->get_field_name( 'view_all_link' ); ?>"
    			       value="<?php echo $instance['view_all_link']; ?>" type="text" class="widefat"/>
    		</p>

		<?php
	}
}

function wpzoom_register_psc_widget() {
	register_widget( 'Wpzoom_Portfolio_Showcase' );
}

add_action( 'widgets_init', 'wpzoom_register_psc_widget' );