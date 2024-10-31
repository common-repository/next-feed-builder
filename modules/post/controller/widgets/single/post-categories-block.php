<?php
namespace NextFeedBlock;

if (! defined( 'ABSPATH' ) ) exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

class NB_Post_Categories{

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
            'nextfeed-postcategories-block',
            plugin_dir_url(__FILE__) . 'js/post-categories.js',
            array('wp-blocks', 'wp-element', 'wp-i18n' )
        );

        register_block_type( 'nextfeed/post-categories', [
			'attributes'      => [
                'title' => 'Blog Excerpt'
			],
            'editor_script' => 'nextfeed-postcategories-block',
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
			$categories = get_the_category_list('-');
		}else if( $post_type == $this->post_type() ){
			$categories =  Render::_instance()->_render_post('blog-categories');
		}else{
			$categories = esc_html__('Blog Categories', 'next-feed' );
        }
       
		ob_start();
        echo sprintf( '<%1$s class="%2$s">%3$s</%1$s>', 'div', 'next-feed-categories entry-categories', $categories );
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