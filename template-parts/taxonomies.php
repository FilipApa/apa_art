<?php
    $apa_post_id = get_the_ID(); 
    $apa_taxonomies = wp_get_post_terms( $apa_post_id, ['post_tag', 'year']);

    if( empty( $apa_taxonomies ) || !is_array($apa_taxonomies)) {
    return;
    }

    foreach ($apa_taxonomies as $key => $apa_tax) { ?>
        <a href="<?php echo esc_url(get_term_link($apa_tax))?>">
            <?php echo esc_html( $apa_tax->name ); ?>
        </a>
<?php }?>   

