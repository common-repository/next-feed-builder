<?php
namespace Elementor;
defined( 'ABSPATH' ) || exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

Class NextFedd_Post_Title extends Widget_Base{

    public function get_name() {
		return 'nextfeed-posttitle';
    }
    
	public function get_title() {
		return esc_html__( 'Blog Title', 'next-feed' );
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
		return [ 'post', 'title', 'blog', 'blog title'];
	}
    
    public function post_type(){
        return Cpt::instance()->get_name();
    }

    public function support_posttype(){
        return Cpt::instance()->_support_posttype();
    }

    protected function _register_controls() {
        $this->start_controls_section(
			'nextfeed_title_section_content',
			array(
				'label' => esc_html__( 'Title', 'next-feed' ),
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
			'nextfeed_title_header_size',
			[
				'label' => esc_html__( 'HTML Tag', 'next-feed' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'h1',
			]
		);

		do_action('nextfeed_posttitle_tabs_general', $this);

        $this->end_controls_section();


        $this->start_controls_section(
			'nextfeed_title_section_style',
			array(
				'label' => esc_html__( 'Blog Title', 'next-feed' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		
		
		
		$this->add_control(
			'nextfeed_title_product_title_color',
			[
				'label'     => esc_html__( 'Color', 'next-feed' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .next-post-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'nextfeed_title_typography',
				'label'     => esc_html__( 'Typography', 'next-feed' ),
				'selector'  => '{{WRAPPER}} .next-post-title',
			)
		);
		
		do_action('nextfeed_posttitle_tabs_title_style', $this);
		$this->end_controls_section();

		do_action('nextfeed_posttitle_tabs', $this);
        
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
			$title = get_the_title();
		}else if( $post_type == $this->post_type() ){
			$title =  Render::_instance()->_render_post('blog-title');
		}else{
			$title = esc_html__('Blog Title', 'next-feed' );
        }
        if ( !is_singular() ) {
			$title = '<a href="' . esc_url( get_permalink() ) . '">'.$title.'</a>';
		}
        echo sprintf( '<%1$s class="%2$s">%3$s</%1$s>', $settings['nextfeed_title_header_size'], 'next-post-title entry-title', $title );
		wp_reset_postdata();
	}

}