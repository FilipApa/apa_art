<?php get_header(); ?>

    <div id="container" data-post-category="<?php echo esc_html( $slug ); ?>" data-website-url="<?php echo home_url(); ?>" >
        
        <?php // BREADCRUMB TEMPLATE ?>
        <div class="post-breadcrumb">
            <?php get_template_part( './template-parts/breadcrumb/breadcrumb'); ?>   
        </div>

        <div class="post-container">
            
            <div class="post-wrapper" id="template-grid-content">
            <?php  // WP LOOP
               $index         = 0;
               $no_of_columns = 3;
               while($query->have_posts()) : $query->the_post();
               if ( $index % $no_of_columns === 0  ) { ?> 
                  <div class="post-row"> <?php } ?>
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

    <div class="modal-dialog fade modal-xl" id="post-modal"></div>

<?php get_footer(); ?>
