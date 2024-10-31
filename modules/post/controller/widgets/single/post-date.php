<?php
namespace Elementor;
defined( 'ABSPATH' ) || exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

Class NextFedd_Post_Date extends Widget_Base{

    public function get_name() {
		return 'nextfeed-postdate';
    }
    
	public function get_title() {
		return esc_html__( 'Blog Date', 'next-feed' );
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
		return [ 'post', 'date', 'blog', 'blog title'];
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
				'label' => esc_html__( 'Date', 'next-feed' ),
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
			'_date_format',
			[
				'label' => esc_html__( 'Date Format', 'next-feed' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => apply_filters('nextfeed_blog_date_format', [
					'd F' => '29 December',
					'd F, Y' => '29 December, 2019',
					'd M, Y' => '29 Dec, 2019',
					'd M' => '29 Dec',
					'Y, d F' => '2019, 29 December',
					'd, M y' => '29, Dec 19',
					'F Y' => 'December 2019',
					'M Y' => 'Dec 2019',
					
				]),
				'default' => 'd F',
				'description'	 =>esc_html__( 'Selet date format', 'next-feed' ),
				
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

		do_action('nextfeed_postdate_tabs_general', $this);
        $this->end_controls_section();


        $this->start_controls_section(
			'nextfeed_title_section_style',
			array(
				'label' => esc_html__( 'Blog Date', 'next-feed' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		
		
		
		$this->add_control(
			'nextfeed_title_product_title_color',
			[
				'label'     => esc_html__( 'Color', 'next-feed' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .next-feed-date' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'nextfeed_title_typography',
				'label'     => esc_html__( 'Typography', 'next-feed' ),
				'selector'  => '{{WRAPPER}} .next-feed-date',
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
                    '{{WRAPPER}} .next-feed-date .nextfeeds-icon:before' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .next-feed-date svg' => 'max-width: {{SIZE}}{{UNIT}}; vertical-align: middle;',
                ],
				
            ]
		);

		$this->add_control(
			'_date_icon_color', [
				'label'		 =>esc_html__( 'Color', 'next-feed' ),
				'type'		 => Controls_Manager::COLOR,
				'default' => '',
				'selectors'	 => [
					'{{WRAPPER}} .next-feed-date .nextfeeds-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .next-feed-date svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};',
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
					'{{WRAPPER}} .next-feed-date .nextfeeds-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .next-feed-date svg' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				
			]
		);
		do_action('nextfeed_postdate_tabs_date-style', $this);
		$this->end_controls_section();

		do_action('nextfeed_postdate_tabs', $this);
        
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
			$date = get_the_date( $_date_format );
		}else if( $post_type == $this->post_type() ){
			$date =  Render::_instance()->_render_post('blog-date', $settings);
		}else{
			$date = esc_html__('Blog Date', 'next-feed' );
        }
        ?>
		 <span class="next-feed-date entry-date">
		<?php
			if($_icon_select['library'] == 'svg' || isset($_icon_select['value']['url'])){
				\Elementor\Icons_Manager::render_icon( $_icon_select, [ 'aria-hidden' => 'true'] );
			}else{
				?>
				<i class="nextfeeds-icon <?php echo esc_attr($_icon_select['value']);?>" aria-hidden="true" data-library="<?php echo esc_attr($_icon_select['library']);?>"></i>	
				<?php
			}
			 echo $date; ?></span>
		<?php 
		wp_reset_postdata();
	}

}