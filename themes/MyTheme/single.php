<?php get_header(); ?>

<main class="main-content">

    <?php while(have_posts()): the_post(); ?>
        
        <!-- Post Banner -->
        <div class="page-banner">
            <?php 
                // Uses the post's Featured Image, or falls back to your AVIF image
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

        <!-- Post Content Container -->
        <div class="page-layout-container" style="display: block;">
            
            <!-- Meta Information & Breadcrumb -->
            <div class="post-meta-box">
                <a class="back-to-blog" href="<?php echo site_url('/blog'); ?>">
                    <i class="fas fa-arrow-left"></i> Back to Blog
                </a>
                <span class="meta-details">
                    <i class="fas fa-user-edit"></i> Posted by <?php the_author_posts_link(); ?> 
                    <i class="fas fa-calendar-alt" style="margin-left: 15px;"></i> <?php the_time('F j, Y'); ?> 
                    <i class="fas fa-folder-open" style="margin-left: 15px;"></i> <?php echo get_the_category_list(', '); ?>
                </span>
            </div>

            <!-- The Actual Blog Content -->
            <div class="generic-content">
                <?php the_content(); ?>
            </div>

        </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>