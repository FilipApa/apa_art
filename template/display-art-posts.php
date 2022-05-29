<?php
/**
* Template Name: Display art posts
*/
?>

<?php get_header(); ?>
<main> 

<?php
    $current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
    // Get the page slug
    $slug = $current_page->post_name;

    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'post',
        'meta_key' => 'photo_year',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'category_name' => $slug
      );
      $loop_by_category = new WP_Query( $args );
      
      while ( $loop_by_category->have_posts() ) {
        $loop_by_category->the_post(); ?>
      <div>

            <h2><?php the_title(); ?></h2>  
            <?php
                $apa_post_id = get_the_ID(); 
                $apa_taxonomies = wp_get_post_terms( $apa_post_id, ['post_tag', 'year']);
      
                if( empty( $apa_taxonomies ) || !is_array($apa_taxonomies)) {
                  return;
                }
           
                foreach ($apa_taxonomies as $key => $apa_tax) { ?>

                  <a href="<?php echo esc_url(get_term_link($apa_tax))?>">
                    <?php echo esc_html( $apa_tax->name ); ?>
                  </a>

              <?php }}?>
        </div>   

</main>
<?php get_footer(); ?>


