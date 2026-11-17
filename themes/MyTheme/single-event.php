<?php get_header(); ?>

<main class="main-content">

    <?php while(have_posts()): the_post(); ?>
        
        <!-- Event Banner -->
        <div class="page-banner">
            <?php 
                // Uses the event's Featured Image, or falls back to your AVIF image
                $bannerImage = get_theme_file_uri('/images/about-us.avif');
                if (has_post_thumbnail()) {
                    $bannerImage = get_the_post_thumbnail_url();
                }
            ?>
            <div class="page-banner__bg-image" style="background-image: url('<?php echo $bannerImage; ?>');"></div>
            <div class="page-banner__overlay"></div>
            <div class="page-banner__content">
                <h1 class="page-banner__title"><?php the_title(); ?></h1>
            </div>
        </div>

        <!-- Event Content Container -->
        <div class="page-layout-container" style="display: block;">
            
            <!-- Meta Information & Breadcrumb -->
            <div class="post-meta-box">
                <!-- Back Button -->
                <a class="back-to-blog" href="<?php echo get_post_type_archive_link('event'); ?>">
                    <i class="fas fa-arrow-left"></i> Back to Events
                </a>
                
                <!-- Event Date from ACF -->
                <span class="meta-details">
                    <i class="fas fa-calendar-alt"></i> Event Date: 
                    <strong style="color: #111;">
                        <?php 
                            // Grab the raw ACF date safely and format it nicely
                            $eventDate = new DateTime(get_field('event_date', false, false));
                            echo $eventDate->format('F j, Y'); 
                        ?>
                    </strong>
                </span>
            </div>

            <!-- The Actual Event Content -->
            <div class="generic-content">
                <?php the_content(); ?>
            </div>

        </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>