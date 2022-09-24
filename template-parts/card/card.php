<div class="card" >
    <?php 
        // Get the page slug
        $curr_slug = $GLOBALS['current_page']->slug;
    ?>
    
    <div class="card-img-top" data-post-id="<?php echo get_the_ID( )?>" id="post" >

        <?php     
            if ( has_post_thumbnail( $id ) ) {?>
                <?php echo get_the_post_thumbnail( $id, 'featuredImage' ); ?>
            <?php }
        ?>
     
    </div>

    <div>
        <div class="card-body">
            <h2 class="card-title">
                <?php the_title(); ?>
            </h2>
            <div>
                <?php 
                $apa_taxonomies = wp_get_post_terms( $id, [ 'year', 'serie']);

                if( empty( $apa_taxonomies ) || !is_array($apa_taxonomies)) {
                return;
                }

                foreach ($apa_taxonomies as $key => $apa_tax) {?>
                    <span class="">
                        <?php echo esc_html( $apa_tax->name ); ?>
                    </span>
                <?php }?> 
                <?php 
                if(is_tax( )) {
                    $category = get_the_category( $id );
                    ?> 
                    <span class="">
                        <?php echo esc_html( $category[0] -> name); ?>
                    </span> 
                <?php } ?> 
            </div>
        </div>
    </div>
</div>    