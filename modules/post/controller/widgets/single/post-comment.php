<?php
namespace Elementor;
defined( 'ABSPATH' ) || exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

Class NextFedd_Post_Comment extends Widget_Base{

    public function get_name() {
		return 'nextfeed-postcomment';
    }
    
	public function get_title() {
		return esc_html__( 'Comment Box', 'next-feed' );
    }

	public function show_in_panel() {
        return $this->post_type() === 'nextfeeds';
	}

	public function get_categories() {
		return [ 'nextfeed-post-single' ];
    }
    public function get_icon() {
		return 'eicon-post-title';
	}
	public function get_keywords() {
		return [ 'post', 'comment', 'blog', 'blog comment'];
	}
    
    public function post_type(){
        return Cpt::instance()->get_name();
    }

    public function support_posttype(){
        return Cpt::instance()->_support_posttype();
    }

    protected function _register_controls() {
        $this->start_controls_section(
			'_section_content',
			array(
				'label' => esc_html__( 'Comment', 'next-feed' ),
			)
		);
		$this->add_control(
			'nextfeed_content_message',
			[
				'raw' => '<strong>' . esc_html__( 'Currently show default preview, when open editor mode.', 'next-feed' ) . '</strong> ' ,
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'render_type' => 'ui',
				
			]
		);
	  
		do_action('nextfeed_postcomment_tabs_general', $this);

        $this->end_controls_section();


		do_action('nextfeed_postcomment_tabs', $this);

        
	}

    protected function render(){
        $settings = $this->get_settings_for_display();
		extract($settings);

        global $post;
		$post_type = get_post_type();		
		if(in_array($post_type, $this->support_posttype() ) ){
			if ( empty( $post ) ) {
				return;
			}
			
        }else if( $post_type == $this->post_type() ){
            echo 'Do not preview on editor mode.';
			return;
        }
        //comments_popup_link();
        if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
        ?>
		<div class="next-comment comments-wrapper section-inner">

            <?php comments_template(); ?>

        </div>
		<?php 
		wp_reset_postdata();
        }
		
	}

}