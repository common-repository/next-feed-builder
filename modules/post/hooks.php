<?php
namespace NextFeed\Modules\Post;
defined( 'ABSPATH' ) || exit;
Class Hooks{

    public $temp_type;
    public $post_type;
    
    private static $instance;

    public function __init(){
      $this->post_type = Cpt::instance()->get_name();
      
      $this->keys = Cpt::instance()->get_key();

      $this->valid_posttype = Action::instance()->_posttype_valid();

      // check admin init
      add_action( 'admin_init', [ $this, 'add_author_support' ], 10 );
      add_filter( 'manage_'.$this->post_type.'_posts_columns', [ $this, 'set_columns' ] );
      add_action( 'manage_'.$this->post_type.'_posts_custom_column', [ $this, 'render_column' ], 10, 2 );
      
      
      // add meta box for template
      add_action( 'add_meta_boxes', [ $this, '_template_selected' ] );

      // save meta box data
      add_action( 'save_post', array( $this, '_template_save' ), 1, 2  );

      // add filter for search
      add_action( 'restrict_manage_posts', [ $this, 'add_filter'] );
      // query filter
      add_filter( 'parse_query', [ $this, 'query_filter' ] );

    }

 
    public function add_author_support(){
      add_post_type_support( $this->post_type, 'author' );
    }
 
    public function set_columns( $columns ) {

      $date_column = $columns['date'];
      $author_column = $columns['author'];

      unset( $columns['date'] );
      unset( $columns['author'] );
      
      $columns['type'] = esc_html__( 'Type', 'next-feed' );
      $columns['categorie'] = esc_html__( 'Categories', 'next-feed' );
      $columns['set_default'] = esc_html__( 'Default', 'next-feed' );
      $columns['author']      = esc_html( $author_column );
      $columns['date']      = esc_html( $date_column );

      return $columns;
    }

   
    public function render_column( $column, $post_id ) {
     $data = get_post_meta(  $post_id,  $this->keys.'__data',  true );
     $type =  get_post_meta(  $post_id, $this->keys.'__type', true);
     $categories = get_post_meta( $post_id, $this->keys.'__categories', true );

     $default = get_option($this->keys.'_'.$type.'-'.$categories.'__setdefault', true);
     $temp_type = Action::instance()->_temp_type();

      switch ( $column ) {
        case 'type':
          $name_type = isset( $temp_type[$type]['name'] ) ? $temp_type[$type]['name'] : '';
          echo '<span class="nextfeed-type next-'.$type.'"> ';
          echo  $name_type;
          echo '</span>';
        break;

        case 'categorie':
          $name_categories = isset( $temp_type[$type]['categories'][$categories] ) ? $temp_type[$type]['categories'][$categories] : '';
          echo '<span class="nextfeed-categories next-'.$categories.'"> ';
          echo  $name_categories;
          echo '</span>';
         break;

        case 'set_default':
          if( $default == $post_id ){
            echo '<span class="nextfeed-defult nextfeed-active"> '. __('Enable', 'next-feed') .' </span>';
          }else{
            echo '<span class="nextfeed-defult  nextfeed-deactive"> '. __('Disable', 'next-feed') .' </span>';
          }
        break;
      
      }

    }
   
    public function  query_filter( $query ) {
        global $pagenow;
        $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';

        if ( 
            is_admin() 
            && 'nextfeeds' == $current_page 
            && 'edit.php' == $pagenow   
            && isset( $_GET['type'] ) 
            && $_GET['type'] != ''
            && $_GET['type'] != 'all'
        ){
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $query->query_vars['meta_key'] = $this->keys.'__type';
            $query->query_vars['meta_value'] = $type;
            $query->query_vars['meta_compare'] = '=';
        }
    }

   
    public function add_filter(){
        global $typenow;
        global $wp_query;
        if ( $typenow == $this->post_type ) { 
            $current_plugin = '';
            if( isset( $_GET['type'] ) ) {
              $current_plugin = $_GET['type']; 
            } 
            $this->temp_type = Action::instance()->_temp_type();
          ?>
          <select name="type" id="type">
            <option value="all" <?php selected( 'all', $current_plugin ); ?>><?php _e( 'All Type', 'next-feed' ); ?></option>
            <?php 
              if( is_array($this->temp_type) && sizeof($this->temp_type) > 0 ):
              foreach( $this->temp_type as $k=>$v ) { ?>
              <option value="<?php echo esc_attr( $k ); ?>" <?php selected( $k, $current_plugin ); ?>><?php echo esc_attr( $v['name'] ); ?></option>
            <?php }
            endif;
            ?>
          </select>
          <?php
        }
    }

    public function _template_selected(){
      add_meta_box(
          'nextfeed_template',
          esc_html__('Blog Template', 'next-feed'),
          [$this, 'nextfeed_template'],
          'post',
          'side',
          'low'
        );
        
    }
  /**
     * Public function template_save.
     * WpWooBuilder Template save for product 
     *
     * @since 1.0.0
     */
    public function _template_save( $post_id, $post ){
      if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
      }

      if(  in_array($post->post_type, ['post']) ):
        if( isset( $_POST['nextaddons-template'] ) ){
            update_post_meta( $post_id,  $this->keys.'_post__template', sanitize_text_field($_POST['nextaddons-template']) );
        }
      endif;
    }

    /**
     * Public function metwoo_template.
     * WpWooBuilder Template Html
     *
     * @since 1.0.0
     */
    public function nextfeed_template(){
      global $post;

      if(!isset($post->ID) ){
        return '';
      }
      $page_template = get_post_meta(  $post->ID,  $this->keys.'_post__template',  true );

      $template = $this->get_post_single();
      echo '<select name="nextaddons-template">';
      echo '<option value="0"> '.__('Defalut', 'next-feed').' </option>';
      if( is_array($template) && sizeof($template) > 0){
          foreach($template as $k=>$v){
              $select = '';
              if( $page_template == $k){
                $select = 'selected';
              }
            echo '<option value="'.$k.'" '.$select.'> '.__($v, 'next-feed').' </option>';
          }
      }
      echo '</select>';
    }

    // get query post query
    public function get_post_single(){
     
      $args['post_status'] = 	'publish';
      $args['post_type'] = $this->post_type;
      $args['meta_query'] = [
          'relation' => 'AND',
          array(
              'key' => $this->keys.'__type',
              'value' => 'post',
              'compare' => '='
          ),
          array(
            'key' => $this->keys.'__categories',
            'value' => 'single',
            'compare' => '='
        ),
      ];

      $posts = get_posts($args);    
      $options = [];
      $count = count($posts);
      if($count > 0):
          foreach ($posts as $post) {
              $options[$post->ID] = $post->post_title;
          }
      endif;  

      return $options;
  }

  public static function instance(){
    if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
  }
}