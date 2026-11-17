<?php get_header(); ?>

<main class="main-content">
    <?php while(have_posts()): the_post(); ?>
        
        <!-- Professor Banner -->
        <div class="page-banner" style="height: 250px;">
            <div class="page-banner__bg-image" style="background-color: #111;"></div>
            <div class="page-banner__content">
                <h1 class="page-banner__title">Faculty Directory</h1>
            </div>
        </div>

        <div class="page-layout-container" style="display: block; max-width: 1000px;">
            
            <div style="display: flex; gap: 50px; align-items: flex-start; margin-bottom: 60px;">
                <!-- Professor Photo -->
                <div style="width: 300px; flex-shrink: 0; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; display: block;'));
                    } ?>
                </div>

                <!-- Professor Bio -->
                <div class="generic-content" style="flex-grow: 1;">
                    <h2 style="margin-top: 0; font-size: 3rem;"><?php the_title(); ?></h2>
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- REVERSE QUERY: Find Projects Supervised by this Professor -->
            <?php 
                $relatedProjects = new WP_Query(array(
                    'posts_per_page' => -1,
                    'post_type' => 'project',
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'related_professor', // The ACF field name we created
                            'compare' => 'LIKE', // Look *inside* the array of relationships
                            'value' => '"' . get_the_ID() . '"' // Look for THIS professor's exact ID
                        )
                    )
                ));

                if ($relatedProjects->have_posts()) {
                    echo '<hr style="border: 0; height: 1px; background: #ddd; margin: 50px 0;">';
                    echo '<h3 style="font-size: 2rem; color: #111; margin-bottom: 30px;">Supervised Projects</h3>';
                    echo '<ul style="list-style: none; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">';
                    
                    while ($relatedProjects->have_posts()) {
                        $relatedProjects->the_post(); ?>
                        
                        <li style="background: #f9f9f9; padding: 20px; border-radius: 10px; border-left: 4px solid var(--hover-color);">
                            <a href="<?php the_permalink(); ?>" style="color: #111; text-decoration: none; font-size: 1.2rem; font-weight: 700;">
                                <?php the_title(); ?>
                            </a>
                        </li>

                    <?php }
                    echo '</ul>';
                }
                wp_reset_postdata();
            ?>

        </div>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>