<?php
namespace Elementor;
defined( 'ABSPATH' ) || exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

Class NextFedd_Post_Comment_Count extends Widget_Base{

    public function get_name() {
		return 'nextfeed-postcomment-count';
    }
    
	public function get_title() {
		return esc_html__( 'Comment Count', 'next-feed' );
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
		return [ 'post', 'comment', 'count', 'blog comment'];
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
	  
		do_action('nextfeed_postcommentcount_tabs_general', $this);
        $this->end_controls_section();

		$this->start_controls_section(
			'nextfeed_title_section_style',
			array(
				'label' => esc_html__( 'Comment Count', 'next-feed' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		
		
		
		$this->add_control(
			'nextfeed_title_product_title_color',
			[
				'label'     => esc_html__( 'Color', 'next-feed' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .next-comment-count a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'nextfeed_title_typography',
				'label'     => esc_html__( 'Typography', 'next-feed' ),
				'selector'  => '{{WRAPPER}} .next-comment-count a',
			)
		);
		
		do_action('nextfeed_postcommentcount_tabs_count_style', $this);
		$this->end_controls_section();

		do_action('nextfeed_postcommentcount_tabs', $this);
        
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
       
        if ( comments_open() ) {
        ?>
		<span class="next-comment-count meta-text">

            <?php comments_popup_link(); ?>

        </span>
		<?php 
		wp_reset_postdata();
        }
		
	}

}