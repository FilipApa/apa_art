<?php
  //ADD STYLES AND SCRYPTS
  function apa_files() {
      // Register styles
      wp_register_style('apa-main-styles', get_template_directory_uri() . '/assets/src/css/style.css', [], filemtime(get_template_directory() . '/assets/src/css/style.css'), 'all');
      wp_register_style('apa-bootsrap', get_template_directory_uri() . '/assets/src/library/bootstrap/css/bootstrap.min.css', [], false, 'all');
      
      // Register scrpts
      wp_register_script('apa-main-script',  get_template_directory_uri() . '/assets/src/js/main.js', [], filemtime(get_template_directory() . '/assets/src/js/main.js'), true);
      wp_register_script('apa-bootsrap-js', get_template_directory_uri() . '/assets/src/library/bootstrap/js/bootstrap.bundle.min.js', array( 'jquery' ), false, true);

      // Enqueue styles
      wp_enqueue_style('nspangea_fonts', '//fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&family=Overpass:wght@300;400;600;700&display=swap', [], null);
      wp_enqueue_style( 'apa-bootsrap' );
      wp_enqueue_style( 'apa-main-styles' );

      // Enqueue styles
      wp_enqueue_script('apa-font-awesome', '//kit.fontawesome.com/4eef9c4c68.js');
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

  //CALCULITE NUMBER OF POSTS WITH SAME CATEGORY AND TAXONOMY
  function calc_num_of_posts($category, $tax, $term) {
    $args = array(
      'paged' => get_query_var( 'paged', 1),
      'post_per_page' => 9,
      'post_type' => 'post',
      'order' => 'ASC',
      'category_name' => $category,
      'tax_query' => array(
          'relation' => 'AND',
              array(
                  'taxonomy' => $tax, 
                  'field' => 'slug',
                  'terms' => $term 
              )
            )
          );

      $data = new WP_Query($args);
      
      $num_of_post = $data-> post_count;
      return $num_of_post; 
  }  

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

//FUNCTIONS FOR FILTERING POSTS BY TAXONOMIES
function filter_by_cat_and_terms( $category, ...$paramatars ) {
  $rest_params = [];

  if($paramatars) {
    foreach( $paramatars as $param ) {
      array_push( $rest_params, $param );
    }
  }

  $page = (array)$rest_params[0];
  $years = (array)$rest_params[1];
  $series = (array)$rest_params[2];
  

  if(!empty( $rest_params)) {
      if ($years && $series) { 
          $args = array(
              'paged' => $page,
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
      }else if($years || $series) {
        
        if(!empty($years)) {
          $args = array(
            'paged' => $page,
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
        } else if(!empty($series)) {
          $args = array(
            'paged' => $page,
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
  
  $data = array(
    "postData" => array()
  );
  $data['pages'] = $posts->max_num_pages;
  $data['total'] = $posts->found_posts;
  

  while($posts->have_posts()) {
    $posts->the_post();
    $id = get_the_ID();
    $year = wp_get_post_terms( $id, 'year');
    $serie = wp_get_post_terms( $id, 'serie');

    $post_data = array(
      'id' => $id,
      'title' => get_the_title(),
      'link' => get_the_permalink(),
      'year' => $year ? $year[0]->name : null,
      'serie' => $serie ? $serie[0]->name : null,
      'thumbnail' => get_the_post_thumbnail( $id, 'featuredImage', array('class' => 'img-fluid') ),
    );

    array_push($data['postData'], $post_data );
  } 
  wp_reset_query();

  return $data;
}

function apa_post_by_paintings($params) {
  $year = json_decode($params->get_param('year'));
  $serie = json_decode($params->get_param('serie'));
  $page = $params['page'];
  $filterdPosts =  filter_by_cat_and_terms( 'paintings', $page, $year, $serie );

  return $filterdPosts;
}

function apa_post_by_digital_art($params) {
  $year = json_decode($params->get_param('year'));
  $serie = json_decode($params->get_param('serie'));
  $page = $params['page'];
  $filterdPosts =  filter_by_cat_and_terms( 'digital-art', $page, $year, $serie );

  return $filterdPosts;
}

//FUNCTIONS FOR FETCHING SINGLE POST

//REGISTER REST API ENDPOINT
function apa_get_single_post($id) {
  $args = [
		'p' => $id['id'],
		'post_type' => 'post'
	];

  $post = new WP_Query($args);
  
  $data = array();

  while($post->have_posts()) { 
    $post->the_post();

    $post_ID = get_the_ID();

    $category = get_the_category(); 
    $cat_id;
    if( $category ) { $cat_id = $category["0"]->term_id;}

    $taxonomies = wp_get_post_terms(  $post_ID, [ 'year', 'serie']);
    $post_tax = array();
    if($taxonomies) {
      foreach($taxonomies as $key => $tax) {
        array_push($post_tax, array(
          'taxName' => $tax->name,
          'taxLink' => get_term_link($tax)
        ));
      }
    }

    $prev_post = get_adjacent_post( false, '', true) ;
    $prev_post_id = null;
    if( !empty( $prev_post )) {
      $prev_post_id = $prev_post->ID;
    }

    $next_post = get_adjacent_post( false, '', false );
    $next_post_id = null;
    if( !empty( $next_post )) {
      $next_post_id = $next_post->ID;

    }

    array_push($data, array(
      'id' =>  $post_ID,
      'title' => get_the_title(),
      'content' => get_the_content(),
      'categoryLink' => get_category_link( $cat_id ),
      'categoryName' => $category["0"]->cat_name,
      'prevPostID' => $prev_post_id,
      'nextPostID' => $next_post_id,
      'taxonomies' => $post_tax
    ));
  }
 

  return $data;
  
}

add_action( 'rest_api_init', function() {
  register_rest_route( 'apa/v1', 'posts/paintings/(?P<page>[1-9]{1,2})', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'apa_post_by_paintings',
    'args' => array(
      'page' => array (
          'required' => true
        ) 
      )
    ));
    register_rest_route( 'apa/v1', 'posts/digital-art/(?P<page>[1-9]{1,2})', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => 'apa_post_by_digital_art',
      'args' => array(
        'page' => array (
            'required' => true
          ) 
        )
      ));
      register_rest_route( 'apa/v1', 'posts/(?P<id>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'apa_get_single_post',
        ) );

})
?>

