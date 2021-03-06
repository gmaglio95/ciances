<?php
/**
 * Plugin Name: Ninja Beaver Lite Addons for Beaver Builder
 * Plugin URI: https://www.ninjabeaveraddon.com
 * Description: A set of custom, improvement, impressive lite modules for Beaver Builder.
 * Version: 2.3.1
 * Author: Ninja Team 
 * Author URI: https://www.ninjabeaveraddon.com
 * Copyright: (c) 2018 Ninja Beaver Lite Addons
 * Text Domain: bb-njba
 */
if ( !function_exists("njba_lite_version_activation"))
{
	function njba_lite_version_activation() {
			
			add_option('njba_lite_version_versions', '2.3.1' );
			add_option('njba_extensions_lists', '' );
	        update_option('njba_lite_version_versions', '2.3.1' );
	}
}
if ( !function_exists("njba_lite_version_deactivation"))
{
	function njba_lite_version_deactivation() {
			update_option('njba_lite_version_versions', '' );
	}
}
			
register_activation_hook( __FILE__,  'njba_lite_version_activation' );
register_deactivation_hook( __FILE__, 'njba_lite_version_deactivation' );
$njba_cat = esc_html__( 'NJBA Module', 'bb-njba' );
$versions = '2.3.1';
	
	if( !defined( 'NJBA_MODULE_DIR' ) ) {
		define( 'NJBA_MODULE_DIR', plugin_dir_path( __FILE__ ) );
	}
	if( !defined( 'NJBA_MODULE_URL' ) ) {
		define( 'NJBA_MODULE_URL', plugins_url( '/', __FILE__ ) );
	}
	if( !defined( 'NJBA_MODULE_CAT' ) ) {
		define( 'NJBA_MODULE_CAT', $njba_cat );
	}
	if( !defined( 'NJBA_MODULE_VERSION' ) ) {
		define( 'NJBA_MODULE_VERSION', $versions);
	}
	if( !defined( 'NJBA__MODULE_PLUGIN_FILE' ) ) {
		define('NJBA__MODULE_PLUGIN_FILE', __FILE__ ); 
	}
	if( !defined( 'NINJA_BEAVER_LITE' ) ) {
		define( 'NINJA_BEAVER_LITE', 'Ninja Beaver Lite Addons' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file
	}
if( !class_exists( "BB_NJBA_Addon" ) && class_exists( 'FLBuilder' )) {
	
	function njba_get_modules_group()
	{
		$njba    = array();
		$njba_builder_label = '';
		if( is_array($njba) ) {
			$njba_builder_label = ( array_key_exists( 'njba-builder-label' , $njba ) ) ? $njba['njba-builder-label' ] : esc_html__( 'NJBA Modules', 'bb-njba' );
		}
		if( $njba_builder_label == ''){
			$njba_builder_label = esc_html__( 'NJBA Modules', 'bb-njba' );
			return $njba_builder_label;
		}
		else{
			return $njba_builder_label;
		}
	}
	function njba_get_modules_cat($category = '')
	{
		$njba    = array();
		$njba_builder_cat = '';
		if( is_array($njba) ) {
			$njba_builder_cat = ( array_key_exists( 'njba-builder-category' , $njba ) ) ? $njba['njba-builder-category' ] : esc_html__( 'NJBA', 'bb-njba' );
		}
		if( $njba_builder_cat == '')
		{
		 	$njba_builder_cat = esc_html__( 'NJBA', 'bb-njba' );
		}
		$default = 'default';
		$new = 'new';
		$cats = array(
			'social'	=> sprintf(__('Social Modules - %s', 'bb-njba'), $njba_builder_cat),
			'carousel'		=> sprintf(__('Carousel Modules - %s', 'bb-njba'), $njba_builder_cat),
			'content'		=> sprintf(__('Content Modules - %s', 'bb-njba'), $njba_builder_cat),
			'creative'		=> sprintf(__('Creative Modules - %s', 'bb-njba'), $njba_builder_cat),
			'form_style'	=> sprintf(__('Form Style Modules - %s', 'bb-njba'), $njba_builder_cat),
			'separator'	=> sprintf(__('Separator Modules - %s', 'bb-njba'), $njba_builder_cat),
			// 'default'	=> sprintf(__('NJBA Modules - %s', 'bb-njba'), $njba_builder_cat),
			// 'new'	=> sprintf(__('%s - %s', 'bb-njba'), $category, $njba_builder_cat),
		);
		if ( empty( $category ) ) {
			return $cats/*[$default]*/;
		}

		if ( isset( $cats[$category] ) ) {
			return $cats[$category];
		} else {
			return $category;
		}

		
	}

	class BB_NJBA_Addon {
		public function __construct()
	    {
	       	add_action( 'init', array( $this, 'njba_load_modules')  );
			add_action( 'wp_enqueue_scripts', array( $this, 'njab_load_scripts') );
			add_filter('body_class',array( $this, 'njba_body_classes'));
		}
		
		/**
		 * Ninja modules
		 */
		function njba_load_modules() {
			if ( class_exists( 'FLBuilder' ) ) {
				$njba_options = get_option('njba_options');
				add_option( 'njba_usage_enabled', '1' );
				if($njba_options == ''){
						$njba_admin_option_data = array('google_static_map_api_key'   => '', 
									                     'facebook_app_id' => '',
									                );
						$njba_admin_options = add_option( 'njba_options', $njba_admin_option_data );
						
					}
				// if( !array_key_exists('facebook_app_id', $njba_options)){
				// 	$njba_options['facebook_app_id'] = '';
				// }
				/* admin settings*/
				require_once 'classes/class-admin-settings.php';
				/*Usage*/
				require_once 'classes/class-njba-usage.php';
				/*class fields*/
			    require_once 'classes/class-module-fields.php';
			    require_once 'modules/njba-accordion/njba-accordion.php';
		    	require_once 'modules/njba-alert-box/njba-alert-box.php';
			    require_once 'modules/njba-advance-cta/njba-advance-cta.php';
		        require_once 'modules/njba-contact-form/njba-contact-form.php';
			    require_once 'modules/njba-button/njba-button.php';
			    require_once 'modules/njba-flip-box/njba-flip-box.php';
			    require_once 'modules/njba-gallery/njba-gallery.php';
			    require_once 'modules/njba-heading/njba-heading.php';
			    require_once 'modules/njba-icon-img/njba-icon-img.php';
			    require_once 'modules/njba-highlight-box/njba-highlight-box.php';
			    require_once 'modules/njba-image-hover/njba-image-hover.php';
			    require_once 'modules/njba-image-hover-two/njba-image-hover-two.php';
			    require_once 'modules/njba-image-panels/njba-image-panels.php';
			    require_once 'modules/njba-img-separator/njba-img-separator.php';
			    require_once 'modules/njba-infolist/njba-infolist.php';
			  	require_once 'modules/njba-infobox/njba-infobox.php';
			    require_once 'modules/njba-infobox-two/njba-infobox-two.php';
		     	require_once 'modules/njba-logo-grid-carousel/njba-logo-grid-carousel.php';
			    require_once 'modules/njba-opening-hours/njba-opening-hours.php';
			    require_once 'modules/njba-post-grid/njba-post-grid.php';
				require_once 'modules/njba-post-list/njba-post-list.php';
			    require_once 'modules/njba-price-box/njba-price-box.php';
		  	    require_once 'modules/njba-quote-box/njba-quote-box.php';	    	    
			    require_once 'modules/njba-separator/njba-separator.php';
			   	require_once 'modules/njba-slider/njba-slider.php';
			    require_once 'modules/njba-social-share/njba-social-share.php';
			    require_once 'modules/njba-spacer/njba-spacer.php';
			    require_once 'modules/njba-static-map/njba-static-map.php';
			    require_once 'modules/njba-subscribe-form/njba-subscribe-form.php';
			    require_once 'modules/njba-tabs/njba-tabs.php';
			    require_once 'modules/njba-teams/njba-teams.php';
			    require_once 'modules/njba-testimonials/njba-testimonials.php';
			    require_once 'modules/njba-facebook-button/njba-facebook-button.php';
		        require_once 'modules/njba-facebook-comments/njba-facebook-comments.php';
			    require_once 'modules/njba-facebook-embed/njba-facebook-embed.php';
			    require_once 'modules/njba-facebook-page/njba-facebook-page.php';
			    require_once 'modules/njba-twitter-buttons/njba-twitter-buttons.php';
			    require_once 'modules/njba-twitter-grid/njba-twitter-grid.php';
			    require_once 'modules/njba-twitter-timeline/njba-twitter-timeline.php';
			    require_once 'modules/njba-twitter-tweet/njba-twitter-tweet.php';
			}
		}
		function load_plugin_textdomain(){
			if ( function_exists( 'get_user_locale' ) ) {
				$locale = apply_filters( 'plugin_locale', get_user_locale(), 'bb-njba' );
			} else {
				$locale = apply_filters( 'plugin_locale', get_locale(), 'bb-njba' );
			}
			//Setup paths to current locale file
			$mofile_global = trailingslashit( WP_LANG_DIR ) . 'plugins/bb-plugin/' . $locale . '.mo';
			$mofile_local  = trailingslashit( NJBA_MODULE_DIR ) . 'languages/' . $locale . '.mo';
			if ( file_exists( $mofile_global ) ) {
				//Look in global /wp-content/languages/plugins/bb-plugin/ folder
				return load_textdomain( 'bb-njba', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				//Look in local /wp-content/plugins/bb-plugin/languages/ folder
				return load_textdomain( 'bb-njba', $mofile_local );
			}
			//Nothing found
			return false;
		}
		/**
		 * Ninja modules Scripts
		 */
		function njab_load_scripts()
		{
				if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {
					wp_enqueue_style( 'njba-fields-style', NJBA_MODULE_URL . 'assets/css/njba-fields.css', array(), rand() );
					wp_enqueue_script( 'njba-fields-script', NJBA_MODULE_URL . 'assets/js/fields.js', array( 'jquery' ), rand(), true );
					
				}
				wp_register_script( 'njba-twitter-widgets', NJBA_MODULE_URL . 'assets/js/twitter-widgets.js', array('jquery'), rand(), true );
		}
		/**
		 * Ninja modules body class
		 */
		function njba_body_classes($classes) {
		   	 $classes[] = 'bb-njba';
			 return $classes;
		}
	}
	new BB_NJBA_Addon();
	add_action( 'admin_notices', 'woo_njba_admin_notice' );
	add_action( 'network_admin_notices', 'woo_njba_admin_notice' );
	function woo_njba_admin_notice() {
		global $pagenow;
		$woo_njba_admin_notice = trim( get_option( 'woo-njba-notice-dismissed') );
		if(empty($woo_njba_admin_notice)){
			$url = admin_url( 'index.php' );
			$learn_more = "https://www.woobeaveraddons.com/";
			$documentation = "https://www.woobeaveraddons.com/category/docs/";
			$image = "https://www.woobeaveraddons.com/wp-content/uploads/2017/12/woo-logo.png";
			echo '<div class="notice notice-info is-dismissible woo-info"><div class="info-image"><p>';
			echo sprintf( __( "<img src='$image'>", 'bb-njba' ), $url );
		    echo '</p></div><div class="info-descriptions"><div class="info-descriptions-title"><h3><strong>Introducing Woo Beaver</strong></h3></div><p>';
			echo sprintf( __( "You can create page templates for single product and category pages. you can also use single product module, product list module, grid modules and add to cart modules for woocommerce. You can create single product template for specific category products or also specific products too. You can easily set rules for it.</br></br><a href='$learn_more' target='_blank'>Learn More</a>   <a href='$documentation' target='_blank'>Documentation</a>", 'bb-njba' ), $url );
		    echo '</p></div></div>';
		}
  	}

  	add_action('admin_footer','woo_njba_admin_notice_script');
  	function woo_njba_admin_notice_script(){
  		$woo_njba_admin_notice = trim(get_option( 'woo-njba-notice-dismissed'));
  		if(empty($$woo_njba_admin_notice)){
  		?>
  		<script type="text/javascript">
  		jQuery(document).on( 'click', '.woo-info .notice-dismiss', function() {
		    jQuery.ajax({
		        url: ajaxurl,
		        data: {
		            action: 'dismiss_woo_njba'
		        }
		    })

		})
		</script>
  		<?php
  		}
  	}
  	add_action( 'wp_ajax_dismiss_woo_njba', 'set_dismiss_woo_njba_option' );
	function set_dismiss_woo_njba_option() {
		update_option( 'woo-njba-notice-dismissed','yes');
		echo 'success';
		exit();
	}
}
else
{
	// Display admin notice for activating beaver builder
	add_action( 'admin_notices', 'njba_admin_notices' );
	add_action( 'network_admin_notices', 'njba_admin_notices' );
	function njba_admin_notices() {
		$url = admin_url( 'plugins.php' );
		echo '<div class="notice notice-error"><p>';
		echo sprintf( __( "You currently have two versions of <strong> Ninja Beaver Lite Addon for Beaver Builder</strong> active on this site. Please <a href='%s'>deactivate one</a> before continuing.", 'bb-njba' ), $url );
	    echo '</p></div>';
  	}
}