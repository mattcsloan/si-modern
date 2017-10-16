<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <title><?php
        if ( is_single() ) { single_post_title(); }
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); get_page_number(); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); get_page_number(); }
    ?> | Company Name | Tagline</title>
 
    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/fonts/icomoon/icomoon.css" />

    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
 
    <?php wp_head(); ?>
 
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'si-modern' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'si-modern' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,700" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>


<body>
	<div class="header">
    	<div class="wrapper">
            <div class="tertiary-nav btn-group">
                <span class="btn btn-subtle btn-small btn-gray">
                    <?php 
                        // $loginout = '<a class="btn btn-subtle btn-small btn-gray">' . wp_loginout($_SERVER['REQUEST_URI'], false ) . '</a>';
                        // echo $loginout;
                        wp_loginout();
                    ?>
                </span>
                <a class="btn btn-green btn-small btn-outline" href="#contact">Contact Us</a>
                <a class="btn btn-gray btn-small btn-icon btn-subtle btn-hover-fill" href="<?php echo get_search_link(); ?>">
                    <i class="icon-search"></i>
                    <span>Search</span>
                </a>
            </div>
            <a href="<?php bloginfo( 'url' ) ?>/">
                <img src="<?php bloginfo('template_directory'); ?>/img/logo.png" width="217" alt="Company Name | Company Tagline">
            </a>
        </div>
    </div>
    <div class="nav">
    	<div class="wrapper">
            <a class="menu-link" href="#">Menu</a>
        	<?php wp_nav_menu( array( 'theme_location' => 'main-navigation', 'depth' => 1 ) ); ?>
        </div>
    </div>
	<!--<?php breadcrumbs(); ?>-->
