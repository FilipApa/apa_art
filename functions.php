<?php
  //ADD STYLES AND SCRYPTS
  function apa_files() {
      // Register styles
      wp_register_style('apa-main-styles', get_stylesheet_uri(), [], filemtime(get_template_directory() . '/style.css'), 'all');
      wp_register_style('apa-bootsrap', get_template_directory_uri() . '/assets/src/library/bootstrap/css/bootstrap.min.css', [], false, 'all');
      
      // Register scrpts
      wp_register_script('apa-main-script',  get_template_directory_uri() . '/assets/main.js', [], filemtime(get_template_directory() . '/assets/main.js'), true);
      wp_register_script('apa-bootsrap-js', get_template_directory_uri() . '/assets/src/library/bootstrap/js/bootstrap.bundle.min.js', array( 'jquery' ), false, true);

      // Enqueue styles
      wp_enqueue_style('nspangea_fonts', '//fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&family=Overpass:wght@300;400;600;700&display=swap', [], null);
      wp_enqueue_style( 'apa-bootsrap' );
      wp_enqueue_style( 'apa-main-styles' );

      // Enqueue styles
      wp_enqueue_script( 'apa-bootsrap-js' );
      wp_enqueue_script( 'apa-main-script' );
      
  }
  add_action('wp_enqueue_scripts', 'apa_files');

  //THEME SUPPORT
  function apa_features() {
      add_theme_support('title-tag');
      add_theme_support('post-thumbnails');
      add_image_size('featuredImage', 400, 400, true);
  }
  add_action('after_setup_theme', 'apa_features');
  
  //REGISTER CUSTOM TAXONOMY
  function apa_add_custom_taxonomies() {
      register_taxonomy('year', 'post', array(
        'hierarchical' => true,
        'show_in_rest' => true,
        'labels' => array(
          'name' => _x( 'Year', 'taxonomy general name' ),
          'singular_name' => _x( 'Year', 'taxonomy singular name' ),
          'search_items' =>  __( 'Search Years' ),
          'all_items' => __( 'All Years' ),
          'edit_item' => __( 'Edit Year' ),
          'update_item' => __( 'Update Year' ),
          'add_new_item' => __( 'Add New Year' ),
          'new_item_name' => __( 'New Year Name' ),
          'menu_name' => __( 'Years' ),
        ),
        'rewrite' => array(
          'slug' => 'year', 
          'with_front' => false, 
          'hierarchical' => true 
        ),
      ));
      register_taxonomy('serie', 'post', array(
        'hierarchical' => true,
        'show_in_rest' => true,
        'labels' => array(
          'name' => _x( 'Serie', 'taxonomy general name' ),
          'singular_name' => _x( 'Serie', 'taxonomy singular name' ),
          'search_items' =>  __( 'Search Series' ),
          'all_items' => __( 'All Series' ),
          'edit_item' => __( 'Edit Serie' ),
          'update_item' => __( 'Update Serie' ),
          'add_new_item' => __( 'Add New Serie' ),
          'new_item_name' => __( 'New Serie Name' ),
          'menu_name' => __( 'Series' ),
        ),
        'rewrite' => array(
          'slug' => 'serie', 
          'with_front' => false, 
          'hierarchical' => true 
        ),
      ));
    }
    add_action( 'init', 'apa_add_custom_taxonomies', 0 );

    //PAGINATION WITH BOOTSTRAP
    function bootstrap_pagination( $wp_query = false, $echo = true, $args = array() ) {
      //Fallback to $wp_query global variable if no query passed
      if ( false === $wp_query ) {
          global $wp_query;
      }
       
      //Set Defaults
      $defaults = array(
          'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
          'format'       => '?paged=%#%',
          'current'      => max( 1, get_query_var( 'paged' ) ),
          'total'        => $wp_query->max_num_pages,
          'type'         => 'array',
          'show_all'     => false,
          'end_size'     => 2,
          'mid_size'     => 1,
          'prev_text'    => __( 'Prev' ),
          'next_text'    => __( 'Next' ),
          'add_fragment' => '',
      );
       
      //Merge the defaults with passed arguments
      $merged = wp_parse_args( $args, $defaults );
       
      //Get the paginated links
      $lists = paginate_links($merged);
   
      if ( is_array( $lists ) ) {
           
          $html = '<nav class="mt-5"><ul class="pagination justify-content-center">';
   
          foreach ( $lists as $list ) {
              $html .= '<li class="page-item' . (strpos($list, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $list) . '</li>';
          }
   
          $html .= '</ul></nav>';
   
          if ( $echo ) {
              echo $html;
          } else {
              return $html;
          }
      }
       
      return false;
  };

  //REGISTER REST API FIELD
  function filter_by_cat_and_terms( $category, ...$taxonomies ) {
    $terms = [];

    if($taxonomies) {
      foreach( $taxonomies as $tax ) {
        array_push( $terms, $tax );
      }
    }

    $years = (array)$terms[0];
    $series = (array)$terms[1];

    if(!empty( $terms )) {
        if ($years[0] && $series[0]) { 
            $args = array(
                'paged' => get_query_var( 'paged', 1),
                'post_per_page' => 9,
                'post_type' => 'post',
                'order' => 'ASC',
                'category_name' => $category,
                'tax_query' => array(
                    'relation' => 'AND',
                        array(
                            'taxonomy' => 'year', 
                            'field' => 'slug',
                            'terms' => $years 
                        ),
                        array(
                        'taxonomy' => 'serie',
                        'field' => 'slug',
                        'terms' => $series
                        )
                )
            );
        }else if($years[0] || $series[0]) {
          
          if(!empty($years[0])) {
            $args = array(
              'paged' => get_query_var( 'paged', 1),
              'post_per_page' => 9,
              'post_type' => 'post',
              'order' => 'ASC',
              'category_name' => $category,
              'tax_query' => array(
                      array(
                          'taxonomy' => 'year', 
                          'field' => 'slug',
                          'terms' => $years 
                      )
                    )
              );
          } else if(!empty($series[0])) {
            $args = array(
              'paged' => get_query_var( 'paged', 1),
              'post_per_page' => 9,
              'post_type' => 'post',
              'order' => 'ASC',
              'category_name' => $category,
              'tax_query' => array(
                      array(
                          'taxonomy' => 'serie', 
                          'field' => 'slug',
                          'terms' => $series
                      )
                    )
              );
          }
      } else {
        $args = array(
          'paged' => get_query_var( 'paged', 1),
          'post_per_page' => 9,
          'post_type' => 'post',
          'order' => 'ASC',
          'category_name' => $category
        );
      }
    }

    $posts = new WP_Query($args);
    
    $data = [];
    $i = 0;

    foreach($posts->posts as $post) {
      $data[$i]['id'] = $post->ID;
      $data[$i]['title'] = $post->post_title;
      $data[$i]['link'] = $post->guid;
     
      $apa_taxonomies = wp_get_post_terms( $post->ID, [ 'year', 'serie']);

      foreach ($apa_taxonomies as $key => $apa_tax) {
        $data[$i][ $apa_tax->name ] =  $apa_tax->name; 
      }
      $i++;
    }

    var_dump($data);

    return $data;
    
}
  function apa_post_by_paintings($params) {
    $year = json_decode($params->get_param('year'));
    $serie = json_decode($params->get_param('serie'));

    filter_by_cat_and_terms( 'paintings', $year, $serie );
  }

  function apa_post_by_digital_art($params) {
    $year = json_decode($params->get_param('year'));
    $serie = json_decode($params->get_param('serie'));

    filter_by_cat_and_terms( 'digital-art', $year, $serie );
  }

  add_action( 'rest_api_init', function() {
    register_rest_route( 'apa/v1', 'posts/paintings', array(
      'methods' => 'GET',
      'callback' => 'apa_post_by_paintings',
      ) );
      register_rest_route( 'apa/v1', 'posts/digital-art', array(
        'methods' => 'GET',
        'callback' => 'apa_post_by_digital_art',
        ) );
  })
?>

