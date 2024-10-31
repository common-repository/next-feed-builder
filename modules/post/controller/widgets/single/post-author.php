<?php
namespace Elementor;
defined( 'ABSPATH' ) || exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

Class NextFedd_Post_Author extends Widget_Base{

    public function get_name() {
		return 'nextfeed-postauthor';
    }
    
	public function get_title() {
		return esc_html__( 'Blog Author', 'next-feed' );
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
		return [ 'post', 'author', 'blog', 'blog author'];
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
				'label' => esc_html__( 'Author', 'next-feed' ),
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
       
		$this->add_control(
            '_blog_author_enable',
            [
                'label' => esc_html__( 'Photo Display as', 'next-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'next-addons' ),
                'label_off' => esc_html__( 'Hide', 'next-addons' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        
        do_action('nextfeed_postauthor_tabs_general', $this);
        $this->end_controls_section();


        $this->start_controls_section(
			'author_section_style',
			array(
				'label' => esc_html__( 'Blog Author', 'next-feed' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		
		
		$this->add_control(
			'_product_title_color',
			[
				'label'     => esc_html__( 'Color', 'next-feed' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .next-feed-author a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => '_typography',
				'label'     => esc_html__( 'Typography', 'next-feed' ),
				'selector'  => '{{WRAPPER}} .next-feed-author a',
			)
		);
		
		$this->add_control(
            '_date_icon_heading',
            [
                'label' => esc_html__( 'Photos', 'next-feed' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
            ]
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
                    '{{WRAPPER}} .next-feed-author .author-image img' => 'width: {{SIZE}}{{UNIT}}; object-fit: cover;',
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
                    '{{WRAPPER}} .next-feed-author .author-image img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
                    
                ],
            ]
        );

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_featured_border',
				'label' => __( 'Border', 'next-addons' ),
				'selector' => '{{WRAPPER}} .next-feed-author .author-image img',
				
			]
		);

		$this->add_control(
            '_featured_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'next-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .next-feed-author .author-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);
		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_featured_box_shadow',
                'selector' => '{{WRAPPER}} .next-feed-author .author-image img',
            ]
		);

        do_action('nextfeed_postauthor_tabs_author_style', $this);
        $this->end_controls_section();
        
        do_action('nextfeed_postauthor_tabs', $this);
        
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
			$author_id = get_post_field( 'post_author' );
		}else if( $post_type == $this->post_type() ){
			$author_id =  Render::_instance()->_render_post('blog-author');
		}else{
			$author_id = 0;
        }
        ?>
		<div class="next-feed-author">
			<?php if($_blog_author_enable == 'yes'):?>
			<span class="author-image">
				<?php 
				echo get_avatar( $author_id, 100 );
				?>
			</span>
			<?php endif;?>
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" rel="author"><?php the_author_meta( 'display_name' , $author_id ); ?></a>
		</div>
		<?php 
		wp_reset_postdata();
	}

}