<?php
namespace NextFeedBlock;

if (! defined( 'ABSPATH' ) ) exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

class NB_Post_Author{

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
            'nextfeed-postauthor-block',
            plugin_dir_url(__FILE__) . 'js/post-author.js',
            array('wp-blocks', 'wp-element', 'wp-i18n' )
        );

        register_block_type( 'nextfeed/post-author', [
			'attributes'      => [
                'title' => 'Blog Author'
			],
            'editor_script' => 'nextfeed-postauthor-block',
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
			$author_id = get_post_field( 'post_author' );
		}else if( $post_type == $this->post_type() ){
			$author_id =  Render::_instance()->_render_post('blog-author');
		}else{
			$author_id = 0;
        }
        
        $name = '<a class="author-link" href="'.esc_url( get_author_posts_url( $author_id ) ).'" rel="author">'.get_the_author_meta( 'display_name' , $author_id ).'</a>';
		ob_start();
        echo sprintf( '<%1$s class="%2$s">%3$s</%1$s>', 'div', 'next-feed-author', $name );
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