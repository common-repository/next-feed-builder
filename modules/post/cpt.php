<?php
namespace NextFeed\Modules\Post;
defined( 'ABSPATH' ) || exit;
/**
 * Cpt Class.
 * Cpt class for custom post type.
 *
 * @since 1.0.0
 */
Class Cpt extends \NextFeed\Apps\Cpt{

    private static $instance;
   
    public function get_name(){
        return 'nextfeeds';
    }

    public function get_key(){
        return '__next_'.$this->get_name();
    }

    public function _support_posttype(){
        $support = ['post'];
        return apply_filters('_nextfeed_support_posttype', $support);
    }
    // set custom post type options data
    public function post_type()
    {
        $labels = array(
            'name'                  => esc_html_x( 'Templates', 'Post Type General Name', 'next-feed' ),
            'singular_name'         => esc_html_x( 'Template', 'Post Type Singular Name', 'next-feed' ),
            'menu_name'             => esc_html__( 'Template', 'next-feed' ),
            'name_admin_bar'        => esc_html__( 'Template', 'next-feed' ),
            'archives'              => esc_html__( 'Template Archives', 'next-feed' ),
            'attributes'            => esc_html__( 'Template Attributes', 'next-feed' ),
            'parent_item_colon'     => esc_html__( 'Parent Item:', 'next-feed' ),
            'all_items'             => esc_html__( 'Templates', 'next-feed' ),
            'add_new_item'          => esc_html__( 'Add New Template', 'next-feed' ),
            'add_new'               => esc_html__( 'Add New', 'next-feed' ),
            'new_item'              => esc_html__( 'New Template', 'next-feed' ),
            'edit_item'             => esc_html__( 'Edit Template', 'next-feed' ),
            'update_item'           => esc_html__( 'Update Template', 'next-feed' ),
            'view_item'             => esc_html__( 'View Template', 'next-feed' ),
            'view_items'            => esc_html__( 'View Templates', 'next-feed' ),
            'search_items'          => esc_html__( 'Search Templates', 'next-feed' ),
            'not_found'             => esc_html__( 'Not found', 'next-feed' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'next-feed' ),
            'featured_image'        => esc_html__( 'Featured Image', 'next-feed' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'next-feed' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'next-feed' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'next-feed' ),
            'insert_into_item'      => esc_html__( 'Insert into Template', 'next-feed' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this Template', 'next-feed' ),
            'items_list'            => esc_html__( 'Templates list', 'next-feed' ),
            'items_list_navigation' => esc_html__( 'Templates list navigation', 'next-feed' ),
            'filter_items_list'     => esc_html__( 'Filter froms list', 'next-feed' ),
        );
        $rewrite = array(
            'slug'                  => 'nextfeeds',
            'with_front'            => true,
            'pages'                 => false,
            'feeds'                 => false,
        );
        $args = array(
            'label'                 => esc_html__( 'Templates', 'next-feed' ),
            'description'           => esc_html__( 'Feed Template', 'next-feed' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'elementor' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => "nextfeed-menu",
            'menu_icon'             => 'dashicons-text-page',
            'menu_position'         => 5,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'publicly_queryable' => true,
            'rewrite'               => $rewrite,
            'query_var' => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
            'rest_base'             => $this->get_name(),
        );

        return $args;

    }

    // Operation custom post type
    public function __init() {  
       add_action( 'admin_menu', [$this, '_admin_menu']); 
    }

    /**
     * Public function _admin_menu.
     * check for admin menu create
     *
     * @since 1.0.0
     */
    public function _admin_menu(){      
        // My Templates
        add_submenu_page('nextfeed', esc_html__('My Templates', 'next-feed'), esc_html__('My Templates', 'next-feed'), 'manage_options', 'edit.php?post_type=nextfeeds');
    }

    public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}

}