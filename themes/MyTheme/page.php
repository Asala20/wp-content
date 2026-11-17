<?php get_header(); ?>

<?php while(have_posts()): the_post(); ?>
    
    <!-- 1. Page Banner -->
    <div class="page-banner">
        <!-- Reusing your local image for the background -->
        <div class="page-banner__bg-image" style="background-image: url('<?php echo get_theme_file_uri('/images/about-us.avif'); ?>');"></div>
        <div class="page-banner__overlay"></div>
        <div class="page-banner__content">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
        </div>
    </div>

    <!-- 2. Main Page Layout -->
    <div class="page-layout-container">
        <?php 
        // WP Logic to check if page has a parent or is a parent
        $theParent = wp_get_post_parent_id(get_the_ID());
        $hasChildren = get_pages(array('child_of' => get_the_ID()));
        
        // Only show sidebar if it's a child page OR has children
        if ($theParent or $hasChildren) { ?>
            
            <aside class="page-sidebar">
                <!-- Sidebar Header (Always links to the top Parent page) -->
                <h3 class="sidebar-title">
                    <a href="<?php echo get_permalink($theParent ? $theParent : get_the_ID()); ?>">
                        <?php echo get_the_title($theParent ? $theParent : get_the_ID()); ?>
                    </a>
                </h3>
                
                <!-- Dynamic Menu list of children -->
                <ul class="sidebar-menu">
                    <?php 
                    $findChildrenOf = $theParent ? $theParent : get_the_ID();
                    wp_list_pages(array(
                        'title_li' => NULL,
                        'child_of' => $findChildrenOf,
                        'sort_column' => 'menu_order'
                    ));
                    ?>
                </ul>
            </aside>
            
        <?php } ?>

        <!-- 3. Page Content Area -->
        <main class="page-content">
            <!-- Breadcrumbs (Shows 'Back to parent' if on a child page) -->
            <?php if ($theParent) { ?>
                <div class="page-breadcrumb">
                    <a href="<?php echo get_permalink($theParent); ?>">
                        <i class="fas fa-arrow-left"></i> Back to <?php echo get_the_title($theParent); ?>
                    </a>
                </div>
            <?php } ?>

            <!-- The text from your WP Editor goes here -->
            <div class="generic-content">
                <?php the_content(); ?>
            </div>
        </main>

    </div>

<?php endwhile; ?>

<?php get_footer(); ?>