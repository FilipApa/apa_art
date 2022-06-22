<?php
  function apa_files() {
      // Register styles
      wp_register_style('apa-main-styles', get_stylesheet_uri(), [], filemtime(get_template_directory() . '/style.css'), 'all');
      wp_register_style('apa-bootsrap', get_template_directory_uri() . '/assets/src/library/bootstrap/css/bootstrap.min.css', [], false, 'all');
      
      // Register scrpts
      wp_register_script('apa-main-script',  get_template_directory_uri() . '/assets/main.js', [], filemtime(get_template_directory() . '/assets/main.js'), true);
      wp_register_script('apa-bootsrap-js', get_template_directory_uri() . '/assets/src/library/bootstrap/js/bootstrap.bundle.min.js', array( 'jquery' ), false, true);

      // Enqueue styles
      wp_enqueue_style( 'apa-bootsrap' );
      wp_enqueue_style( 'apa-main-styles' );

      // Enqueue styles
      wp_enqueue_script( 'apa-bootsrap-js' );
      wp_enqueue_script( 'apa-main-script' );
      
  }
  add_action('wp_enqueue_scripts', 'apa_files');

  function apa_features() {
      add_theme_support('title-tag');
      add_theme_support('post-thumbnails');
      add_image_size('featuredImage', 400, 400, true);
  }
  add_action('after_setup_theme', 'apa_features');
  
  function apa_add_custom_taxonomies() {
      register_taxonomy('year', 'post', array(
        'hierarchical' => true,
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
    }
    add_action( 'init', 'apa_add_custom_taxonomies', 0 );
?>

