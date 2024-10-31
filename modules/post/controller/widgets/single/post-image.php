<?php
namespace Elementor;
defined( 'ABSPATH' ) || exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

Class NextFedd_Post_Image extends Widget_Base{

    public function get_name() {
		return 'nextfeed-postthumbnail';
    }
    
	public function get_title() {
		return esc_html__( 'Blog Thumbnail', 'next-feed' );
    }

	public function show_in_panel() {
        return $this->post_type() === 'nextfeeds';
	}

	public function get_categories() {
		return [ 'nextfeed-post-single' ];
    }
    public function get_icon() {
		return 'eicon-image';
	}
	public function get_keywords() {
		return [ 'post', 'Thumbnail', 'blog', 'blog Thumbnail'];
	}
    
    public function post_type(){
        return Cpt::instance()->get_name();
    }

    public function support_posttype(){
        return Cpt::instance()->_support_posttype();
    }

    protected function _register_controls() {
        $this->start_controls_section(
			'nextfeed_content_section_content',
			array(
				'label' => esc_html__( 'Featured Image', 'next-feed' ),
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
			'nextfeed_image_size',
			[
				'label' => esc_html__( 'Size', 'next-feed' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'post-thumbnail' => 'Thumbnail',
                    'post-medium' => 'Medium',
                    'post-medium_large' => 'Medium Large',
                    'post-large' => 'Large',
                    'post-full' => 'full',
				],
				'default' => 'post-thumbnail',
			]
        );
        
        do_action('nextfeed_postimage_tabs_general', $this);
        $this->end_controls_section();


        $this->start_controls_section(
			'nextfeed_content_section_style',
			array(
				'label' => esc_html__( 'Blog Feature', 'next-feed' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_control(
            'featured_position_toggle',
            [
                'label' => __( 'Size', 'next-addons' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', 'next-addons' ),
                'label_on' => __( 'Custom', 'next-addons' ),
                'return_value' => 'yes',
            ]
        );
		$this->start_popover();

        $this->add_responsive_control(
            'featured_position_y',
            [
                'label' => __( 'Width', 'next-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'featured_position_toggle' => 'yes'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .next-feature' => 'width: {{SIZE}}{{UNIT}}; object-fit: cover;',
                ],
            ]
        );

        $this->add_responsive_control(
            'featured_position_x',
            [
                'label' => __( 'Height', 'next-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'featured_position_toggle' => 'yes'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .next-feature' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
                    
                ],
            ]
        );

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_featured_border',
				'label' => __( 'Border', 'next-addons' ),
				'selector' => '{{WRAPPER}} .next-feature',
				
			]
		);

		$this->add_control(
            '_featured_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'next-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .next-feature' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);
		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_featured_box_shadow',
                'selector' => '{{WRAPPER}} .next-feature',
            ]
		);

        do_action('nextfeed_postimage_tabs_image_style', $this);
        $this->end_controls_section();
        
        do_action('nextfeed_postimage_tabs', $this);
        
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
			the_post_thumbnail($nextfeed_image_size, ['class' => 'next-feature img-responsive responsive--full', 'title' => 'Feature image']);
		}else if( $post_type == $this->post_type() ){
            echo Render::_instance()->_render_post('woo-thumbnail', $settings);
		}else{
			echo esc_html__('Display Blog Thumbnail', 'next-feed' );
        }
        wp_reset_postdata();
	}

}