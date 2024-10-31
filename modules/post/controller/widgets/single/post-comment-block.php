<?php
namespace NextFeedBlock;

if (! defined( 'ABSPATH' ) ) exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

class NB_Post_Comment{

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
            'nextfeed-postcomment-block',
            plugin_dir_url(__FILE__) . 'js/post-comment.js',
            array('wp-blocks', 'wp-element', 'wp-i18n' )
        );

        register_block_type( 'nextfeed/post-comment', [
			'attributes'      => [
                'title' => 'Blog Content'
			],
            'editor_script' => 'nextfeed-postcomment-block',
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
		if(in_array($post_type, $this->support_posttype() ) ){
			if ( empty( $post ) ) {
				return;
			}
			
        }
        
        ob_start();
        if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
            echo sprintf( '<%1$s class="%2$s">%3$s</%1$s>', 'div', 'next-comment comments-wrapper section-inner', comments_template() );
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