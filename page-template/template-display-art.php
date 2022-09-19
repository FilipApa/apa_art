<?php
/**
* Template Name: Display art posts
*/
?>

<?php get_header(); ?>
<?php
global $current_page;
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
}      
    $category_id = get_cat_ID( $slug );
    $category = get_the_category( $category_id );
    $num_of_posts = $category[0]->category_count;
?>
    <div id="container-category" data-post-category="<?php echo esc_html( $slug ); ?>" data-website-url="<?php echo home_url(); ?>" >
        
        <?php // BREADCRUMB TEMPLATE ?>
        <div class="post-breadcrumb">
            <?php get_template_part( './template-parts/breadcrumb/breadcrumb'); ?>   
            <span>Posts: <strong id="num-posts"><?php echo $num_of_posts; ?></strong></span>
        </div>

        <div class="post-container">
            <div class="post-filter">
                <?php get_template_part( './template-parts/filter/filter'); ?>    
            </div>
            
            <div class="post-wrapper container" id="template-grid-content">
            <?php  // WP LOOP
                while($query->have_posts()) : $query->the_post(); ?>

                <?php // CARD TEMPLATE ?>
                <div class="post">
                    <?php get_template_part( './template-parts/card/card'); ?>    
                </div>    
            <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="btn__wrapper">
        <button class="btn btn__primary" id="post-load-more">Load more</button>
    </div>

    <div class="post-modal" id="post-modal">
        <div class="container post-modal-dialog">
            <div class="post-modal-header">
                <strong class="post-modal-title" id="post-modal-title"></strong>
                <div role="button" class="post-modal-close" id="post-modal-close">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>

            <div class="post-modal-body" id="post-modal-content">
                
            </div>

            <div class="post-modal-footer">
                <div class="post-modal-arrows">
                    <div role="button" class="post-arrow-btn prev" id="post-modal-prev">
                        <i class="fa-solid fa-angle-left"></i>
                    </div>
                    <div role="button" class="post-arrow-btn next" id="post-modal-next">
                        <i class="fa-solid fa-angle-right"></i>
                    </div>
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
