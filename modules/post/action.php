<?php
namespace NextFeed\Modules\Post;
defined( 'ABSPATH' ) || exit;
/**
 * Cpt Class.
 * Cpt class for custom post type.
 *
 * @since 1.0.0
 */
Class Action{

    private static $instance;

    public function __init(){
       
        // load modal in footer
        add_action('admin_footer', [$this, '_modal_view']);  
    }
   
    public function _posttype_valid(){
        return apply_filters('nextfeed_posttype_valid', array_keys($this->_temp_type()) );
    }
    public function _temp_type(){
        $temp = [
            'post' => [
                'name' => 'Blog Template',
                'categories' => [
                    'archive' => 'Archive',
                    'single' => 'Single Blog',
                ]
            ]

        ];
        return apply_filters('nextfeed_temp_type', $temp);
    }

    public function _modal_view(){
        
        $screen = get_current_screen();
        $form_prefix = Cpt::instance()->get_name();
        
        if( in_array($screen->id, ['edit-nextfeeds', 'nextfeeds']) ){
            include_once Init::_get_dir(). '/views/cpt/modal-html.php';
        }
    }
    public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}
}