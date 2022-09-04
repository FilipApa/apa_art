<div class="filter-btn">  
    <button class="" type="button" data-bs-toggle="" data-bs-target="" aria-expanded="" aria-controls="">
        Filter
    </button>   
</div>

<div class="">
    <div class="">
        <div class="">
            <a class="" role="button" aria-expanded="false" aria-controls="collapseYear">
                Year
            </a>

            <div class="" id="collapseYear">
                <div class="">
                    <?php 
                        $args=array(
                        'name'    => 'year',
                        'public'   => true,
                        '_builtin' => false,
                        );
                        $current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
                        // Get the page slug
                        $slug = $current_page->slug;

                        $output = 'names'; // or objects
                        $operator = 'and';
                        $taxonomies=get_taxonomies($args,$output,$operator); 

                        if  ($taxonomies) {
                        foreach ($taxonomies  as $taxonomy ) {
                            $terms = get_terms([
                                'taxonomy' => $taxonomy,
                                'hide_empty' => false,
                            ]); foreach ( $terms as $term) {?>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input-year" type="checkbox" name="<?php echo esc_html($term->name); ?>" value="<?php echo esc_html($term->name); ?>" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        <?php echo esc_html($term->name); ?> 
                                        <span class="ms-1 text-secondary">
                                        <?php echo '(' . calc_num_of_posts($slug, 'year', $term->name) . ')'; ?>
                                    </span>
                                    </label>
                                </div>
                        <?php }}}?> 
                    </div>
                </div>  
            </div>
        
            <div class="">
            <a class=""  role="button" aria-expanded="false" aria-controls="">
                Series
            </a>
            
            <div class="" id="">
                <div class="card card-body mb-2">
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
                            ]); foreach ( $terms as $term) { ?>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input-series" type="checkbox" name="<?php echo esc_html($term->name); ?>" value="<?php echo esc_html($term->slug); ?>" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                    <?php echo esc_html($term->name); ?>
                                    <span class="ms-1 text-secondary">
                                        <?php echo '(' . calc_num_of_posts($slug, 'serie', $term->name) . ')'; ?>
                                    </span>
                                    </label>
                                </div>
                        <?php }}}?> 
                    </div>
                </div>  
            </div>
            <button class="" id="filterBtn">Filter</button>
    </div>
</div>
