<?php $current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );?>

<div>
    <nav class="post-breadcrumb-navigation" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo home_url(); ?>"> Home </a>  
            </li>
            <li class="breadcrumb-item " aria-current="page">
                
                <?php if(is_tax(array('year'))){echo 'Year: ';} else if(is_tax(array('serie'))) {echo 'Serie: ';}?>
                <h1 class="breadcrumb-title">    
                    <?php echo esc_html($current_page->name); ?> 
                </h1>
            </li>
        </ol>
    </nav> 
</div>
