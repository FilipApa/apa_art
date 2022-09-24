<?php
  //ADD STYLES AND SCRYPTS
  function apa_files() {
      // Register styles
      wp_register_style('apa-main-styles', get_template_directory_uri() . '/assets/src/css/style.css', [], filemtime(get_template_directory() . '/assets/src/css/style.css'), 'all');
      
      // Register scrpts
      wp_register_script('apa-main-script',  get_template_directory_uri() . '/assets/src/js/main.js', array( 'jquery' ), filemtime(get_template_directory() . '/assets/src/js/main.js'), true);

      // Enqueue styles
      wp_enqueue_style('apa_fonts', '//fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&family=Overpass:wght@300;400;600;700&display=swap', [], null);
      wp_enqueue_style( 'apa-main-styles' );

      // Enqueue styles
      wp_enqueue_script('apa-font-awesome', '//kit.fontawesome.com/4eef9c4c68.js');
      wp_enqueue_script( 'apa-main-script' );
      
  }
  add_action('wp_enqueue_scripts', 'apa_files');

  //THEME SUPPORT
  function apa_features() {
      add_theme_support('title-tag');
      add_theme_support('post-thumbnails');
      add_image_size('featuredImage', 342, 342, true);
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

//FUNCTIONS FOR FILTERING POSTS BY TAXONOMIES
function filter_by_cat_and_terms( $category, ...$paramatars ) {
  $rest_params = [];

  if($paramatars) {
    foreach( $paramatars as $param ) {
      array_push( $rest_params, $param );
    }
  }

  $page = (array)$rest_params[0];
  $paged = $page[0];
  $years = (array)$rest_params[1];
  $series = (array)$rest_params[2];

  if(!empty( $rest_params)) {
      if ($years && $series) { 
          $args = array(
              'paged' => $paged,
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
            'paged' => $paged,
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
            'paged' => $paged,
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
        'paged' => $paged,
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

function apa_filter_paintings($params) {
  $page = json_decode($params->get_param('page'));
  var_dump($page);
  $year = json_decode($params->get_param('year'));
  $serie = json_decode($params->get_param('serie'));
  $filterdPosts =  filter_by_cat_and_terms( 'paintings', $page, $year, $serie );

  return $filterdPosts;
}

function apa_filter_digital_art($params) {
  $page = json_decode($params->get_param('page'));
  $year = json_decode($params->get_param('year'));
  $serie = json_decode($params->get_param('serie'));
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

    $serie = wp_get_post_terms(  $post_ID, ['serie']);
    if($serie) {
      $serie = $serie[0]->name;
    } else {
      $serie = null;
    }

    $year = wp_get_post_terms(  $post_ID, ['year']);
    if($year) {
      $year = $year[0]->name;
    } else {
      $year = null;
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
      'prevPostIDWP' => $prev_post_id,
      'nextPostIDWP' => $next_post_id,
      'serie' => $serie,
      'year' => $year
    ));
  }
 

  return $data;
  
}

add_action( 'rest_api_init', function() {
  register_rest_route( 'apa/v1', 'filter/paintings', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'apa_filter_paintings'
    ));
    register_rest_route( 'apa/v1', 'filter/digital-art', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => 'apa_filter_digital_art'
      ));
      register_rest_route( 'apa/v1', 'posts/(?P<id>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'apa_get_single_post',
        ) );
});
