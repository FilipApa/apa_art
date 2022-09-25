<?php $current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );?>

<nav aria-label="breadcrumb">
    <ul>
        <li class="breadcrumb-item">
            <a href="<?php echo home_url(); ?>"> Home /</a>  
        </li>
        <li class="breadcrumb-item" aria-current="page">
            <h1 class="breadcrumb-title">    
                <?php echo esc_html($current_page->name); ?> 
            </h1>
        </li>
    </ul>
</nav> 

