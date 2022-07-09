<div class="card">
    <div class="card-img-top" >
        <a href="<?php the_permalink(); ?>">
            <?php     
                if ( has_post_thumbnail( $id ) ) {?>
                    <?php echo get_the_post_thumbnail( $id, 'featuredImage', array('class' => 'img-fluid') ); ?>
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
                $apa_taxonomies = wp_get_post_terms( $id, [ 'year', 'serie']);

                if( empty( $apa_taxonomies ) || !is_array($apa_taxonomies)) {
                return;
                }

                foreach ($apa_taxonomies as $key => $apa_tax) { ?>
                    <a class="btn btn-outline-primary" href="<?php echo esc_url(get_term_link($apa_tax))?>">
                        <?php echo esc_html( $apa_tax->name ); ?>
                    </a>
            <?php }?> 
             <?php 
             if(is_tax( )) {
                $category = get_the_category( $id );
                $category_slug = $category[0] -> slug;
                $category_url =  get_home_url() . '/category' . '/' . $category_slug;
                ?> 
                <a class="" href="<?php echo esc_url($category_url)?>">
                    <?php echo esc_html( $category[0] -> name); ?>
                </a> 
                <?php } ?>            
        </div>
    </div>
</div>    