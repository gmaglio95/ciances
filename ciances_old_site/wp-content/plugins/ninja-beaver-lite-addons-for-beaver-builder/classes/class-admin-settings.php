<?php

class NJBASettingsPage 
{ 
    /** 
     * Holds the values to be used in the fields callbacks 
     */ 
    private $options; 
    /** 
     * Start up 
     */ 
    public function __construct() 
    { 
         add_action( 'admin_menu', array( $this, 'njba_add_plugin_page' ) ); 
         add_action( 'admin_enqueue_scripts',array( $this, 'styles_scripts') ); 
    } 
    public function styles_scripts() 
    { 
        // Admin Styles & Script 
          wp_enqueue_style( 'njba-admin-settings', NJBA_MODULE_URL . 'assets/css/njba-admin-settings.css', array(), NJBA_MODULE_VERSION ); 
          if(isset( $_REQUEST['page'] ) && 'njba-admin-setting' == $_REQUEST['page'] )
          { 
                 wp_enqueue_script( 'njba-admin-menu', NJBA_MODULE_URL . 'assets/js/njba-admin-menu.js', array(), NJBA_MODULE_VERSION );
                
          }
    } 
    /** 
     * Add options page 
     */ 
    public function njba_add_plugin_page() 
    { 
         // This page will be appearence "Dashboard" 
          $page_title = 'Ninja Beaver'; 
          $menu_title = 'Ninja Beaver'; 
          $capability = 'manage_options'; 
          $menu_slug  = 'njba-admin-setting'; 
          $function   = array( $this, 'njba_admin_option'); 
          $icon_url   = 'dashicons-admin-generic'; 
          $position   = 81; 
          add_menu_page( $page_title,$menu_title,$capability, $menu_slug, $function, $icon_url, $position ); 
          // add_submenu_page( $menu_slug, 'License', 'License', 'manage_options', 'njba-addons-license', array( $this, 'njba_addons_license')); 
          // add_submenu_page( $menu_slug, 'Addons', 'Addons', 'manage_options', 'njba-addons-purchase', array( $this, 'njba_addons_purchase'));
    } 
    /** 
     * General Settings page 
     */ 
    function njba_admin_option() { 
        include('admin/class-general-settings.php'); 
    } 
    /** 
     * License Lists page 
     */ 
    
    function njba_addons_license() { 
        include('admin/extensions-list/class-extensions-list-settings.php'); 
    } 
    /**
    
    * Addons Purchase List 
    */ 
    function njba_addons_purchase(){ 
        include('admin/purchase/class-purchase-list.php');
    } 
    /**  
     * Renders the nav items for the admin settings menu. 
     * 
     * @since 1.0 
     * @return void 
     */    
    static public function render_nav_items() 
    { 
        $item_data = apply_filters( 'fl_builder_admin_settings_nav_items', array( 
            
            'welcome' => array( 
                'title'     => __( 'Welcome', 'fl-builder' ), 
                'show'      => true, 
                'priority'  => 100 
            ),
            'general' => array(
                'title'     => __( 'General Settings', 'fl-builder' ),
                'show'      => true,
                'priority'  => 300
            ), 
            'modules' => array( 
                'title'     => __( 'Modules', 'fl-builder' ), 
                'show'      => true, 
                'priority'  => 400 
            ), 
            
        ) ); 
         
        $sorted_data = array(); 
         
        foreach ( $item_data as $key => $data ) { 
            $data['key'] = $key; 
            $sorted_data[ $data['priority'] ] = $data; 
        } 
         
        ksort( $sorted_data ); 
         
        foreach ( $sorted_data as $data ) { 
            if ( $data['show'] ) { 
                echo '<li><a href="#' . $data['key'] . '">' . $data['title'] . '</a></li>'; 
            } 
        } 
    } 
    /**  
     * Renders the admin settings forms. 
     * 
     * @since 1.0 
     * @return void 
     */     
    static public function render_forms() 
    { 
                 
        // Welcome 
       
        self::render_form( 'welcome' ); 
         // General
        
        self::render_form( 'general' );
        
         
        // Modules 
        self::render_form( 'modules' );

        
   
      
        // Let extensions hook into form rendering. 
        do_action( 'fl_builder_admin_settings_render_forms' ); 
    } 
     
   /**  
     * Renders an admin settings form based on the type specified. 
     * 
     * @since 1.0 
     * @param string $type The type of form to render. 
     * @return void 
     */     
    static public function render_form( $type ) 
    { 
       // if ( self::has_support( $type ) ) { 
            include NJBA_MODULE_DIR . 'classes/admin/admin-settings-' . $type . '.php'; 
       // } 
    } 
     
    /**  
     * Renders the action for a form. 
     * 
     * @since 1.0 
     * @param string $type The type of form being rendered. 
     * @return void 
     */    
    static public function render_form_action( $type = '' ) 
    { 
            echo admin_url( '/admin.php?page=njba-admin-setting#' . $type );
    } 
} 

if( is_admin() ) 
{
    $my_settings_page = new NJBASettingsPage();
}