<p>  
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Filter 
    </button>   
</p>

<div class="collapse " id="collapseExample">
    <div class="card card-body d-flex flex-sm-column  ">
        <div class=" me-4">
            <a class="btn btn-outline-dark mb-2" data-bs-toggle="collapse" href="#collapseYear" role="button" aria-expanded="false" aria-controls="collapseYear">
                Year
            </a>
            
            <div class="collapse" id="collapseYear">
                <div class="card card-body mb-2">
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
                            ]); foreach ( $terms as $term) {?>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input-year" type="checkbox" name="<?php echo esc_html($term->name); ?>" value="<?php echo esc_html($term->name); ?>" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                    <?php echo esc_html($term->name); ?>
                                    </label>
                                </div>
                        <?php }}}?> 
                    </div>
                </div>  
            </div>
        
            <div class="me-4">
            <a class="btn btn-outline-dark mb-2" data-bs-toggle="collapse" href="#collapseSeries" role="button" aria-expanded="false" aria-controls="collapseSeries">
                Series
            </a>
            
            <div class="collapse" id="collapseSeries">
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
                            ]); foreach ( $terms as $term) {?>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input-series" type="checkbox" name="<?php echo esc_html($term->name); ?>" value="<?php echo esc_html($term->name); ?>" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                    <?php echo esc_html($term->name); ?>
                                    </label>
                                </div>
                        <?php }}}?> 
                    </div>
                </div>  
            </div>
            <button class="btn btn-primary" id="filterBtn">Filter</button>
    </div>
</div>