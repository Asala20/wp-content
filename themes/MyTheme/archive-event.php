<?php get_header(); ?>

<main class="main-content">
    
    <!-- Events Banner -->
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url('<?php echo get_theme_file_uri('/images/about-us.avif'); ?>');"></div>
        <div class="page-banner__overlay"></div>
        <div class="page-banner__content">
            <h1 class="page-banner__title">Upcoming Events</h1>
            <p style="color: white; font-size: 1.2rem; margin-top: 10px; font-weight: 300;">See what is going on at Elite University.</p>
        </div>
    </div>

    <!-- Events List Container -->
    <div class="page-layout-container" style="display: block; max-width: 800px; margin: 0 auto 100px auto;">
        
        <div class="events-list">
            <?php 
            // 1. Get today's date
            $today = date('Ymd');
            
            // 2. Setup Pagination trick for Custom Queries
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            // 3. Custom Query: ONLY Upcoming Events, Closest First
            $eventsQuery = new WP_Query(array(
                'paged' => $paged,
                'post_type' => 'event',
                'meta_key' => 'event_date',
                'orderby' => 'meta_value_num',
                'order' => 'ASC', // Closest dates at the top
                'meta_query' => array(
                    array(
                        'key' => 'event_date',
                        'compare' => '>=', // Greater than or equal to today
                        'value' => $today,
                        'type' => 'numeric'
                    )
                )
            ));

            // 4. The Loop
            while ($eventsQuery->have_posts()) {
                $eventsQuery->the_post(); ?>
                
                <div class="event-summary">
                    <!-- Advanced Date Badge pulling from ACF -->
                    <a class="event-summary__date" href="<?php the_permalink(); ?>">
                        <?php 
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
                        <a href="<?php the_permalink(); ?>" class="btn-text">Learn more &raquo;</a>
                    </div>
                </div>

            <?php } ?>
        </div>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php 
                echo paginate_links(array(
                    'total' => $eventsQuery->max_num_pages
                )); 
            ?>
        </div>
        
        <?php wp_reset_postdata(); ?>

        <hr style="border: 0; height: 1px; background: #eee; margin: 40px 0;">

        <!-- Link to Past Events -->
        <div style="text-align: center;">
            <p style="color: #666; font-size: 1.1rem; margin-bottom: 30px;">Looking for a recap of what happened?</p>
            <a href="<?php echo site_url('/past-events'); ?>" class="btn-primary">Check Out Past Events</a>
        </div>

    </div>

</main>

<?php get_footer(); ?>