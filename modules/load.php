<?php 
namespace NextFeed\Modules;
defined( 'ABSPATH' ) || exit;
/**
 * Global Load class.
 *
 * @since 1.0.0
 */
class Load{
    private static $instance;

    public static function _get_url(){
        return \NextFeed\Plugin::modules_url();
    }
    public static function _get_dir(){
        return \NextFeed\Plugin::modules_dir();
    }

    public static function _version(){
        return \NextFeed\Plugin::version();
    }

    public function _init() {         
        // post bolg 
        Post\Init::instance()->_init();
        
        if(current_user_can('manage_options')){
            // proactive
           Proactive\Init::instance()->_init();
        }
        
    }

    public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}
}