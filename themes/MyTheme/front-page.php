<?php get_header(); ?>

<!-- MAIN CONTENT -->
<main class="main-content">
    
    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        
        <!-- Hero Main Text -->
        <div class="hero-content">
            <span class="hero-subtitle">Welcome to Elite University</span>
            <h1 class="hero-title">Empower Your Mind,<br>Shape The <span class="highlight">Future</span></h1>
            <p class="hero-description">
                Join a world-class academic community. Discover innovative programs, engage with renowned professors, and immerse yourself in a vibrant campus life.
            </p>
            <div class="hero-actions">
                <a href="<?php echo site_url('/projects'); ?>" class="btn-primary">Explore Projects</a>
                <a href="<?php echo wp_registration_url(); ?>" class="btn-secondary">Register</a>
            </div>
        </div>

        <!-- Hero Quick Links (Cards) -->
        <div class="hero-features">
            <div class="features-inner">
                <!-- Card 1 -->
                <a href="<?php echo site_url('/professors'); ?>" class="feature-card">
                    <div class="card-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3>Professors</h3>
                    <p>Learn from global experts</p>
                </a>
                <!-- Card 2 -->
                <a href="<?php echo site_url('/projects'); ?>" class="feature-card">
                    <div class="card-icon"><i class="fas fa-project-diagram"></i></div>
                    <h3>Projects</h3>
                    <p>Discover ITE student works</p>
                </a>
                <!-- Card 3 -->
                <a href="<?php echo site_url('/events'); ?>" class="feature-card">
                    <div class="card-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h3>Events</h3>
                    <p>Join our vibrant community</p>
                </a>
                <!-- Card 4 -->
                <a href="<?php echo site_url('/blog'); ?>" class="feature-card">
                    <div class="card-icon"><i class="fas fa-book-open"></i></div>
                    <h3>Blog</h3>
                    <p>Access shared resources</p>
                </a>
            </div>
        </div>
    </section>

    <!-- ABOUT US SECTION -->
    <section class="about-section">
        <div class="about-container">
            
            <!-- Column 1: Image -->
            <div class="about-image-col">
                <div class="image-wrapper">
                    <img src="<?php echo get_theme_file_uri('/images/about-us.avif'); ?>" alt="Elite University Students">
                    
                    <!-- Floating Badge -->
                    <div class="image-experience-badge">
                        <span class="years">50+</span>
                        <span class="text">Years of<br>Excellence</span>
                    </div>
                </div>
            </div>
            
            <!-- Column 2: Text -->
            <div class="about-text-col">
                <span class="section-subtitle">Discover Elite</span>
                <h2 class="section-title">A Legacy of Academic <span class="highlight-text">Excellence</span></h2>
                
                <p class="section-description">
                    Since our founding, Elite University has been at the forefront of global education, fostering a culture of innovation, critical thinking, and leadership. Our campus is a melting pot of diverse minds dedicated to making a real-world impact.
                </p>
                <p class="section-description">
                    Whether you're engaging with renowned professors, participating in groundbreaking research, or joining our vibrant student events, Elite provides the perfect environment to shape your future.
                </p>
                
                <a href="<?php echo site_url('/about-us'); ?>" class="btn-primary btn-about">Learn More About Us</a>
            </div>

        </div>
    </section>
    <!-- FEATURED PROJECTS SECTION (Dark Mode) -->
    <section class="featured-projects-section">
        <div class="featured-projects-container">
            <span class="section-subtitle" style="text-align: center; display: block;">Innovation in Action</span>
            <h2 class="section-title" style="text-align: center; color: var(--text-white);">Featured <span class="highlight-text">Projects</span></h2>

            <div class="hp-projects-grid">
                <?php 
                // 1. Custom Query: Get the 2 most recent projects
                $homepageProjects = new WP_Query(array(
                    'posts_per_page' => 2,
                    'post_type' => 'project'
                ));

                // 2. The Loop
                while ($homepageProjects->have_posts()) {
                    $homepageProjects->the_post(); ?>
                    
                    <a href="<?php the_permalink(); ?>" class="hp-project-card">
                        <?php 
                        // Grab the featured image URL safely
                        $bgImage = get_theme_file_uri('/images/about-us.avif');
                        if(has_post_thumbnail()) {
                            $bgImage = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        }
                        ?>
                        <!-- Background Image -->
                        <div class="hp-project-card__bg" style="background-image: url('<?php echo $bgImage; ?>');"></div>
                        
                        <!-- Dark/Red Hover Overlay -->
                        <div class="hp-project-card__overlay"></div>
                        
                        <!-- Text Content -->
                        <div class="hp-project-card__content">
                            <h3><?php the_title(); ?></h3>
                            <p>View Case Study <i class="fas fa-arrow-right"></i></p>
                        </div>
                    </a>

                <?php } 
                // 3. Reset Post Data
                wp_reset_postdata(); 
                ?>
            </div>

            <!-- Link to the Projects Archive -->
            <div class="btn-center" style="text-align: center; margin-top: 50px;">
                <a href="<?php echo get_post_type_archive_link('project'); ?>" class="btn-primary">Explore All Projects</a>
            </div>
        </div>
    </section>
    <!-- UPCOMING EVENTS SECTION (ACF Custom Query) -->
    <section class="events-section">
        <div class="events-container">
            <span class="section-subtitle" style="text-align: center; display: block;">Join Our Community</span>
            <h2 class="section-title" style="text-align: center;">Upcoming <span class="highlight-text">Events</span></h2>
            
            <div class="events-list">
                <?php 
                // 1. Get today's date in the exact format ACF uses (Ymd)
                $today = date('Ymd');

                // 2. The Advanced Custom Query
                $homepageEvents = new WP_Query(array(
                    'posts_per_page' => 2,
                    'post_type' => 'event',
                    'meta_key' => 'event_date',      // Look at our new custom field
                    'orderby' => 'meta_value_num',   // Sort them as numbers
                    'order' => 'ASC',                // Show the closest date first!
                    'meta_query' => array(           // Filter out past events
                        array(
                            'key' => 'event_date',
                            'compare' => '>=',
                            'value' => $today,
                            'type' => 'numeric'
                        )
                    )
                ));

                // 3. The Loop
                while ($homepageEvents->have_posts()) {
                    $homepageEvents->the_post(); ?>
                    
                    <div class="event-summary">
                        <!-- Advanced Date Badge pulling from ACF -->
                        <a class="event-summary__date" href="<?php the_permalink(); ?>">
                            <?php 
                                // Get the raw date from ACF (e.g., 20261225)
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

                <?php } wp_reset_postdata(); ?>
            </div>
            
            <div class="btn-center" style="text-align: center; margin-top: 40px;">
                <a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn-primary">View All Events</a>
            </div>
        </div>
    </section>



    <!-- RECENT NEWS SECTION (Custom Query) -->
    <section class="recent-news-section">
        <div class="recent-news-header">
            <span class="section-subtitle">Stay Updated</span>
            <h2 class="recent-news-title">Latest University <span class="highlight-text">News</span></h2>
        </div>

        <div class="blog-grid-container">
            <div class="blog-grid">
                <?php 
                // 1. Define the Custom Query: Get the 3 most recent posts
                $homepageNews = new WP_Query(array(
                    'posts_per_page' => 3,
                    'post_type' => 'post'
                ));

                // 2. The Custom Loop
                while ($homepageNews->have_posts()) {
                    $homepageNews->the_post(); ?>
                    
                    <!-- Reusing our existing blog card design! -->
                    <article class="blog-card">
                        <div class="blog-card__image">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail('large');
                                } else { ?>
                                    <img src="<?php echo get_theme_file_uri('/images/about-us.avif'); ?>" alt="Default News Image">
                                <?php } ?>
                            </a>
                        </div>
                        
                        <div class="blog-card__content">
                            <div class="blog-card__meta">
                                <span class="meta-date"><i class="fas fa-calendar-alt"></i> <?php the_time('M j, Y'); ?></span>
                                <span class="meta-category"><i class="fas fa-folder-open"></i> <?php echo get_the_category_list(', '); ?></span>
                            </div>
                            
                            <h3 class="blog-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="blog-card__excerpt">
                                <?php echo wp_trim_words(get_the_content(), 15); ?>
                            </div>
                            
                            <a class="blog-card__btn" href="<?php the_permalink(); ?>">Read Article <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </article>

                <?php } 
                
                // 3. CLEAN UP: Always reset post data after a custom query!
                wp_reset_postdata(); 
                ?>
            </div>
            
            <!-- Button to view all news -->
            <div class="btn-center">
                <a href="<?php echo site_url('/blog'); ?>" class="btn-primary">View All News</a>
            </div>
        </div>
    </section>
</main>




<?php get_footer(); ?>