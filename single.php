<?php get_header(); ?>
<div class="container">
    <?php 
        while(have_posts()) {
            the_post();?>
            <div class="post-navigation">
                <?php 
                $category = get_the_category(); 
                if($category) { $cat_id = $category["0"]->term_id;}
               
                ?>  
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo home_url() ?>"> Home  </a>  
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo get_category_link( $cat_id ); ?>"> 
                                <?php echo $category["0"]->cat_name; ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                    </ol>
                </nav>   
            </div>
            <div class="post-wrapper">
                <div class="post-image">
                    <?php the_content(); ?>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <?php previous_post_link('%link', '<button type="button" class="btn btn-primary">PREV</button>', true );?>
                    <?php next_post_link('%link', '<button type="button" class="btn btn-primary">NEXT</button>', true );?>
                </div>
            </div>
        
        <?php } ?>
</div>
<?php get_footer(); ?>