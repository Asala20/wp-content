<?php get_header(); ?>

<main class="main-content">
    
    <!-- Professors Banner -->
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url('<?php echo get_theme_file_uri('/images/about-us.avif'); ?>');"></div>
        <div class="page-banner__overlay"></div>
        <div class="page-banner__content">
            <h1 class="page-banner__title">Our Professors</h1>
            <p style="color: white; font-size: 1.2rem; margin-top: 10px; font-weight: 300;">Meet the brilliant minds shaping the future of ITE.</p>
        </div>
    </div>

    <!-- Faculty Directory Grid -->
    <div class="professor-grid-container">
        
        <div class="professor-grid">
            <?php 
            while(have_posts()) { 
                the_post(); 
            ?>
                
                <article class="professor-card">
                    <!-- Circular Headshot -->
                    <div class="professor-card__image">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) {
                                // 'medium' is usually perfect for profile pictures
                                the_post_thumbnail('medium');
                            } else { ?>
                                <img src="<?php echo get_theme_file_uri('/images/about-us.avif'); ?>" alt="Default Headshot">
                            <?php } ?>
                        </a>
                    </div>
                    
                    <!-- Professor Info -->
                    <div class="professor-card__content">
                        <h2 class="professor-card__name">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <div class="professor-card__excerpt">
                            <?php echo wp_trim_words(get_the_content(), 12); ?>
                        </div>
                        
                        <a class="btn-text" href="<?php the_permalink(); ?>">View Profile &raquo;</a>
                    </div>
                </article>

            <?php } ?>
        </div>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php echo paginate_links(); ?>
        </div>

    </div>

</main>

<?php get_footer(); ?>