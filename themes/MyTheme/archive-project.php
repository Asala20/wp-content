<?php get_header(); ?>

<main class="main-content">
    
    <!-- Projects Banner -->
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url('<?php echo get_theme_file_uri('/images/about-us.avif'); ?>');"></div>
        <div class="page-banner__overlay"></div>
        <div class="page-banner__content">
            <h1 class="page-banner__title">ITE Student Projects</h1>
            <p style="color: white; font-size: 1.2rem; margin-top: 10px; font-weight: 300;">Discover the innovative solutions built by our Engineering students.</p>
        </div>
    </div>

    <!-- Modern Tech Portfolio Layout -->
    <div class="portfolio-container">
        
    <!-- Modern Tech Portfolio Layout (1-Column Alternating) -->
    <div class="portfolio-container">
        
        <div class="project-portfolio-list">
            <?php 
            while(have_posts()) { 
                the_post(); 
            ?>
                
                <article class="portfolio-item">
                    <!-- Massive Project Image with Hover Overlay -->
                    <a href="<?php the_permalink(); ?>" class="portfolio-item__image-wrapper">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('large');
                        } else { ?>
                            <img src="<?php echo get_theme_file_uri('/images/about-us.avif'); ?>" alt="Project Screenshot">
                        <?php } ?>
                        
                        <!-- The Red Glass Overlay that appears on hover -->
                        <div class="portfolio-item__overlay">
                            <span class="overlay-text">Explore Project <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </a>
                    
                    <!-- Clean Text on the Side -->
                    <div class="portfolio-item__info">
                        <h2 class="portfolio-item__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <div class="portfolio-item__excerpt">
                            <?php echo wp_trim_words(get_the_content(), 25); ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="btn-primary" style="margin-top: 25px; display: inline-block;">View Case Study</a>
                    </div>
                </article>

            <?php } ?>
        </div>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php echo paginate_links(); ?>
        </div>

    </div>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php echo paginate_links(); ?>
        </div>

    </div>

</main>

<?php get_footer(); ?>