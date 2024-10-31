<?php
namespace NextFeedBlock;

if (! defined( 'ABSPATH' ) ) exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

class NB_Post_Share{

	private static $instance;

	public function _init(){
        if( $this->post_type() !== 'nextfeeds' ){
           return;
        }
        self::instance()->register_block();
	}

	public function register_block(){
        if ( ! function_exists( 'register_block_type' ) ) {
			return;
        }
        wp_register_script(
            'nextfeed-postshare-block',
            plugin_dir_url(__FILE__) . 'js/post-share.js',
            array('wp-blocks', 'wp-element', 'wp-i18n' )
        );

        register_block_type( 'nextfeed/post-share', [
			'attributes'      => [
                'title' => 'Post Title'
			],
            'editor_script' => 'nextfeed-postshare-block',
			'render_callback' => [ $this, 'render_block'],
        ] );
        
	}

    public function support_posttype(){
        return Cpt::instance()->_support_posttype();
    }

    public function post_type(){
        return Cpt::instance()->get_name();
    }

	public function render_block( $attr ){
        
        global $post;
        $post_type = get_post_type();
        
		ob_start();		
		if(in_array($post_type, $this->support_posttype() ) ){
			echo Render::_instance()->_render_post('post-share');
		}else if( $post_type == $this->post_type() ){
			echo Render::_instance()->_render_post('post-share');
        }
        wp_reset_postdata();
		return ob_get_clean();
	}

	
	public static function instance(){
        if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
   
}