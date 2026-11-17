<?php get_header(); ?>

<main class="main-content">
    
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url('<?php echo get_theme_file_uri('/images/about-us.avif'); ?>');"></div>
        <div class="page-banner__overlay"></div>
        <div class="page-banner__content">
            <h1 class="page-banner__title">Student Notes</h1>
            <p style="color: white; font-size: 1.2rem; margin-top: 10px; font-weight: 300;">Exclusive academic resources for ITE students.</p>
        </div>
    </div>

    <div class="page-layout-container" style="display: block; max-width: 900px; margin: 0 auto 100px auto;">
        
        <?php 
        // --- PERMISSIONS CHECK ---
        if (is_user_logged_in()) { 
        ?>
            <!-- Access Granted: Show the Notes -->
            <ul style="list-style: none; padding: 0;">
                <?php while(have_posts()) { the_post(); ?>
                    <li style="background: #fff; padding: 25px; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid var(--hover-color);">
                        <h2 style="margin: 0 0 10px 0; font-size: 1.5rem;">
                            <a href="<?php the_permalink(); ?>" style="color: #111; text-decoration: none;"><?php the_title(); ?></a>
                        </h2>
                        <div style="color: #666; font-size: 1rem; margin-bottom: 15px;">
                            <?php echo wp_trim_words(get_the_content(), 20); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn-text" style="color: var(--hover-color); font-weight: bold; text-decoration: none;">Read Note &raquo;</a>
                    </li>
                <?php } ?>
            </ul>
            <div class="pagination"><?php echo paginate_links(); ?></div>

        <?php } else { ?>
            
            <!-- Access Denied: Show Login Prompt -->
            <div style="text-align: center; padding: 60px 20px; background: #fff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <i class="fas fa-lock" style="font-size: 4rem; color: var(--hover-color); margin-bottom: 20px;"></i>
                <h2 style="font-size: 2.5rem; color: #111; margin-bottom: 15px;">Restricted Access</h2>
                <p style="font-size: 1.2rem; color: #666; margin-bottom: 30px;">You must be logged in as a student or professor to view academic notes.</p>
                <a href="<?php echo wp_login_url(); ?>" class="btn-primary">Login to your account</a>
            </div>

        <?php } ?>

    </div>
</main>

<?php get_footer(); ?>