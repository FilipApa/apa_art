<div class="container">
    <?php 
        while(have_posts()) {
            the_post();?>
            <div class="post-navigation">
                <?php the_title(); ?>
            </div>
            <div class="post-wrapper">
                <div class="post-image">

                </div>
            </div>
            
           
        <?php}
    ?>
</div>