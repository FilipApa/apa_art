<?php get_header(); ?>

<div>
    <div class="post-navigation">
        
        <?php // BREADCRUMB TEMPLATE ?>
        <?php get_template_part( './template-parts/breadcrumb/breadcrumb'); ?>   
        
    </div>
    <?php 
        $index         = 0;
        $no_of_columns = 3;
        while(have_posts()) : the_post(); 

        if ( $index % $no_of_columns === 0  ) { ?>
            <div class="row"> <?php } ?>
                <div class="post col-lg-4 col-md-6 col-sm-12 d-flex flex-column align-items-center gy-4">

                    <?php // CARD TEMPLATE ?>
                    <?php get_template_part( './template-parts/card/card'); ?> 

                </div>
                <?php 
            $index ++;
            if ( $index !== 0  && $index % $no_of_columns === 0 ) { ?>
            </div> 
            <?php } endwhile; else {echo "<h1 class='text-center'>Nothing to display</h1>";}
               echo paginate_links(); 
            ?> 
</div>
<?php  get_footer(); ?>