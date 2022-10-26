<?php get_header();    
   ?>
<div class="container">
    <section class="banner">

    </section>

    <section class="art-selection">
        <div class="art-selection-wrap">     
            <div class="art-selection-text">
                <div class="art-selection-text-icon">
                    <img src="<?php echo get_theme_file_uri( './assets/images/paintings.png' ) ?>" alt="Brushes for painting">
                </div>

                <h2>Paintings</h2>
            
                <a class="btn" href="<?php echo site_url( 'category/paintings/' ) ?>">See more</a>
            </div>

            <div class="art-selection-background">
                <picture>
                    <source media="(min-width:720px)" srcset="">
                    <img src="" alt="">
                </picture>
            </div>
        </div>

        <div class="art-selection-wrap flex-reverse">    
            <div class="art-selection-text">
                <div class="art-selection-text-icon">
                    <img src="<?php echo get_theme_file_uri( './assets/images/digital-art.png' ) ?>" alt="Smartfone with app for painting on screen">
                </div>
                
                <h2>Digital art</h2>
            
                <a class="btn" href="<?php echo site_url( 'category/digital-art/' ) ?>">See more</a>
            </div>

            <div class="art-selection-background">
                <picture>
                    <source media="(min-width:720px)" srcset="">
                    <img src="" alt="">
                </picture>
            </div>
        </div>

        <div class="art-selection-wrap">     
            <div class="art-selection-text">
                <div class="art-selection-text-icon">
                    <img src="" alt="">
                </div>

                <h2>3D Animations</h2>
            
                <a class="btn" href="<?php echo site_url( '3d-animations' ) ?>">See more</a>
            </div>

            <div class="art-selection-background">
                <picture>
                    <source media="(min-width:720px)" srcset="">
                    <img src="" alt="">
                </picture>
            </div>
        </div>

        <div class="art-selection-wrap">     
            <div class="art-selection-text">
                <div class="art-selection-text-icon">
                    <img src="" alt="">
                </div>

                <h2>Music</h2>
            
                <a class="btn" href="<?php echo site_url( '3d-animations' ) ?>">See more</a>
            </div>

            <div class="art-selection-background">
                <picture>
                    <source media="(min-width:720px)" srcset="">
                    <img src="" alt="">
                </picture>
            </div>
        </div>
    </section>
</div>
<?php  get_footer(); ?>