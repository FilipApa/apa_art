<?php
/**
* Template Name: Display art posts
*/
?>

<?php get_header(); ?>
<?php
$current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
    // Get the page slugs
    $slug = $current_page->slug;

if ($slug) {
    echo 'cat';
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'post',
        'order' => 'ASC',
        'category_name' => $slug
      );

      $query = new WP_Query( $args ); 

?>

    <div class="container">
        <?php 
            $index         = 0;
            $no_of_columns = 3;
            while($query->have_posts()) : $query->the_post(); ?>
            <?php 
            $apa_post_id = get_the_ID();

            if ( $index % $no_of_columns === 0  ) {
                ?>
                <div class="row " >
                <?php
                    }?>
                    <div class="post col-lg-4 col-md-6 col-sm-12 d-flex flex-column align-items-center gy-4"  data-post-id="<?php echo $apa_post_id; ?>">
                    <div class="card">
                        <div class="card-img-top" >
                            <a href="<?php the_permalink(); ?>">
                                <?php 
                                    if ( has_post_thumbnail( $apa_post_id ) ) {?>
                                        <?php echo get_the_post_thumbnail( $apa_post_id, 'featuredImage', array('class' => 'img-fluid') ); ?>
                                    <?php }
                                ?>
                            </a>
                        </div>
                        <div class="card-body d-flex justify-content-between">
                            <h3 class="card-title">
                                <?php the_title(); ?>
                            </h3>
                            <div>
                                <?php 
                                    $apa_taxonomies = wp_get_post_terms( $apa_post_id, ['post_tag', 'year']);

                                    if( empty( $apa_taxonomies ) || !is_array($apa_taxonomies)) {
                                    return;
                                    }
                
                                    foreach ($apa_taxonomies as $key => $apa_tax) { ?>
                                        <a class="btn btn-outline-primary" href="<?php echo esc_url(get_term_link($apa_tax))?>">
                                            <?php echo esc_html( $apa_tax->name ); ?>
                                        </a>
                                <?php }?> 
                            </div>
                        </div>
                    </div>        
                  
                    </div>
                    <?php 
                    $index ++;
                    if ( $index !== 0  && $index % $no_of_columns === 0 ) { ?>
                        </div> 
                    <?php } endwhile; } else {echo "NOTHING";} ?>
</div>

<?php get_footer(); ?>
