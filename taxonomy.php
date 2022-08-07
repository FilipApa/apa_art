<?php get_header(); ?>
<?php
$current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
    // Get the page slugs
    $taxonomy = $current_page->taxonomy;
    $tax_term = $current_page->slug;

if(is_tax( $taxonomy )) {
    $args = array(
        'paged' => get_query_var( 'paged', 1),
        'post_type' => 'post',
        'posts_per_page' => 9,
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $tax_term
            ),
        ),
    );
    $query = new WP_Query( $args );

?>
    
    <div class="container">

            <?php // BREADCRUMB TEMPLATE ?>
            <?php get_template_part( './template-parts/breadcrumb/breadcrumb'); ?> 

        <?php 
            $index         = 0;
            $no_of_columns = 3;
            while($query->have_posts()) : $query->the_post(); ?>
            <?php 
            if ( $index % $no_of_columns === 0  ) {
                ?>
                <div class="row">
                <?php }?>

                <div class="post col-lg-4 col-md-6 col-sm-12 d-flex flex-column align-items-center gy-4 py-xl-0 py-xxl-2"> 
                    <?php // CARD TEMPLATE ?>
                    <?php get_template_part( './template-parts/card/card'); ?>        
                </div>
                
            <?php 
            $index ++;
            if ( $index !== 0  && $index % $no_of_columns === 0 ) { ?>
            </div> 
            <?php } endwhile; } else {echo "Nothing to display";} 

           bootstrap_pagination($query, $args );
           wp_reset_postdata();
            ?>
    </div>

<?php get_footer(); ?>
