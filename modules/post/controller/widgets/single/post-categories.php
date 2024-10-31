<?php
namespace Elementor;
defined( 'ABSPATH' ) || exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

Class NextFedd_Post_Categories extends Widget_Base{

    public function get_name() {
		return 'nextfeed-postcategories';
    }
    
	public function get_title() {
		return esc_html__( 'Blog Categories', 'next-feed' );
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
		return [ 'post', 'categories', 'blog', 'blog categories'];
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
				'label' => esc_html__( 'Categories', 'next-feed' ),
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
            '_categories_seperator',
            [
                'label'         => esc_html__('Seperator', 'next-addons'),
                'type'          => Controls_Manager::TEXT,
                'default' 		=> ' - ',
              
            ]
		);
		$this->add_control(
			'_icon_select',
			[
				'label' => esc_html__( 'Icon', 'next-feed' ),
				'type' =>  \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => '_icon_selects',
               
			]
		);
		do_action('nextfeed_postcategories_tabs_general', $this);
        $this->end_controls_section();


        $this->start_controls_section(
			'categories_section_style',
			array(
				'label' => esc_html__( 'Blog Categories', 'next-feed' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		
		
		$this->add_control(
			'_product_title_color',
			[
				'label'     => esc_html__( 'Color', 'next-feed' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .next-feed-categories a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => '_typography',
				'label'     => esc_html__( 'Typography', 'next-feed' ),
				'selector'  => '{{WRAPPER}} .next-feed-categories a',
			)
		);
		
		$this->add_control(
            '_date_icon_heading',
            [
                'label' => esc_html__( 'Icon', 'next-feed' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
            ]
        );
		
		$this->add_control(
            '_date_icon_size',
            [
                'label' => esc_html__( 'Size', 'next-feed' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .next-feed-categories .nextfeeds-icon:before' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .next-feed-categories svg' => 'max-width: {{SIZE}}{{UNIT}}; vertical-align: middle;',
                ],
				
            ]
		);

		$this->add_control(
			'_date_icon_color', [
				'label'		 =>esc_html__( 'Color', 'next-feed' ),
				'type'		 => Controls_Manager::COLOR,
				'default' => '',
				'selectors'	 => [
					'{{WRAPPER}} .next-feed-categories .nextfeeds-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .next-feed-categories svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'_date_icon_spacing',
			[
				'label' => __( 'Spacing', 'next-feed' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .next-feed-categories .nextfeeds-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .next-feed-categories svg' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				
			]
		);

		do_action('nextfeed_postcategories_tabs_categories_style', $this);
		$this->end_controls_section();
		
		do_action('nextfeed_postcategories_tabs', $this);
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
			$categories = get_the_category_list( $_categories_seperator );
		}else if( $post_type == $this->post_type() ){
			$categories =  Render::_instance()->_render_post('blog-categories', $settings);
		}else{
			$categories = esc_html__('Blog Categories', 'next-feed' );
        }
        ?>
		 <div class="next-feed-categories entry-categories">
		<?php
			if($_icon_select['library'] == 'svg' || isset($_icon_select['value']['url'])){
				\Elementor\Icons_Manager::render_icon( $_icon_select, [ 'aria-hidden' => 'true'] );
			}else{
				?>
				<i class="nextfeeds-icon <?php echo esc_attr($_icon_select['value']);?>" aria-hidden="true" data-library="<?php echo esc_attr($_icon_select['library']);?>"></i>	
				<?php
			}
			 echo $categories; ?></div>
		<?php 
		wp_reset_postdata();
	}

}