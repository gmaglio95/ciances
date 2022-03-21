<?php
/**
 * Sends opt-in usage data
 * @since 2.2
 */
class NJBAUsage {
	//protected $url = 'https://www.ninjabeaveraddon.com/wp-json/njba/v1/tracking/usage/';
	protected $url = 'https://www.ninjabeaveraddon.com/get_data.php';
	protected $seconds = 604800;
	public function __construct() {

		$hook = is_network_admin() ? 'network_admin_notices' : 'admin_notices';
		add_action( 'admin_init', array( $this, 'enable_disable' ) );
		add_filter( 'cron_schedules', array( $this, 'add_weekly_schedule' ) );
		add_action( 'wp_loaded', array( $this, 'set_schedule' ) );
		add_action( $hook, array( $this, 'render_notification' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'njba_usage_event', array( $this, 'send_stats' ) );
		add_action( 'wp_loaded', array( $this, 'check_time' ) );
		add_action( 'wp_ajax_njba_usage_toggle', array( $this, 'callback' ) );
	}

	public function check_time() {
		
		$r_time = get_option('njba_time_stamp_usage');
		$c_t = time();
		//$w_t = time('+ 1 week');
		$w_t = time() + (7 * 24 * 60 * 60);
		if($r_time == ''){
			update_option('njba_time_stamp_usage',$w_t);
			$this->send_stats();
		}
		else if ($r_time >= $c_t){
			update_option('njba_time_stamp_usage',$w_t);
			$this->send_stats();
		}
	}

	public function add_weekly_schedule( $schedules ) {
		// add a 'weekly' schedule to the existing set
		$schedules['weekly'] = array(
			'interval' => 604800,
			'display' => __('Once Weekly')
		);
		return $schedules;
	}
	public function callback() {
		
		$enable = intval( $_POST['enable'] );
		//$enable = 1;
		if ( wp_verify_nonce( $_POST['_wpnonce'], 'njba-usage' ) ) {
			update_site_option( 'njba_usage_enabled', $enable );
			$this->send_stats();
		}
		wp_die();
	}
	// public function browser_stats( $browser_data ) {
	// 	update_user_meta( get_current_user_id(), 'njba_builder_browser_stats', $browser_data );
	// 	exit();
	// }
	public function scripts() {
		wp_enqueue_style( 'njba-admin-usage', NJBA_MODULE_URL . 'assets/css/njba-admin-usage.css', array(), NJBA_MODULE_VERSION );
		wp_enqueue_script( 'njba-admin-usage', NJBA_MODULE_URL . 'assets/js/njba-admin-usage.js', array( 'jquery' ), NJBA_MODULE_VERSION );
	}
	/**
	 * Add scheduled event
	 * @since 2.2
	 */
	public function set_schedule() {
		if ( '1' == get_site_option( 'njba_usage_enabled', false ) ) {
			if ( ! wp_next_scheduled( 'njba_usage_event' ) ) {
				//wp_schedule_event( time() + self::$seconds, 'weekly', 'njba_usage_event' );
				wp_schedule_event( time(), 'weekly', 'njba_usage_event' );
			}
		}
		
	}
	/**
	 * Send stats callback
	 * @since 2.2
	 */
	public function send_stats() {

		update_option('test_options_1','5');
		//die('test set s');
		if ( ! get_site_option( 'njba_usage_enabled', false ) ) {
			return false;
		}
		//echo json_encode( self::get_data() );
		$data = wp_remote_post( $this->url, array(
		    'body'        => json_encode( $this->get_data(), JSON_UNESCAPED_SLASHES ),
		    'timeout' => 30,
		));
		/*echo '<pre>'; print_r( self::get_data() ); echo '</pre>';
		echo json_encode(self::get_data());
		echo '<pre>';print_r( $data ); echo '</pre>';*/
	}
	/**
	 * Enable/disable
	 * @since 2.2
	 */
	public function enable_disable() {
		if ( isset( $_GET['njba_usage'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'stats_enable' ) ) {
			//die('e d');
			update_site_option( 'njba_usage_enabled', $_GET['njba_usage'] );
		}
	}
	/**
	 * Render admin admin notice
	 * @since 2.2
	 */
	public function render_notification() {
//die('test set s');
		if ( ! self::notification_enabled() ) {
			return false;
		}
		wp_enqueue_script( 'jquery' );
		$btn = sprintf( '<div class="buttons"><span class="button button-primary enable-stats">%s</span>&nbsp;<span class="button disable-stats">%s</span>%s</div>',
			__( "Sure, I'll help", 'bb-njba' ),
			__( 'No, Thank You', 'bb-njba' ),
			wp_nonce_field( 'njba-usage', '_wpnonce', false )
		);
		$message = sprintf(
			__( 'Would you like to help us improve %s by sending anonymous usage data?', 'bb-njba' ),
			FLBuilderModel::get_branding()
		);
		echo '<div class="notice notice-info">';
		echo '<div class="njba-usage">';
		echo '<p>';
		printf( '%s %s', $message, $btn );
		echo '</p>';
		printf( '</div>%s</div>', $this->data_demo() );
	}
	/**
	 * Whether to show the stats settings in bb admin.
	 */
	public function show_settings() {
		// super admin and network settings
		if ( is_multisite() && is_super_admin() ) {
			return true;
		}
		// single site admin
		if ( ! is_multisite() && is_super_admin() ) {
			return true;
		}
		return false;
	}
	/**
	 * Is notification enabled
	 * @since 2.2
	 * @return bool
	 */
	private function notification_enabled() {
		global $pagenow;
		$screen = get_current_screen();
		$show   = false;
		if ( 'fl-builder-template' == $screen->post_type ) {
			$show = true;
		}
		if ( 'fl-theme-layout' == $screen->post_type ) {
			$show = true;
		}
		if ( 'admin.php' == $pagenow && isset( $_GET['page'] ) && 'njba-admin-setting' == $_GET['page'] ) {
			$show = true;
		}
		if ( 'toplevel_page_njba-admin-setting' == $screen->id ) {
			$show = true;
		}
		if ( '0' === get_site_option( 'njba_usage_enabled' ) ) {
			$show = false;
		}
		if ( ! is_super_admin() ) {
			$show = false;
		}
		return ( $show && ! get_site_option( 'njba_usage_enabled' ) ) ? true : false;
	}
	/**
	 * Show a user what kind of data we are collecting.
	 * @since 2.2
	 * @return string
	 */
	public function data_demo() {
		$data     = $this->get_data( true );
		$output   = '';
		$txt      = '';
		$settings = array(
			'server'   => array(
				'name' => __( 'Server Type', 'bb-njba' ),
				'data' => $data['data']['server'],
			),
			'php'      => array(
				'name' => __( 'PHP Version', 'bb-njba' ),
				'data' => $data['data']['php'],
			),
			'wp'       => array(
				'name' => __( 'WP Version', 'bb-njba' ),
				'data' => $data['data']['wp'],
			),
			'mu'       => array(
				'name' => __( 'WP Multisite', 'bb-njba' ),
				'data' => $data['data']['multisite'],
			),
			'locale'   => array(
				'name' => __( 'Locale', 'bb-njba' ),
				'data' => $data['data']['locale'],
			),
			'plugins'  => array(
				'name' => __( 'Plugins Count', 'bb-njba' ),
				'data' => $data['data']['plugins'],
			),
			'modules'  => array(
				'name' => __( 'Modules Used', 'bb-njba' ),
				'data' => __( 'Which modules are used and how many times.', 'bb-njba' ),
			),
		);
		foreach ( $settings as $k => $data ) {
			$txt .= sprintf( '<span class="usage-demo-left">%s</span><span class="usage-demo-right">: %s</span><br />', $data['name'], $data['data'] );
		}
		$output = sprintf( '<div class="usage-demo"><a class="stats-info" href="#">%s</a><div class="stats-info-data"><p>%s</p><p><em>%s</em></p></div></div>',
			__( 'What kind of info will we collect?', 'bb-njba' ),
			$txt,
			__( 'We will never collect any private data such as IP, email addresses or usernames.', 'bb-njba' )
		);
		return $output;
	}
	/**
	 * Gather stats to send
	 * @since 2.2
	 * @return array
	 */
	public function get_data( $demo = false ) {
		global $wp_version, $wpdb;
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$data  = array(
			 'modules' => array(),
		);
		$plugins_data           = get_plugins();
		$data['plugins']        = count( $plugins_data );
		$data['plugins_active'] = 0;
		foreach ( (array) $plugins_data as $plugin_slug => $plugin ) {
			if ( is_plugin_active( $plugin_slug ) ) {
				$data['plugins_active'] ++;
			}
		}
		$post_types = get_post_types( array(
			'public'   => true,
			'_builtin' => true,
		) );
		if ( isset( $post_types['attachment'] ) ) {
			unset( $post_types['attachment'] );
		}
		$args = array(
			'post_type'      => $post_types,
			'post_status'    => 'publish',
			'meta_key'       => '_fl_builder_enabled',
			'meta_value'     => '1',
			'posts_per_page' => -1,
		);
		$query           = new WP_Query( $args );
		if ( is_array( $query->posts ) && ! empty( $query->posts ) ) {
			foreach ( $query->posts as $post ) {
				$meta = get_post_meta( $post->ID, '_fl_builder_data', true );
				foreach ( (array) $meta as $node_id => $node ) {
					if ( @isset( $node->type ) && 'module' == $node->type ) { // @codingStandardsIgnoreLine
						if ( ! isset( $data['modules'][ $node->settings->type ] ) ) {
							$data['modules'][ $node->settings->type ] = 1;
						} else {
							$data['modules'][ $node->settings->type ] ++;
						}
					}
				}
			}
		}
		$data['server']        = $_SERVER['SERVER_SOFTWARE'];
		$data['database']      = ( ! empty( $wpdb->is_mysql ) ? $wpdb->db_version() : 'Unknown' );
		$data['multisite']     = is_multisite() ? 'Yes' : 'No';
		$data['subsites']      = is_multisite() ? get_blog_count() : '';
		$data['locale']        = get_locale();
		$data['php']           = phpversion();
		$data['wp']            = $wp_version;
		$data['fl-builder']    = FL_BUILDER_VERSION;
		$data['njba-version']    = NJBA_MODULE_VERSION;
		$theme = wp_get_theme();
		if ( $theme->get( 'Template' ) ) {
			$parent              = wp_get_theme( $theme->get( 'Template' ) );
			$data['theme']       = $parent->get( 'Name' );
			$data['theme_url']       = urlencode( $parent->get( 'ThemeURI' ) );
			$data['theme_child'] = $theme->get( 'Name' );
			$data['theme_child_url'] = urlencode( $theme->get( 'ThemeURI' ) );
		}
		else {
			$data['theme'] = $theme->get( 'Name' );
			$data['theme_url'] = urlencode( $theme->get( 'ThemeURI' ) );
		}
		if( defined( 'NINJA_BEAVER_PRO' ) ) {
				$license_key = trim( get_option( 'ninja_beaver_license_key' ) );
				$data['license'] = $license_key;
				$data['product_type'] = NINJA_BEAVER_PRO;
		}
		else {
			$data['license'] = '';
			$data['product_type'] = NINJA_BEAVER_LITE;
		}
		$data['id'] = md5( get_bloginfo( 'url' ) . get_bloginfo( 'admin_email' ) );
		$data['url']       = get_bloginfo( 'url' );
		$data['email']       = get_bloginfo( 'admin_email' );
		$output = array(
			'data' => $data,
		);
		//echo "<pre>"; print_r($output); echo "</pre>";
		return $output;
	}
}
new NJBAUsage();