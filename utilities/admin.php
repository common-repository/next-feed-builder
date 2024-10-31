<?php
namespace NextFeed\Utilities;

defined( 'ABSPATH' ) || exit;

/**
 * Global Admin class.
 *
 * @since 1.0.0
 */
use NextFeed\Modules\Post\Controller\Widgets\Manifest as manifest;

class Admin{
	
    private static $instance;

    public function init() {        
        if(current_user_can('manage_options')){
            add_filter( 'plugin_action_links_' . plugin_basename( \NextFeed\Plugin::plugin_file() ), [ $this , '_action_links'] );
            add_filter( 'plugin_row_meta', [ $this, '_plugin_row_meta'], 10, 2 );
            add_action( 'admin_enqueue_scripts', [ $this , '_admin_global_scripts'] );
            // admin script
            add_action( 'admin_enqueue_scripts', [ $this , '_admin_scripts'] );
           
            //admin bar render
            add_action( 'wp_before_admin_bar_render',   [ $this , '_before_admin_bar_render' ], 1000000 );

            // elementor css load
            add_action( 'elementor/editor/before_enqueue_styles', [  $this, '_admin_global_scripts' ] );
            add_action( 'elementor/editor/before_enqueue_styles', [  $this, '_scripts_elementor' ] );

            // notices load
            Notice::instance()->_init();

        }

        add_action( 'wp_enqueue_scripts', [ $this , '_admin_global_scripts'] );   
        // public script
        add_action( 'wp_enqueue_scripts', [ $this , '_public_scripts'] );

    }
    public static function _version(){
        return \NextFeed\Plugin::version();
    }
    public static function _plugin_url(){
        return \NextFeed\Plugin::plugin_url();
    }
    public static function _plugin_dir(){
        return \NextFeed\Plugin::plugin_dir();
    }

    public function _admin_global_scripts(){
        // next icon
        wp_register_style( 'nextaddons-icon-nx', self::_plugin_url() . 'assets/css/icon/nx-icon.css', false, self::_version() );
        // next social icon
        wp_register_style( 'nextfeed-social', self::_plugin_url() . 'assets/css/icon/nx-social.css', false, self::_version() );
        
        // settings style
        wp_register_style( 'nextfeed-settings-css', self::_plugin_url() . 'assets/css/nx-setting.css', false, self::_version() );
        // modal style
        wp_register_style( 'nextfeed-modal-css', self::_plugin_url() . 'assets/css/modal-css/modal-popup.css', false, self::_version() );
        // settings js
        wp_register_script( 'nextfeed-settings-js', self::_plugin_url() . 'assets/script/nx-setting.js', [ 'jquery'], self::_version(), true );
        // modal js
        wp_register_script( 'nextfeed-modal-js', self::_plugin_url() . 'assets/script/modal-js/modal-popup.js', ['jquery'], self::_version(), true );
        

        // next laibray css
        wp_register_style( 'nextfeed-popup-css', self::_plugin_url() . 'assets/css/nx-library/nx-popup.css', false, self::_version() );
        
        // next laibary js
        wp_register_script( 'nextfeed-popup-js', self::_plugin_url() . 'assets/script/nx-library/nx-popup.js', ['jquery'], self::_version(), true );
        
        // public js
        wp_register_script( 'nextfeed-public', self::_plugin_url() . 'assets/script/public.js', ['jquery'], self::_version(), true );
        //public css
        wp_register_style( 'nextfeed-public', self::_plugin_url() . 'assets/css/public.css', false, self::_version() );
        
    }
    /**
     * Public function _admin_scripts.
     * enque admin scripts
     *
     * @since 1.0.0
     */
    public function _admin_scripts(){
        $screen = get_current_screen();
        
        wp_enqueue_style( 'nextaddons-icon-nx' );
        wp_enqueue_style( 'nextfeed-social' );

        

       // echo $screen->id;
        if( in_array($screen->id, [ 'toplevel_page_nextfeed', 'plugins']) ){
            wp_enqueue_style('nextfeed-settings-css');
        
            wp_enqueue_script('nextfeed-settings-js');
        }
        if( in_array($screen->id, [ 'edit-nextfeeds', 'nextfeeds']) ){
            wp_enqueue_style('nextfeed-modal-css');
            wp_enqueue_script('nextfeed-modal-js');
        }

        wp_register_style( 'themedev_ads', self::_plugin_url() . 'assets/css/ads.css', false, self::_version() );
        wp_enqueue_style('themedev_ads');
        
    }

     /**
     * Public function _public_scripts.
     * enque public scripts
     *
     * @since 1.0.0
     */
    public function _public_scripts(){

       wp_enqueue_style( 'nextaddons-icon-nx' ); 
       wp_enqueue_style( 'nextfeed-social' ); 
       wp_enqueue_style( 'nextfeed-public' );
       wp_enqueue_script('nextfeed-public');
    }

    public function _scripts_elementor(){
       
    }
    /**
     * Public function _admin_menu.
     * check for admin menu create
     *
     * @since 1.0.0
     */
    public function _admin_menu(){
        add_menu_page(
            esc_html__('Next Feed', 'next-feed'),
            esc_html__('Next Feed', 'next-feed'),
            'read',
            'nextfeed',
            [$this, 'next_feeds'],
            'dashicons-feedback',
           100
        );
        add_submenu_page( 'nextfeed', esc_html__( 'Features', 'next-addons' ), esc_html__( 'Features', 'next-feed' ), 'manage_options', 'nextfeed', [ $this ,'next_feeds'], 1);
        
        if ( ! did_action( 'nextfeedPro/loaded' ) ) {
            add_submenu_page( 'nextfeed', esc_html__( 'Get Pro', 'next-feed' ), esc_html__( 'Get Pro', 'next-feed' ), 'manage_options', 'admin.php?page=nextfeed&tab=get-pro', '', 100);
        }
    }
    /**
     * Public function next_addons.
     * features include here
     *
     * @since 1.0.0
     */
    public function next_feeds(){
        
        $widgets = [];
        $widgets_pro = [];
        $message_status = 'No';
        $message_text = '';
        $active_tab = isset($_GET['tab']) ? help::sanitize($_GET['tab']) : 'widgets';
        if($active_tab == 'widgets'):
            if(isset($_POST['themedev-feed-submit'])){
                $addons = isset($_POST['themedev']) ? help::sanitize($_POST['themedev']) : [];
                if(update_option('__next_feed_active', $addons)){
                    $message_status = 'yes';
                    $message_text = __('Saved data.', 'next-feed');
                }
            }
      
            // get widgets
            $widgets =  manifest::instance()->_widgets();
            if ( did_action( 'nextfeedPro/loaded' ) ) {
                $widgets_pro =  \NextFeedPro\Modules\Woocommerce\Controller\Widgets\Manifest::instance()->_widgets();
            }
            $getServices = get_option('__next_feed_active', []);
        endif;

        if($active_tab == 'get-pro'){
            $widget['woo-title'] = [ 'key' => 'single'];
            $widget['woo-image'] = [ 'key' => 'single'];
            $widget['woo-thumbnial'] = [ 'key' => 'single'];
            $widget['woo-price'] = [ 'key' => 'single'];
            $widget['woo-excerpt'] = [ 'key' => 'single'];
            $widget['woo-content'] = [ 'key' => 'single'];
            $widget['woo-ratting'] = [ 'key' => 'single'];
            $widget['woo-meta'] = [ 'key' => 'single'];
            $widget['woo-sale'] = [ 'key' => 'single'];
            $widget['woo-attribute'] = [ 'key' => 'single'];
            $widget['woo-related'] = [ 'key' => 'single'];
            $widget['up-sells'] = [ 'key' => 'single'];
            
        }
        // include files
        include ( self::_plugin_dir().'apps/views/settings/admin/settings.php');
    }
    
     /**
     * Public function get_pro.
     * get pro features
     *
     * @since 1.0.0
     */
    public function get_pro(){
        echo 'get Pro';
    }
    /**
     * Public function _action_links.
     * ceate action link
     *
     * @since 1.0.0
     */
    public function _action_links($links){
        $links[] = '<a class="next-highlight-b" href="' . admin_url( 'edit.php?post_type=nextfeeds' ).'"> '. __('New template', 'next-feed').'</a>';
		$links[] = '<a class="next-highlight-a" href="https://products.themedev.net/next-feed/pricing/" target="_blank"> '. __('Buy Now', 'next-feed').'</a>';
	    return $links;
    }

    /**
     * Public function _action_links.
     * ceate action link
     *
     * @since 1.0.0
     */
    public function _plugin_row_meta(   $links, $file  ){
        if ( strpos( $file, basename( \NextFeed\Plugin::plugin_file() ) ) ) {
            $new_links = array(
                'demo' => '<a class="next-highlight-b" href="https://products.themedev.net/next-feed/" target="_blank"><span class="dashicons dashicons-welcome-view-site"></span>'. __('Live Demo', 'next-feed').'</a>',
                'doc' => '<a class="next-highlight-b" href="https://support.themedev.net/docs-category/next-feed/" target="_blank"><span class="dashicons dashicons-media-document"></span>'. __('User Guideline', 'next-feed').'</a>',
                'support' => '<a class="next-highlight-b" href="https://support.themedev.net/" target="_blank"><span class="dashicons dashicons-editor-help"></span>'. __('Support', 'next-feed').'</a>',
                'pro' => '<a class="next-highlight-a" href="https://products.themedev.net/next-feed/pricing/" target="_blank" class="next-pro-plugin"><span class="dashicons dashicons-cart"></span>'. __('Get Pro', 'next-feed').'</a>'
            );
            $links = array_merge( $links, $new_links );
        }
        return $links;
    }

    /**
	 * Method Name: _before_admin_bar_render
	 * Description: Check PHP Version minimum Version 
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function _before_admin_bar_render(){
		global $wp_admin_bar;
		$wp_admin_bar->add_menu( array(
			'id'     => 'themedev-next-addons',
			'parent' => 'top-secondary',
			'title'  => __( 'Next Feed', 'next-feed' ) ,
			'meta'   => array( 'class' => 'themedev-next-addons' ),
			'href'   =>  esc_attr( admin_url( 'admin.php?page=nextfeed' ) )
		) );
		
	}
	
	 /**
     * Public function _missing_elementor.
     * check for elementor plugin
     *
     * @since 1.0.0
     */
	public function _missing_elementor(){
        if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		if ( file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' ) ) {
			$btn['label'] = esc_html__('Activate Elementor', 'next-feed');
			$btn['url'] = wp_nonce_url( 'plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php' );
		} else {
			$btn['label'] = esc_html__('Install Elementor', 'next-feed');
			$btn['url'] = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
		}

		Notice::push(
			[
				'id'          => 'unsupported-elementor-version',
				'type'        => 'error',
				'dismissible' => true,
				'btn'		  => $btn,
				'message'     => esc_html__( 'Next FeedBulider work with Elementor Plugin, if you want use Elementor then install and active this plugin', 'next-feed' ),
			]
		);
	}
     /**
     * Public function _check_version.
     * check for elementor version
     *
     * @since 1.0.0
     */
    public function _check_version(){
        $btn['label'] = esc_html__('Update Elementor', 'next-feed');
        $btn['url'] = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=elementor' ), 'upgrade-plugin_elementor' );
        
        Notice::push(
			[
				'id'          => 'unsupported-elementor-version',
				'type'        => 'error',
				'dismissible' => true,
				'btn'		  => $btn,
				'message'     => sprintf( esc_html__( 'Next Feed requires Elementor version %1$s+, which is currently NOT RUNNING.', 'next-feed' ), '2.7.4' ),
			]
		);
    }
    /**
     * Public function _check_php_version.
     * check for php version
     *
     * @since 1.0.0
     */
    public function _check_php_version(){
        Notice::push(
			[
				'id'          => 'unsupported-php-version',
				'type'        => 'error',
				'dismissible' => true,
				'message'     => sprintf( esc_html__( 'Next Feed requires PHP version %1$s+, which is currently NOT RUNNING on this server.', 'next-feed' ), '5.6'),
			]
		);
    }
	public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}

}