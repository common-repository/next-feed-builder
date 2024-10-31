<?php 
namespace NextFeed\Modules\Post\Controller;
defined( 'ABSPATH' ) || exit;
/**
 * Init class.
 *
 * @since 1.0.0
 */


class Init{
    private static $instance;

    public function _init() {        
        // single Blog Page
        Single::instance()->__init();
        // Aechive Page
        Archive::instance()->__init();
       
        Widgets\Manifest::instance()->init();
       
    }

    public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
   
}