<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php wp_head(); ?>
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            
            <!-- A. Logo -->
            <a href="<?php echo site_url(); ?>" class="site-logo">
                <i class="fas fa-graduation-cap logo-icon"></i>
                <span class="logo-text">ELITE<span class="logo-dot">.</span></span>
            </a>

            <!-- B. Navigation Menu (University Links) -->
            <nav class="main-navigation">
                <ul>
                    <!-- Home -->
                    <li class="<?php if (is_front_page()) echo 'current-menu-item'; ?>">
                        <a href="<?php echo site_url(); ?>">Home</a>
                    </li>
                    
                    <!-- About -->
                    <li class="<?php 
                        $aboutPage = get_page_by_path('about-us');
                        $aboutID = $aboutPage ? $aboutPage->ID : 0;
                        if (is_page('about-us') || wp_get_post_parent_id(0) == $aboutID) echo 'current-menu-item'; 
                    ?>">
                        <a href="<?php echo site_url('/about-us'); ?>">About</a>
                    </li>
                    
                    <!-- Events -->
                    <li class="<?php if (get_post_type() == 'event' || is_page('past-events')) echo 'current-menu-item'; ?>">
                        <a href="<?php echo get_post_type_archive_link('event'); ?>">Events</a>
                    </li>

                    <!-- Projects -->
                    <li class="<?php if (get_post_type() == 'project') echo 'current-menu-item'; ?>">
                        <a href="<?php echo get_post_type_archive_link('project'); ?>">Projects</a>
                    </li>

                    <!-- Professors -->
                    <li class="<?php if (get_post_type() == 'professor') echo 'current-menu-item'; ?>">
                        <a href="<?php echo get_post_type_archive_link('professor'); ?>">Professors</a>
                    </li>

                    <!-- Blog (Strict Logic Fix!) -->
                    <li class="<?php if (is_home() || is_singular('post')) echo 'current-menu-item'; ?>">
                        <a href="<?php echo site_url('/blog'); ?>">Blog</a>
                    </li>
                </ul>
                
                <?php
                    // wp_nav_menu( array(
                    //     'theme_location'=> 'headerMenuLocation'
                    // ) );
                ?>
            </nav>

<!-- C. Header Tools (Search + Auth Buttons) -->
            <div class="header-tools">
                <i class="fas fa-search js-search-trigger" aria-hidden="true" title="Search"></i>
                <div class="auth-buttons">
                    <?php if(is_user_logged_in()) { ?>
                        <!-- If User is Logged In -->
                        <a href="<?php echo wp_logout_url(); ?>" class="auth-btn btn-login">Log Out</a>
                    <?php } else { ?>
                        <!-- If User is a Guest -->
                        <a href="<?php echo wp_login_url(); ?>" class="auth-btn btn-login">Login</a>
                        <a href="<?php echo wp_registration_url(); ?>" class="auth-btn btn-register">Register</a>
                    <?php } ?>
                </div>
            </div>

        </div>
    </header>