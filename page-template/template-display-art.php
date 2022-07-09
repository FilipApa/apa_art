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
        'posts_per_page' => -1,
        'post_type' => 'post',
        'order' => 'ASC',
        'category_name' => $slug
      );

      $query = new WP_Query( $args ); 

?>
    <div class="container">
         <div class="post-navigation mb-4">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo home_url() ?>"> Home </a>  
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo esc_html($current_page->name); ?>
                    </li>
                </ol>
            </nav> 
        </div>
        <div>
            <p>  
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Filter 
                </button>   
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body d-flex flex-sm-column flex-md-row ">
                    <div class="me-4">
                        <h3 class="fs-5">Year</h3>
                        <div>
                            <?php 
                                $args=array(
                                'name'    => 'year',
                                'public'   => true,
                                '_builtin' => false
                                );
                                $output = 'names'; // or objects
                                $operator = 'and';
                                $taxonomies=get_taxonomies($args,$output,$operator); 

                                if  ($taxonomies) {
                                foreach ($taxonomies  as $taxonomy ) {
                                    $terms = get_terms([
                                        'taxonomy' => $taxonomy,
                                        'hide_empty' => false,
                                    ]);
                    
                                        foreach ( $terms as $term) {
                                ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="<?php echo esc_html($term->name); ?>" value="<?php echo esc_html($term->name); ?>" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo esc_html($term->name); ?>
                                            </label>
                                        </div>
                                <?php }}}?> 
                        </div>  
                    </div>
                    
                    <div>
                        <h3 class="fs-5">Series</h3>
                        <div>
                            <?php 
                            $args=array(
                            'name'    => 'serie',
                            'public'   => true,
                            '_builtin' => false
                            );
                            $output = 'names'; 
                            $operator = 'and';
                            $taxonomies=get_taxonomies($args,$output,$operator); 
            
                            if  ($taxonomies) {
                            foreach ($taxonomies  as $taxonomy ) {
                                $terms = get_terms([
                                    'taxonomy' => $taxonomy,
                                    'hide_empty' => false,
                                ]);
                
                                    foreach ( $terms as $term) {
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="<?php echo esc_html($term->name); ?>" value="<?php echo esc_html($term->name); ?>" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                <?php echo esc_html($term->name); ?>
                                </label>
                            </div>
                                
                            <?php }}}?> 
                        </div>
                        
                    </div> 
                </div>
            </div>
        </div>
        <?php 
            $index         = 0;
            $no_of_columns = 3;
            while($query->have_posts()) : $query->the_post(); ?>
            <?php 
            if ( $index % $no_of_columns === 0  ) {
                ?>
                <div class="row" id="template-grid-content">
                <?php } ?>

                    <div class="post col-lg-4 col-md-6 col-sm-12 d-flex flex-column align-items-center gy-4" >
                        <?php get_template_part( './template-parts/card/card'); ?>    
                    </div>
            <?php 
            $index ++;
            if ( $index !== 0  && $index % $no_of_columns === 0 ) { ?>
                </div> 
            <?php } endwhile; } else {echo "NOTHING";} ?>
    </div>

<?php get_footer(); ?>
