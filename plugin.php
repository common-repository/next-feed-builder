<?php
namespace NextFeed;
defined( 'ABSPATH' ) || exit;
/**
 * Syatem final Class.
 * Loading classclasses only when needed. Check Elementor Plugin Loaded or Install.
 *
 * @since 1.0.0
 */
final class Plugin{

    private static $instance;

    private $template;

    /**
     * __construct function
     * @since 1.0.0
     */
    public function __construct(){
        Loader::_run(); 
    }
     /**
	 * Plugin url
	 *
	 * @since 1.0.0
	 * @var string plugins's version.
	 */
    public static function version(){
        return '1.0.3';
    }
    /**
	 * Plugin url
	 *
	 * @since 1.0.0
	 * @var string plugins's root url.
	 */
    public static function php_version(){
        return '5.6';
    }

    /**
	 * Plugin url
	 *
	 * @since 1.0.0
	 * @var string plugins's root url.
	 */
	public static function plugin_file(){
		return  NEXTFEED_FILE_ ;
	}
    /**
	 * Plugin url
	 *
	 * @since 1.0.0
	 * @var string plugins's root url.
	 */
	public static function plugin_url(){
		return trailingslashit(plugin_dir_url( self::plugin_file() ));
	}

	/**
	 * Plugin dir
	 *
	 * @since 1.0.0
	 * @var string plugins's root directory.
	 */
	public static function plugin_dir(){
		return trailingslashit(plugin_dir_path( self::plugin_file() ));
    }
    
    /**
	 * Plugin url
	 *
	 * @since 1.0.0
	 * @var string plugins's root url.
	 */
	public static function widgets_url(){
		return self::plugin_url() . 'widgets/';
	}

	/**
	 * Plugin dir
	 *
	 * @since 1.0.0
	 * @var string plugins's root directory.
	 */
	public static function widgets_dir(){
		return self::plugin_dir() . 'widgets/';
	}

	/**
	 * Plugin url
	 *
	 * @since 1.0.0
	 * @var string plugins's root url.
	 */
	public static function modules_url(){
		return self::plugin_url() . 'modules/';
	}

	/**
	 * Plugin dir
	 *
	 * @since 1.0.0
	 * @var string plugins's root directory.
	 */
	public static function modules_dir(){
		return self::plugin_dir() . 'modules/';
	}
    /**
     * Public function init.
     * call function for all
     *
     * @since 1.0.0
     */
    public function init(){
        // Check if Elementor installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [Utilities\Admin::instance(), '_missing_elementor'] );
			//return;
        }     
		// Check for required Elementor version.
		if ( did_action( 'elementor/loaded' ) && ! version_compare( ELEMENTOR_VERSION, '2.7.4', '>=' ) ) {
			add_action( 'admin_notices', [Utilities\Admin::instance(), '_check_version']);
			return;
        }
     
        if ( version_compare( PHP_VERSION, self::php_version(), '<' ) ) {
			add_action( 'admin_notices', [Utilities\Admin::instance(), '_check_php_version'] );
			return;
		}
        // check permission for manage user
        if(current_user_can('manage_options')){
            add_action( 'admin_menu', [Utilities\Admin::instance(), '_admin_menu']);           
        }

        add_action( 'init', [Utilities\Admin::instance(), 'init']);

       // call modules 
        Modules\Load::instance()->_init();

       // load elementor widget
        //Widgets\Manifest::instance()->init();
    }

    public static function instance(){
        if ( is_null( self::$instance ) ){
            self::$instance = new self();
            do_action( 'nextfeed/loaded' );
        }
        return self::$instance;
    }

}