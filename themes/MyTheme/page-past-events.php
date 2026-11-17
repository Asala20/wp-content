<?php get_header(); ?>

<main class="main-content">
    
    <!-- Past Events Banner -->
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url('<?php echo get_theme_file_uri('/images/about-us.avif'); ?>');"></div>
        <div class="page-banner__overlay"></div>
        <div class="page-banner__content">
            <h1 class="page-banner__title">Past Events</h1>
            <p style="color: white; font-size: 1.2rem; margin-top: 10px; font-weight: 300;">A recap of our past campus events.</p>
        </div>
    </div>

    <!-- Events List Container -->
    <div class="page-layout-container" style="display: block; max-width: 800px; margin: 0 auto 100px auto;">
        
        <!-- Breadcrumb back to Upcoming Events -->
        <div class="page-breadcrumb" style="margin-bottom: 30px;">
            <a href="<?php echo get_post_type_archive_link('event'); ?>">
                <i class="fas fa-arrow-left"></i> Back to Upcoming Events
            </a>
        </div>

        <div class="events-list">
            <?php 
            // 1. Get today's date
            $today = date('Ymd');
            
            // 2. Setup Pagination
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            // 3. Custom Query: ONLY Past Events, Most Recent First
            $pastEvents = new WP_Query(array(
                'paged' => $paged,
                'post_type' => 'event',
                'meta_key' => 'event_date',
                'orderby' => 'meta_value_num',
                'order' => 'DESC', // Z-A (Goes backwards in time: e.g., May, then April, then March)
                'meta_query' => array(
                    array(
                        'key' => 'event_date',
                        'compare' => '<', // Strictly LESS than today
                        'value' => $today,
                        'type' => 'numeric'
                    )
                )
            ));

            // 4. The Loop
            while ($pastEvents->have_posts()) {
                $pastEvents->the_post(); ?>
                
                <div class="event-summary">
                    <!-- Advanced Date Badge pulling from ACF -->
                    <a class="event-summary__date" href="<?php the_permalink(); ?>" style="background-color: #555;">
                        <?php 
                            // Using our bulletproof raw date fix
                            $eventDate = new DateTime(get_field('event_date', false, false));
                        ?>
                        <span class="event-summary__month"><?php echo $eventDate->format('M'); ?></span>
                        <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
                    </a>
                    
                    <div class="event-summary__content">
                        <h3 class="event-summary__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p>
                            <?php 
                            if (has_excerpt()) { 
                                echo get_the_excerpt(); 
                            } else { 
                                echo wp_trim_words(get_the_content(), 15); 
                            } 
                            ?>
                        </p>
                        <a href="<?php the_permalink(); ?>" class="btn-text">View Event Recap &raquo;</a>
                    </div>
                </div>

            <?php } ?>
        </div>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php 
                echo paginate_links(array(
                    'total' => $pastEvents->max_num_pages
                )); 
            ?>
        </div>
        
        <?php wp_reset_postdata(); ?>

    </div>

</main>

<?php get_footer(); ?>