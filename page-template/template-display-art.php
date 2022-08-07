<?php
/**
* Template Name: Display art posts
*/
?>


<?php get_header(); ?>
<?php
$current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
// Get the page slug
$slug = $current_page->slug;

if ($slug) {
    $args = array(
        'paged' => get_query_var( 'paged', 1),
        'post_per_page' => 9,
        'post_type' => 'post',
        'order' => 'ASC',
        'category_name' => $slug
      );
      

      $query = new WP_Query( $args ); 

?>
    <div class="container" id="container" data-post-category="<?php echo esc_html( $slug ); ?>" data-website-url="<?php echo home_url(); ?>" >
        <?php // BREADCRUMB TEMPLATE ?>
        <div>
            <?php get_template_part( './template-parts/breadcrumb/breadcrumb'); ?>   
        </div>

        <?php // FILTER TEMPLATE ?>

        <div>
            <?php get_template_part( './template-parts/filter/filter'); ?>   
        </div>

        <?php  // WP LOOP

            $index         = 0;
            $no_of_columns = 3;
            while($query->have_posts()) : $query->the_post(); ?>
            <?php 
            if ( $index % $no_of_columns === 0  ) {
                ?>
                <div class="row " id="template-grid-content" >
                <?php } ?>
                    
                    <?php // CARD TEMPLATE ?>

                    <div class="post col-lg-4 col-md-6 col-sm-12 d-flex flex-column align-items-center gy-4 py-xl-0 py-xxl-2" >
                        <?php get_template_part( './template-parts/card/card'); ?>    
                    </div>
            <?php 
            $index ++;
            if ( $index !== 0  && $index % $no_of_columns === 0 ) { ?>
                </div> 
            <?php } endwhile; } else { echo "<h1 class='text-center'>Nothing to display</h1>";} 

            // PAGINATION
            bootstrap_pagination( $query, $args );
            wp_reset_postdata();
            ?>
    </div>

<?php get_footer(); ?>
