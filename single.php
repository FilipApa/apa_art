<div class="container">
    <?php 
        while(have_posts()) {
            the_post();?>
            <div class="post-navigation">
                <?php 
                $category = get_the_category(); 
                $cat_id = $category["0"]->term_id;
                ?>  
                <a href="<?php echo home_url() ?>"> Home | </a>   
                <a href="<?php echo get_category_link( $cat_id ); ?>"> 
                    <?php echo $category["0"]->cat_name . '|'; ?>
                </a>
                <span>
                    <?php the_title(); ?>
                </span>
                
            </div>
            <div class="post-wrapper">
                <div class="post-image">
                    <?php the_content(); ?>
                </div>

                <div>
                    <?php previous_post_link( '%link', 'Prev post in category', true );
                    next_post_link( '%link', 'Next post in category', true );?>
             

                </div>
            </div>
        
        <?php } ?>
</div>