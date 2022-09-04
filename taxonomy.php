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
    $num_of_post = $query-> post_count; 
    } ?>
    
    <div id="container" data-post-category="<?php echo esc_html( $slug ); ?>" data-website-url="<?php echo home_url(); ?>" >
        
        <?php // BREADCRUMB TEMPLATE ?>
        <div class="post-breadcrumb">
            <?php get_template_part( './template-parts/breadcrumb/breadcrumb'); ?>  
           <strong>Posts: <?php echo $num_of_post; ?></strong>
        </div>

        <div class="post-container">
         
            <div class="post-wrapper" id="template-grid-content">
            <?php  // WP LOOP
                $index         = 0;
                $no_of_columns = 3;
                while($query->have_posts()) : $query->the_post(); 
                if ( $index % $no_of_columns === 0  ) { ?>
                 <div class="post-row">
                    <?php } ?>
                        
                        <?php // CARD TEMPLATE ?>
                        <div class="post"  >
                            <?php get_template_part( './template-parts/card/card'); ?>    
                        </div>
                <?php 
                $index ++;
                if ( $index !== 0  && $index % $no_of_columns === 0 ) { ?>
                </div> 
                <?php } endwhile; ?>
        </div>

    </div>
    <div class="post-pagination" id="post-pagination">
        <?php 
            // PAGINATION
            the_posts_pagination( array(
                'mid_size' => 2,
                'prev_text' => __( 'Previous Page', 'textdomain' ),
                'next_text' => __( 'Next Page', 'textdomain' ),
                ) );
            wp_reset_postdata();
        ?>
    </div>

    <div class="post-modal" id="post-modal">
        <div class="container post-modal-dialog">
            <div class="post-modal-header">
                <strong class="post-modal-title" id="post-modal-title"></strong>
                <div class="post-modal-close" id="post-modal-close">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>

            <div class="post-modal-body" id="post-modal-content">
                
            </div>

            <div class="post-modal-footer">
                <div class="post-modal-arrows">
                    <a id="post-prev">
                        <i class="fa-solid fa-angle-left"></i>
                    </a>
                    <a id="post-next">
                    <i class="fa-solid fa-angle-right"></i>
                    </a>
                </div>

                <div class="post-category">
                    Serie: <strong id="post-serie"></strong>
                </div>
                <div class="post-category">
                    Year: <strong id="post-year"></strong>
                </div>
            </div>      
        </div>
    </div>                                   

<?php get_footer(); ?>
