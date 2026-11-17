<!-- 3. THE FOOTER -->
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-grid">
                
                <!-- Brand Column -->
                <div class="footer-col brand-col">
                    <div class="footer-logo">
                        <i class="fas fa-graduation-cap"></i> ELITE<span>.</span>
                    </div>
                    <p>
                        Fostering academic excellence and innovation. We are dedicated to shaping the future through world-class education.
                    </p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Navigation Column 1 (Footer Location One) -->
                <div class="footer-col links-col">
                    <h4>Explore</h4>
                    
                    <ul>
                        <!-- Home -->
                        <li class="<?php if (is_front_page()) echo 'current-menu-item'; ?>">
                            <a href="<?php echo site_url(); ?>">Home</a>
                        </li>
                        
                        <!-- About -->
                        <li class="<?php 
                            $aboutPage = get_page_by_path('about-us');
                            $aboutID = $aboutPage ? $aboutPage->ID : 0;
                            if (is_page('about-us') || wp_get_post_parent_id(0) == $aboutID) echo 'current-menu-item'; 
                        ?>">
                            <a href="<?php echo site_url('/about-us'); ?>">About University</a>
                        </li>
                        
                        <!-- Blog (Strict Logic) -->
                        <li class="<?php if (is_home() || is_singular('post')) echo 'current-menu-item'; ?>">
                            <a href="<?php echo site_url('/blog'); ?>">Blog</a>
                        </li>

                        <!-- Events -->
                        <li class="<?php if (get_post_type() == 'event') echo 'current-menu-item'; ?>">
                            <a href="<?php echo get_post_type_archive_link('event'); ?>">Upcoming Events</a>
                        </li>
                    </ul> 
                </div>

                <!-- Navigation Column 2 (Footer Location Two) -->
                <div class="footer-col links-col">
                    <h4>Resources</h4>
                    
                    <ul>
                        <!-- Projects -->
                        <li class="<?php if (get_post_type() == 'project') echo 'current-menu-item'; ?>">
                            <a href="<?php echo get_post_type_archive_link('project'); ?>">Student Projects</a>
                        </li>
                        
                        <!-- Professors -->
                        <li class="<?php if (get_post_type() == 'professor') echo 'current-menu-item'; ?>">
                            <a href="<?php echo get_post_type_archive_link('professor'); ?>">Our Professors</a>
                        </li>
                    </ul> 
                </div>

                <!-- Contact Info -->
                <div class="footer-col contact-col">
                    <h4>Contact Admissions</h4>
                    <ul>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Campus Drive, Building A, Education City</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>admissions@elite-uni.edu</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <span>+1 (555) 987-6543</span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="footer-bottom">
                <!-- Pro Tip: Using date('Y') makes the copyright year update automatically! -->
                <p>&copy; <?php echo date('Y'); ?> ELITE University. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
<?php wp_footer(); ?>

</body>
</html>