<?php
namespace NextFeedBlock;

if (! defined( 'ABSPATH' ) ) exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

class NB_Post_Tags{

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
            'nextfeed-posttags-block',
            plugin_dir_url(__FILE__) . 'js/post-tags.js',
            array('wp-blocks', 'wp-element', 'wp-i18n' )
        );

        register_block_type( 'nextfeed/post-tags', [
			'attributes'      => [
                'title' => 'Blog Tags'
			],
            'editor_script' => 'nextfeed-posttags-block',
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
			$categories = get_the_tag_list('<ul><li>', '</li><li>', '</li></ul>');
		}else if( $post_type == $this->post_type() ){
			$categories =  Render::_instance()->_render_post('blog-tags');
		}else{
			$categories = esc_html__('Blog Tags', 'next-feed' );
        }
       
		ob_start();
        echo sprintf( '<%1$s class="%2$s">%3$s</%1$s>', 'div', 'next-feed-tags meta-text', $categories );
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