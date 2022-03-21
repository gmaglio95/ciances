<?php
/**
 * General WP and WPZOOM functions.
 *
 * @package WPZOOM
 */

define("WPZOOM_INC_URI", get_template_directory_uri() . "/wpzoom");

if( ! function_exists('get_deprecated_themes')) {

    function get_deprecated_themes(){
        return array(
            'artistica',
            'bizpress',
            'bonpress',
            'business-bite',
            'cadabrapress',
            'convention',
            'delicious',
            'domestica',
            'edupress',
            'elegance',
            'eventina',
            'evertis',
            'gallery',
            'graphix',
            'horizon',
            'hotelia',
            'impulse',
            'magnet',
            'magnific',
            'manifesto',
            'monograph',
            'newsley',
            'photoblog',
            'photoland',
            'photoria',
            'polaris',
            'prime',
            'professional',
            'proudfolio',
            'pulse',
            'sensor',
            'splendid',
            'sportpress',
            'techcompass',
            'technologic',
            'telegraph',
            'virtuoso',
            'voyage',
            'yamidoo-pro',
            'zenko',
            'elastik',
            'momentum',
            'insider',
            'magazine_explorer',
            'onplay',
            'daily_headlines',
            'litepress',
            'morning',
            'digital',
            'photoframe'
        );
    }
}

function get_demo_xml_data( $target = 'selected' )
{

    $xml_data = array(
        'remote' => array(
            'url' => '',
            'response' => false
        ),
        'local' => array(
            'url' => '',
            'response' => false
        ),
        'is_child_theme' => is_child_theme(),
    );

    // Stop when child theme is active
    if ( is_child_theme() )
        return $xml_data;

    $demos = get_demos_details();

    $url        = 'https://www.wpzoom.com/downloads/xml/' . $demos['selected'] . '.xml';
    $local_url  = get_template_directory() . '/theme-includes/demo-content/' . $demos['selected'] . '.xml';

    if ( $target == 'imported' ) {
        $url        = 'https://www.wpzoom.com/downloads/xml/' . $demos['imported'] . '.xml';
        $local_url  = get_template_directory() . '/theme-includes/demo-content/' . $demos['imported'] . '.xml';
    }

    // Check for local file
    if ( is_file($local_url) ) {
        $xml_data['local']['url'] = $local_url;
        $xml_data['local']['response'] = true;

    }
    // Check for remote file
    else {

        $transient_id = 'get_demo_xml_transient_' . $demos['theme'] . '_' . $demos['selected'];

        if ( $target == 'imported' ) {
            $transient_id = 'get_demo_xml_transient_' . $demos['theme'] . '_' . $demos['imported'];
        }

        $transient = get_site_transient( $transient_id );

        if ( ! $transient ) {

            $response = wp_remote_get( esc_url_raw( $url ) );
            $response_code = wp_remote_retrieve_response_code( $response );

            if ( ! is_wp_error( $response ) && $response_code === 200 ) {
                $xml_data['remote']['url'] = $url;
                $xml_data['remote']['response'] = true;

                set_site_transient( $transient_id, $xml_data, YEAR_IN_SECONDS );

                $transient = $xml_data;
            }

        }

        if ( is_array( $transient ) ) {
            $xml_data = array_merge($xml_data, $transient);
        }
    }

    return $xml_data;
}


/**
 * Get demo details
 *
 * @since   1.7.0
 *
 * @return  array   Demo details
 */
function get_demos_details()
{

    $raw_theme_name = WPZOOM::$themeName;

    if ( current_theme_supports( 'wpz-theme-info' ) ) {

        $theme_info = get_theme_support( 'wpz-theme-info' );
        $theme_info = array_pop( $theme_info );

        if ( ! empty( $theme_info['name'] ) ) {
            $raw_theme_name = $theme_info['name'];
        }

    }

    $themeName = str_replace(array('_', ' '), '-', strtolower($raw_theme_name));

    $data = array(
        'demos'         => array(),
        'theme'         => $themeName,
        'selected'      => $themeName,
        'default'       => $themeName,
        'imported'      => get_theme_mod('wpz_demo_imported'),
        'imported_date' => get_theme_mod('wpz_demo_imported_timestamp'),
        'multiple-demo' => false,
    );

    $arr_keys = array('name', 'id', 'thumbnail');

    if ( current_theme_supports('wpz-multiple-demo-importer') ) {
        $wrapped_demos = get_theme_support('wpz-multiple-demo-importer');
        $demos = array_pop($wrapped_demos);
        $selected = get_theme_mod('wpz_multiple_demo_importer');

        // Check if demos array has needed keys
        // If not, we need to change array by pushing keys into new demos array
        foreach ($demos['demos'] as $key => $demo) {
            if ( ! is_array($demo) ) {
                unset($demos['demos'][$key]);

                $demos['demos'][$key][$arr_keys[0]] = $demo; // name
                $demos['demos'][$key][$arr_keys[1]] = $themeName .'-'. $demo; // id
                $demos['demos'][$key][$arr_keys[2]] = ''; // thumbnail
            }
        }

        if ( empty($selected) && isset($demos['default']) ) {
            $selected = $demos['default'];
            $data['default'] = $demos['default'];
        }

        $data['demos']          = $demos['demos'];
        $data['multiple-demo']  = true;
        $data['selected']       = $themeName . '-' . $selected;
    }

    return $data;
}


if ( ! function_exists('zoom_array_key_exists') ) {
    function zoom_array_key_exists($keys, $search_arr)
    {
        foreach( $keys as $key ) {
            if( !array_key_exists($key, $search_arr) )
                return false;
        }

        return true;
    }
}

/**
 *
 * Hook function called after the erase demo content process has finished.
 *
 */
if ( ! function_exists('zoom_after_erase_demo') ) {
    function zoom_after_erase_demo()
    {
        $demos = get_demos_details();

        remove_theme_mod('wpz_demo_imported');
        remove_theme_mod('wpz_demo_imported_timestamp');
        delete_option('wpzoom_'. $demos['imported'] .'_theme_setup_complete');
    }

    add_action('erase_demo_end', 'zoom_after_erase_demo');
}

/**
 *
 * Hook function called before add partial to the customizer.
 *
 */
if ( ! function_exists('zoom_before_add_partial') ) {
    function zoom_before_add_partial( $wp, $setting_id )
    {
        if ( ! is_object($wp) )
            return false;

        $remove_partial = array('custom_logo');

        if ( in_array( $setting_id, $remove_partial ) ) {
            $wp->selective_refresh->remove_partial( $setting_id );
        }
    }

    add_action('wpzoom_remove_partial', 'zoom_before_add_partial', 10, 2);
}

function zoom_get_beauty_demo_title($name)
{
    return ucwords(str_replace(array('-', '_'),' ', $name));
}

/**
 * Get the ID of an attachment from its image URL.
 *
 * @author  Taken from reverted change to WordPress core http://core.trac.wordpress.org/ticket/23831
 *
 * @param   string $url The path to an image.
 *
 * @return  int|bool            ID of the attachment or 0 on failure.
 */

if(! function_exists('zoom_get_attachment_id_from_url')){
    function zoom_get_attachment_id_from_url( $url = '' ) {
        // If there is no url, return.
        if ( '' === $url ) {
            return false;
        }

        global $wpdb;
        $attachment_id = 0;

        // Function introduced in 4.0
        if ( function_exists( 'attachment_url_to_postid' ) ) {
            $attachment_id = absint( attachment_url_to_postid( $url ) );
            if ( 0 !== $attachment_id ) {
                return $attachment_id;
            }
        }

        // First try this
        if ( preg_match( '#\.[a-zA-Z0-9]+$#', $url ) ) {
            $sql = $wpdb->prepare(
                "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND guid = %s",
                esc_url_raw( $url )
            );
            $attachment_id = absint( $wpdb->get_var( $sql ) );

            if ( 0 !== $attachment_id ) {
                return $attachment_id;
            }
        }

        // Then try this
        $upload_dir_paths = wp_upload_dir();
        if ( false !== strpos( $url, $upload_dir_paths['baseurl'] ) ) {
            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $url );

            // Remove the upload path base directory from the attachment URL
            $url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $url );

            // Finally, run a custom database query to get the attachment ID from the modified attachment URL
            $sql = $wpdb->prepare(
                "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'",
                esc_url_raw( $url )
            );
            $attachment_id = absint( $wpdb->get_var( $sql ) );
        }

        return $attachment_id;
    }

}

if ( ! function_exists( 'inject_wpzoom_plugins' ) ):
    function inject_wpzoom_plugins( $res, $action, $args ) {

        //remove filter to avoid infinite loop.
        remove_filter( 'plugins_api_result', 'inject_wpzoom_plugins', 10, 3 );

        foreach (
            array(
                'social-icons-widget-by-wpzoom',
                'instagram-widget-by-wpzoom',
                'customizer-reset-by-wpzoom',
                'wpzoom-shortcodes',
                'wpforms-lite'
            ) as $plugin_slug
        ) {
            $api = plugins_api( 'plugin_information', array(
                'slug'   => $plugin_slug,
                'is_ssl' => is_ssl(),
                'fields' => array(
                    'banners'           => true,
                    'reviews'           => true,
                    'downloaded'        => true,
                    'active_installs'   => true,
                    'icons'             => true,
                    'short_description' => true,
                )
            ) );

            if ( ! is_wp_error( $api ) ) {
                $res->plugins[] = $api;
            }
        }

        return $res;
    }
endif;

if ( ! function_exists( 'zoom_callback_for_featured_plugins_tab' ) ):
    function zoom_callback_for_featured_plugins_tab( $args ) {
        add_filter( 'plugins_api_result', 'inject_wpzoom_plugins', 10, 3 );

        return $args;
    }
endif;

/**
 * SHOW NOTIFICATION FOR MIGRATION OF THE SHORTCODES COMPONENT. -=START=-
 */

/**
 * Callback that show migration notification for shortcodes module.
 */
if ( ! function_exists( 'wpz_shortcodes_migration_notification' ) ):
    function wpz_shortcodes_migration_notification() {

        if ( get_transient( 'wpz_shortcodes_admin_notice' ) || ! current_user_can( 'install_plugins' ) ) {
            return;
        }

        wp_enqueue_script('updates');

        $message     = '<strong>WPZOOM Shortcodes</strong> and <strong>Slideshow Shortcode</strong> <em>[wzslider]</em> modules will be <b><u>removed</u></b> in the <b><u>next update</u></b> of WPZOOM Framework. If you use our shortcodes and want to keep them working, please click on the button below to <b>install</b> the new <a href="https://wordpress.org/plugins/wpzoom-shortcodes/" target="_blank">WPZOOM Shortcodes plugin</a>. If you haven\'t used WPZOOM Shortcodes and don\'t plan to use them in the future, you can ignore this message and click on the dismiss button';
        $plugins     = get_plugins();
        $plugin_name = 'wpzoom-shortcodes';
        if ( empty( $plugins[ $plugin_name . '/' . $plugin_name . '.php' ] ) ) {
            if ( !(get_filesystem_method( array(), WP_PLUGIN_DIR ) == false )) {
                $classic_action  = __( 'Install WPZOOM Shortcodes Plugin' );
                $classic_url     = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $plugin_name ), 'install-plugin_' . $plugin_name );
                $classic_classes = ' install-now';
            }
        } else if ( is_plugin_inactive( $plugin_name . '/' . $plugin_name . '.php' ) ) {
            $classic_action  = __( 'Activate Plugin' );
            $classic_url     = wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=' . $plugin_name . '/' . $plugin_name . '.php' . '&from=wpz-shortcodes-migration' ), 'activate-plugin_' . $plugin_name . '/' . $plugin_name . '.php' );
            $classic_classes = ' activate-now';
        } else {
            $classic_action = __( 'The plugin is activated' );
            $classic_url    = wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=' . $plugin_name . '/' . $plugin_name . '.php' . '&from=wpz-shortcodes-migration' ), 'activate-plugin_' . $plugin_name . '/' . $plugin_name . '.php' );;
            $classic_classes = ' button-disabled install-now updated-message';
        }
        ?>

        <div style="padding:20px;" class="notice is-dismissible notice-warning wpz-notice-dismiss plugin-card-<?php echo $plugin_name; ?>">
            <p style="font-size:15px; line-height:1.6;padding:0 0 20px;"><?php echo wp_kses_post( $message ); ?></p>
            <p>
                <a class="button button-primary <?php echo $classic_classes ?>"
                   data-slug="<?php echo $plugin_name; ?>"
                   href="<?php echo $classic_url; ?>">
                    <?php echo $classic_action; ?>
                </a>
            </p>
        </div>
        <script>
            jQuery(document).ready(function () {

                jQuery('.wpz-notice-dismiss').on('click', '.install-now', function (event) {
                    var $button = jQuery(event.target);
                    event.preventDefault();

                    if ($button.hasClass('updating-message') || $button.hasClass('button-disabled')) {
                        return;
                    }

                    if (wp.updates.shouldRequestFilesystemCredentials && !wp.updates.ajaxLocked) {
                        wp.updates.requestFilesystemCredentials(event);

                        jQuery(document).on('credential-modal-cancel', function () {
                            var $message = jQuery('.install-now.updating-message');

                            $message
                                .removeClass('updating-message')
                                .text(wp.updates.l10n.installNow);

                            wp.a11y.speak(wp.updates.l10n.updateCancel, 'polite');
                        });
                    }

                    wp.updates.installPlugin({
                        slug: $button.data('slug')
                    });
                });

                jQuery(document).on("click", ".wpz-notice-dismiss .notice-dismiss", function () {
                    jQuery.ajax({
                        url: "<?php echo admin_url( 'admin-ajax.php' )?>",
                        type: "POST",
                        data: {wpz_shortcodes_admin_notice: 1, action: "wpz_shortcodes_dismiss_notice"}
                    });
                });
            });
        </script>
        <?php
    }
endif;

if ( ! function_exists( 'wpz_shortcodes_migration_notification_dismiss' ) ):
    function wpz_shortcodes_migration_notification_dismiss() {

        $expiration = MONTH_IN_SECONDS * 2;

        set_transient( 'wpz_shortcodes_admin_notice', 1, $expiration );

        wp_send_json_success();
    }
endif;

/**
 * Hook functions to actions in order to show migration notification message.
 */

add_action( 'admin_notices', 'wpz_shortcodes_migration_notification' );
add_action( 'wp_ajax_wpz_shortcodes_dismiss_notice', 'wpz_shortcodes_migration_notification_dismiss' );

/**
 * SHOW NOTIFICATION FOR MIGRATION OF THE SHORTCODES COMPONENT. -=END=-
 */


/**
 * SHOW NOTIFICATION FOR AUTOMATIC THEMES UPDATES + LICENSE KEY. -=START=-
 */

/**
 * Callback that show notification for automatic themes updates + license key.
 */
if ( ! function_exists( 'wpz_theme_updater_notification' ) ):
    function wpz_theme_updater_notification() {

        $ignored_themes = get_deprecated_themes();

        if ( in_array( WPZOOM::$theme_raw_name, $ignored_themes ) || get_transient( 'wpz_theme_updater_notice' ) || ! current_user_can( 'install_plugins' ) ) {
            return;
        }

        $message     = '<strong>BIG NEWS!</strong> Your WPZOOM theme can now be updated much easier with <strong>one click</strong> updates! Simply activate your <strong>license key</strong> on the <a href="admin.php?page=wpzoom-license">Theme License</a> page and enjoy every new update! <a href="https://www.wpzoom.com/docs/how-to-setup-automatic-theme-updates/" target="_blank">Learn More</a>';

        ?>

        <div style="padding:15px;" class="notice is-dismissible notice-success wpz-theme-updater-notice-dismiss">
            <p style="font-size:15px; line-height:1.6;"><?php echo wp_kses_post( $message ); ?></p>
        </div>
        <script>
            jQuery(document).ready(function () {

                jQuery(document).on("click", ".wpz-theme-updater-notice-dismiss .notice-dismiss", function () {
                    jQuery.ajax({
                        url: "<?php echo admin_url( 'admin-ajax.php' )?>",
                        type: "POST",
                        data: {wpz_theme_updater_notice: 1, action: "wpz_theme_updater_notification_dismiss"}
                    });
                });
            });
        </script>
        <?php
    }
endif;

if ( ! function_exists( 'wpz_theme_updater_notification_dismiss' ) ):
    function wpz_theme_updater_notification_dismiss() {

        $expiration = MONTH_IN_SECONDS * 2;

        set_transient( 'wpz_theme_updater_notice', 1, $expiration );

        wp_send_json_success();
    }
endif;

/**
 * Hook functions to actions in order to show migration notification message.
 */

add_action( 'admin_notices', 'wpz_theme_updater_notification' );
add_action( 'wp_ajax_wpz_theme_updater_notification_dismiss', 'wpz_theme_updater_notification_dismiss' );

/**
 * SHOW NOTIFICATION FOR AUTOMATIC THEMES UPDATES + LICENSE KEY. -=END=-
 */