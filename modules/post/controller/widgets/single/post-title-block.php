<?php
namespace NextFeedBlock;

if (! defined( 'ABSPATH' ) ) exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

class NB_Post_Title{

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
            'nextfeed-posttitle-block',
            plugin_dir_url(__FILE__) . 'js/post-title.js',
            array('wp-blocks', 'wp-element', 'wp-i18n' )
        );

        register_block_type( 'nextfeed/post-title', [
			'attributes'      => [
                'title' => 'Post Title'
			],
            'editor_script' => 'nextfeed-posttitle-block',
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
			$title = get_the_title();
		}else if( $post_type == $this->post_type() ){
			$title =  Render::_instance()->_render_post('blog-title');
		}else{
			$title = esc_html__('Blog Title', 'next-feed' );
        }
        if ( !is_singular() ) {
			$title = '<a href="' . esc_url( get_permalink() ) . '">'.$title.'</a>';
        }
        wp_reset_postdata();
		ob_start();
        echo sprintf( '<%1$s class="%2$s">%3$s</%1$s>', 'h3', 'next-post-title entry-title', $title );
	
		return ob_get_clean();
	}

	
	public static function instance(){
        if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
   
}