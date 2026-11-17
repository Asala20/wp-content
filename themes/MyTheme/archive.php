<?php get_header(); ?>

<main class="main-content">
    
    <!-- Blog Banner -->
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url('<?php echo get_theme_file_uri('/images/about-us.avif'); ?>');"></div>
        <div class="page-banner__overlay"></div>
        <div class="page-banner__content">
            <h1 class="page-banner__title">
                <?php
                    the_archive_title();
                ?>
            </h1>
            <p style="color: white; font-size: 1.2rem; margin-top: 10px; font-weight: 300;"><?php the_archive_description()?></p>
        </div>
    </div>

    <!-- Modern Blog Grid Layout -->
    <div class="blog-grid-container">
        
        <div class="blog-grid">
            <?php while(have_posts()) { the_post(); ?>
                
                <article class="blog-card">
                    <!-- Post Image -->
                    <div class="blog-card__image">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail('large');
                            } else { ?>
                                <!-- Fallback image if the post doesn't have one -->
                                <img src="<?php echo get_theme_file_uri('/images/about-us.avif'); ?>" alt="Default News Image">
                            <?php } ?>
                        </a>
                    </div>
                    
                    <!-- Post Content -->
                    <div class="blog-card__content">
                        
                        <div class="blog-card__meta">
                            <span class="meta-date"><i class="fas fa-calendar-alt"></i> <?php the_time('M j, Y'); ?></span>
                            <span class="meta-category"><i class="fas fa-folder-open"></i> <?php echo get_the_category_list(', '); ?></span>
                        </div>
                        
                        <h2 class="blog-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <div class="blog-card__excerpt">
                            <!-- wp_trim_words cuts the text so all cards stay a similar height! -->
                            <?php echo wp_trim_words(get_the_content(), 18); ?>
                        </div>
                        
                        <a class="blog-card__btn" href="<?php the_permalink(); ?>">Read Article <i class="fas fa-arrow-right"></i></a>
                        
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