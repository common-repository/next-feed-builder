<?php
namespace NextFeed;
defined( 'ABSPATH' ) || exit;
/**
 * plugin Loader.
 * Loading Class auto
 * @since 1.0.0
 */
class Loader{
    
	/**
	 * Run Loader.
	 * @since 1.0.0
	 * @access public
	 */
	public static function _run() {
		spl_autoload_register( [ __CLASS__, '_autoload' ] );
    }
    
    /**
	 * _autoload.
	 * @since 1.0.0
	 * @access private
	 * @param string $class Class name.
	 */
	private static function _autoload( $load ) {
        if ( 0 !== strpos( $load, __NAMESPACE__ ) ) {
            return;
        }
        
        $filename = strtolower(
            preg_replace(
                [ '/\b'.__NAMESPACE__.'\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
                [ '', '$1-$2', '-', DIRECTORY_SEPARATOR],
                $load
            )
        );
       $file = plugin_dir_path(__FILE__) . $filename . '.php';
        if ( file_exists( $file ) ) {
           require_once( $file );
        }
    }
}
