<?php $current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );?>

<nav class="post-breadcrumb-navigation" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo home_url(); ?>"> Home </a>  
        </li>
        <li class="breadcrumb-item" aria-current="page">
            
            <?php if(is_tax(array('year'))){echo 'Year: ';} else if(is_tax(array('serie'))) {echo 'Serie: ';}?>
            <h1 class="breadcrumb-title">    
                <?php echo esc_html($current_page->name); ?> 
            </h1>
        </li>
    </ol>
</nav> 

