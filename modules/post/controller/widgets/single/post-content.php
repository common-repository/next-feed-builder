<?php
namespace Elementor;
defined( 'ABSPATH' ) || exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

Class NextFedd_Post_Content extends Widget_Base{

    public function get_name() {
		return 'nextfeed-postcontent';
    }
    
	public function get_title() {
		return esc_html__( 'Blog Content', 'next-feed' );
    }

	public function show_in_panel() {
        return $this->post_type() === 'nextfeeds';
	}

	public function get_categories() {
		return [ 'nextfeed-post-single' ];
    }
    public function get_icon() {
		return 'eicon-post-content';
	}
	public function get_keywords() {
		return [ 'post', 'content', 'blog', 'blog description'];
	}
    
    public function post_type(){
        return Cpt::instance()->get_name();
    }

    public function support_posttype(){
        return Cpt::instance()->_support_posttype();
    }

    protected function _register_controls() {
        $this->start_controls_section(
			'nextfeed_content_section',
			array(
				'label' => esc_html__( 'Blog Content', 'next-feed' ),
			)
		);
		$this->add_control(
			'nextfeed_content_message',
			[
				'raw' => '<strong>' . esc_html__( 'Currently show default preview, when open editor mode.', 'next-addons' ) . '</strong> ' ,
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'render_type' => 'ui',
				
			]
		);
        $this->add_control(
			'nextfeed_content_header_size',
			[
				'label' => esc_html__( 'HTML Tag', 'next-feed' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'p' => 'p',
					'div' => 'div',
				],
				'default' => 'p',
			]
		);

		do_action('nextfeed_postcontent_tabs_general', $this);

        $this->end_controls_section();


        $this->start_controls_section(
			'nextfeed_content_section_style',
			array(
				'label' => esc_html__( 'Blog Content', 'next-feed' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		
		
		
		$this->add_control(
			'nextfeed_content_color',
			[
				'label'     => esc_html__( 'Color', 'next-feed' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .next-post-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'nextfeed_content_typography',
				'label'     => esc_html__( 'Typography', 'next-feed' ),
				'selector'  => '{{WRAPPER}} .next-post-content',
			)
		);
		do_action('nextfeed_postcontent_tabs_content_style', $this);
		$this->end_controls_section();

		do_action('nextfeed_postcontent_tabs', $this);
        
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
			$content = get_the_content();
		}else if( $post_type == $this->post_type() ){
			$content =  Render::_instance()->_render_post('blog-content');
		}else{
			$content = esc_html__('Blog Content', 'next-feed' );
        }
       echo sprintf( '<%1$s class="%2$s">%3$s</%1$s>', $settings['nextfeed_content_header_size'], 'next-post-content entry-content', $content );
	   wp_reset_postdata();
	}

}