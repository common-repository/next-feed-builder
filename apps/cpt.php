<?php
namespace NextFeed\Apps;
defined( 'ABSPATH' ) || exit;
/**
 * Cpt Abstract Class.
 * Cpt Abstract class for custom post type .
 *
 * @since 1.0.0
 */
abstract Class Cpt{

    /**
     * __construct function
     * @since 1.0.0
     */
    public function __construct() {
        
       $name = $this->get_name();
       $args = $this->post_type();

       add_action('init', function() use($name,$args) {
            register_post_type( $name, $args );
        });  

    }

    public abstract function post_type();

}

