<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php add_theme_support( 'title-tag' ); ?></title>
    <?php wp_head(); ?>
</head>

<body class="bg-light" id="site-body" <?php body_class();  $apa_site_url = get_site_url(); ?> data-website-url="<?php echo $apa_site_url; ?>" >
    <?php 
        if( function_exists('wp_body_open')) {
            wp_body_open();
        }
    ?>
    <div id="page" class="site">
        <header class="container mb-4" role="banner">
            <?php get_template_part('template-parts/header/navigation') ?>
        </header>
        <main id="content" class="container site-content">   
