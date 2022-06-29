<div class="card">
    <div class="card-img-top" >
        <a href="<?php the_permalink(); ?>">
            <?php 
                $apa_post_id = get_the_ID();
                if ( has_post_thumbnail( $apa_post_id ) ) {?>
                    <?php echo get_the_post_thumbnail( $apa_post_id, 'featuredImage', array('class' => 'img-fluid') ); ?>
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
                $apa_taxonomies = wp_get_post_terms( $apa_post_id, ['post_tag', 'year']);

                if( empty( $apa_taxonomies ) || !is_array($apa_taxonomies)) {
                return;
                }

                foreach ($apa_taxonomies as $key => $apa_tax) { ?>
                    <a class="btn btn-outline-primary" href="<?php echo esc_url(get_term_link($apa_tax))?>">
                        <?php echo esc_html( $apa_tax->name ); ?>
                    </a>
            <?php }?> 
        </div>
    </div>
</div>    