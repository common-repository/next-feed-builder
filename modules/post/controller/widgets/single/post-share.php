<?php
namespace Elementor;
defined( 'ABSPATH' ) || exit;

use \NextFeed\Modules\Post\Cpt as Cpt;
use \NextFeed\Modules\Post\Controller\Widgets\Render as Render;

Class NextFedd_Post_Share extends Widget_Base{

    public function get_name() {
		return 'nextfeed-postshare';
    }
    
	public function get_title() {
		return esc_html__( 'Blog Share', 'next-feed' );
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
		return [ 'post', 'share', 'blog', 'blog share'];
	}
    
    public function post_type(){
        return Cpt::instance()->get_name();
    }

    public function support_posttype(){
        return Cpt::instance()->_support_posttype();
    }

    protected function _register_controls() {
        $this->start_controls_section(
			'_share_section_content',
			array(
				'label' => esc_html__( 'Social Share', 'next-feed' ),
			)
		);
	
		if ( !did_action( 'nextsocial/loaded' ) ) {
			if ( file_exists( WP_PLUGIN_DIR . '/next-social-login-feed-sharing/next-social-login-feed-sharing.php' ) ) {
				$link = wp_nonce_url( 'plugins.php?action=activate&plugin=next-social-login-feed-sharing/next-social-login-feed-sharing.php&plugin_status=all&paged=1', 'activate-plugin_next-social-login-feed-sharing/next-social-login-feed-sharing.php' );
            
			}else{
				$link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=next-social-login-feed-sharing' ), 'install-plugin_next-social-login-feed-sharing' );
			}

			$this->add_control(
				'_nextsocial_install',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<a href="'. $link .'" target="_blank" rel="noopener">Get more providers. Click to install or activate Next Social</a>',
				]
			);
		}
		if ( did_action( 'nextsocial/loaded' ) ) {
			
			$this->add_control(
				'_enable_next_social',
				[
					'label' => __( 'Active Next Social', 'next-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'no',
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'_select_providers',
				[
					'label' => __( 'Select Providers', 'next-addons' ),
					'type' => Controls_Manager::SELECT2,
					'multiple' => true,
					'label_block' => true,
					'options' =>  $this->_counter_provider(),
					'default' => 'all',
					'condition' => [ '_enable_next_social' => ['yes'] ]
				]
			);

			$this->add_control(
				'_select_styles',
				[
					'label' => __( 'Select Style', 'next-addons' ),
					'type' => Controls_Manager::SELECT,
					'label_block' => true,
					'options' =>  $this->_counter_style(),
					'default' => '',
					'condition' => [ '_enable_next_social' => ['yes'] ]
				]
			);
			
			$this->add_control(
				'_custom_class', [
					'label'			 =>esc_html__( 'Custom Class', 'next-addons' ),
					'type'			 => Controls_Manager::TEXT,
					'label_block'	 => false,
					'default'	 => '',
					'condition' => [ '_enable_next_social' => ['yes'] ]
				]
			);
		}
		do_action('nextfeed_postshare_tabs_general', $this);

        $this->end_controls_section();


        $this->start_controls_section(
			'_share_section_style',
			array(
				'label' => esc_html__( 'Providers', 'next-feed' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'_title_color',
			[
				'label'     => esc_html__( 'Color', 'next-feed' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nextfeed-socialshare .nx-social:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => '_title_typography',
				'label'     => esc_html__( 'Typography', 'next-feed' ),
				'selector'  => '{{WRAPPER}} .nextfeed-socialshare .nx-social:before',
			)
		);

		$this->add_control(
            '_title_size',
            [
                'label' => esc_html__( 'Size', 'next-feed' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .nextfeed-socialshare li a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
				
            ]
		);

		$this->add_control(
            '_title_spacing',
            [
                'label' => esc_html__( 'Spacing', 'next-feed' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .nextfeed-socialshare li' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
				
            ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_counter_border',
				'label' => __( 'Border', 'next-addons' ),
				'selector' => '{{WRAPPER}} .nextfeed-socialshare li a',
				
			]
		);

		$this->add_control(
            '_counter_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'next-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .nextfeed-socialshare li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);
		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_counter_box_shadow',
                'selector' => '{{WRAPPER}} .nextfeed-socialshare li a',
            ]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => '_counter_bg_normal',
				'label'     => esc_html__( 'Background', 'next-addons' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .nextfeed-socialshare li a:hover',
				'default'   => '',
			
			]
		);
	
		do_action('nextfeed_postshare_tabs_share_style', $this);
		
		$this->end_controls_section();

		do_action('nextfeed_postshare_tabs', $this);
        
	}

	public function _counter_style(){
        if ( did_action( 'nextsocial/loaded' ) ) {
            if( class_exists( '\themeDevSocial\Apps\Settings') ){
                $styles = \themeDevSocial\Apps\Settings::$share_style;
                $r = [];
                foreach($styles as $k=>$v){
                    $r[$k] = isset($v['text']) ? $v['text'] : $k;
                }
                return $r;
            }
        }
        return [];
    }

    public function _counter_provider(){
        if ( did_action( 'nextsocial/loaded' ) ) {
            if( class_exists( '\themeDevSocial\Apps\Settings') ){
                $getProvider = get_option( \themeDevSocial\Apps\Settings::$sharing_provider_key, [] );
                $gProvider = isset($getProvider['provider']) ? array_keys($getProvider['provider']) : [];
                $r = [];
                foreach($gProvider as $v){
                    $r[$v] = ucfirst($v);
                }
                return $r;
            }
        }
        return [];
	}
	
    protected function render(){
        $settings = $this->get_settings_for_display();
		extract($settings);
        global $post;
		$post_type = get_post_type();		
		if(in_array($post_type, $this->support_posttype() ) ){
			echo Render::_instance()->_render_post('post-share', $settings);
		}else if( $post_type == $this->post_type() ){
			echo Render::_instance()->_render_post('post-share', $settings);
		}
		wp_reset_postdata();
    }

}