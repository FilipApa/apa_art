<div class="filter-btn" id="filter-section" role="button">  
        Filter
</div>

<div class="filter-dropdown">
    <div class="">
            <div class="filter-btn" id="filter-year" role="button" >
                Year
            </div>

            <ul class="filter-dropdown">
                <?php 
                    $args=array(
                    'name'    => 'year',
                    'public'   => true,
                    '_builtin' => false,
                    );
                    // Get the page slug
                    $slug = $GLOBALS['current_page']->slug;

                    $output = 'names'; 
                    $operator = 'and';
                    $taxonomies=get_taxonomies($args,$output,$operator); 

                    if  ($taxonomies) {
                    foreach ($taxonomies  as $taxonomy ) {
                        $terms = get_terms([
                            'taxonomy' => $taxonomy,
                            'hide_empty' => false,
                        ]); foreach ( $terms as $term) {?>
                            <li class="form-check">
                                <input class="form-check-input form-check-input-year" type="checkbox" name="<?php echo esc_html($term->name); ?>" value="<?php echo esc_html($term->name); ?>" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <?php echo esc_html($term->name); ?> 
                                    <span class="">
                                    <?php echo '(' . calc_num_of_posts($slug, 'year', $term->name) . ')'; ?>
                                </span>
                                </label>
                        </li>
                    <?php }}}?> 
                </ul>  
            </div>
        
            <div class="">
                <div class="filter-btn" id="filter-series" role="button" >
                    Series
                </div>
                
                <ul class="filter-dropdown">    
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
                            <li class="form-check">
                                <input class="form-check-input form-check-input-series" type="checkbox" name="<?php echo esc_html($term->name); ?>" value="<?php echo esc_html($term->slug); ?>" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                <?php echo esc_html($term->name); ?>
                                <span class="ms-1 text-secondary">
                                    <?php echo '(' . calc_num_of_posts($slug, 'serie', $term->name) . ')'; ?>
                                </span>
                                </label>
                            </li>
                    <?php }}}?> 
                </ul>  
            </div>
            <button class="" id="filterBtn">Filter</button>
    </div>
</div>
