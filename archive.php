<?php get_header(); ?>
Archive
<?php 
    while(have_posts()) {
        the_post();
        the_title();
       
    }
?>
<?php  get_footer(); ?>