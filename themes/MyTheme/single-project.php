<?php 
// ==========================================
// 1. BACKEND LOGIC (Must run before header to allow redirects!)
// ==========================================
$post_id = get_queried_object_id();

// Grab existing notes from the database
$notes = get_post_meta($post_id, 'project_notes_data', true);
if (!is_array($notes)) { $notes = array(); }

// CHECK PERMISSIONS: Is the user an Editor (Professor) or Admin?
$is_professor = current_user_can('edit_posts'); 

// HANDLE ADDING A NOTE
if (isset($_POST['submit_new_note']) && $is_professor) {
    $new_note_text = sanitize_textarea_field($_POST['note_text']);
    if (!empty($new_note_text)) {
        $note_id = uniqid(); // Generate a unique ID for this note
        $current_user = wp_get_current_user();
        
        $notes[$note_id] = array(
            'text' => $new_note_text,
            'author' => $current_user->display_name, // Saves the Professor's name!
            'date' => date('F j, Y, g:i a')
        );
        update_post_meta($post_id, 'project_notes_data', $notes);
        wp_safe_redirect(get_permalink($post_id)); // Refresh page
        exit;
    }
}

// HANDLE DELETING A NOTE
if (isset($_GET['delete_note']) && $is_professor) {
    $note_to_delete = $_GET['delete_note'];
    if (isset($notes[$note_to_delete])) {
        unset($notes[$note_to_delete]); // Remove it from the array
        update_post_meta($post_id, 'project_notes_data', $notes);
        wp_safe_redirect(get_permalink($post_id)); // Refresh page
        exit;
    }
}
// ==========================================
?>

<?php get_header(); ?>

<main class="main-content">

    <?php while(have_posts()): the_post(); ?>
        
        <!-- 1. Massive Project Hero Image -->
        <?php 
            $heroImage = get_theme_file_uri('/images/about-us.avif');
            if (has_post_thumbnail()) {
                $heroImage = get_the_post_thumbnail_url();
            }
        ?>
        <header class="project-hero" style="background-image: url('<?php echo $heroImage; ?>');">
            <div class="project-hero__overlay"></div>
            <div class="project-hero__content">
                <span class="project-hero__subtitle">ITE College Project</span>
                <h1 class="project-hero__title"><?php the_title(); ?></h1>
            </div>
        </header>

        <!-- 2. Two-Column Project Layout -->
        <div class="project-layout-container">
            
            <!-- Left Column: The Main Details -->
            <div class="project-main-content">
                <div class="generic-content">
                    <?php the_content(); ?>
                </div>
                
                <hr style="border: 0; height: 1px; background: #eee; margin: 40px 0;">

                <!-- ========================================== -->
                <!-- 3. THE NEW NOTES SECTION (Protected)       -->
                <!-- ========================================== -->
                <div class="project-notes-section" style="margin-bottom: 50px;">
                    <h3 style="font-size: 2rem; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 30px;">Professor Evaluations & Notes</h3>
                    
                    <?php if (is_user_logged_in()) { ?>
                        <!-- /// ACCESS GRANTED /// -->

                        <!-- ADD NOTE FORM (Visible ONLY to Professors) -->
                        <?php if ($is_professor) { ?>
                            <div style="background: #f4f4f4; padding: 25px; border-radius: 10px; margin-bottom: 40px; border: 1px solid #ddd;">
                                <h4 style="margin-top: 0; color: var(--hover-color);"><i class="fas fa-lock"></i> Professor Only: Add Note</h4>
                                <form method="POST">
                                    <textarea name="note_text" rows="4" style="width: 100%; border-radius: 8px; border: 1px solid #ccc; padding: 15px; font-family: inherit; font-size: 1rem;" placeholder="Write your note or evaluation here..." required></textarea>
                                    <button type="submit" name="submit_new_note" class="btn-primary" style="margin-top: 15px; border: none; cursor: pointer;">Post Note</button>
                                </form>
                            </div>
                        <?php } ?>

                        <!-- DISPLAY ALL NOTES (Visible to Logged In Users) -->
                        <div class="notes-list">
                            <?php if (!empty($notes)) { 
                                // Show newest notes at the top!
                                $notes = array_reverse($notes, true);
                                
                                foreach ($notes as $id => $note) { ?>
                                    <div style="background: #fff; border-left: 5px solid var(--hover-color); padding: 25px; margin-bottom: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-radius: 0 10px 10px 0;">
                                        
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                            <strong style="color: #111; font-size: 1.1rem;"><i class="fas fa-chalkboard-teacher" style="color: var(--hover-color);"></i> <?php echo esc_html($note['author']); ?></strong>
                                            <span style="font-size: 0.9rem; color: #888;"><i class="far fa-clock"></i> <?php echo esc_html($note['date']); ?></span>
                                        </div>
                                        
                                        <p style="margin: 0; color: #444; line-height: 1.6; white-space: pre-line;"><?php echo esc_html($note['text']); ?></p>
                                        
                                        <!-- DELETE BUTTON (Visible ONLY to Professors) -->
                                        <?php if ($is_professor) { ?>
                                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #eee; text-align: right;">
                                                <a href="?delete_note=<?php echo $id; ?>" style="color: #ff3b30; font-size: 0.9rem; text-decoration: none; font-weight: bold;" onclick="return confirm('Are you sure you want to delete this note?');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        <?php } ?>

                                    </div>
                            <?php } 
                            } else {
                                echo '<p style="color: #888; font-style: italic; font-size: 1.1rem;">No professor notes have been added to this project yet.</p>';
                            } ?>
                        </div>

                    <?php } else { ?>
                        <!-- /// ACCESS DENIED (Guests) /// -->
                        <div style="background: #f9f9f9; padding: 40px 20px; border-radius: 10px; text-align: center; border: 1px solid #ddd;">
                            <i class="fas fa-lock" style="font-size: 3rem; color: #888; margin-bottom: 15px;"></i>
                            <h4 style="margin: 0 0 10px 0; color: #111; font-size: 1.5rem;">Restricted Access</h4>
                            <p style="color: #666; font-size: 1.1rem; margin-bottom: 25px;">You must be logged in as a student or professor to view the academic notes.</p>
                            <a href="<?php echo wp_login_url(); ?>" class="btn-primary">Login to View Notes</a>
                        </div>
                    <?php } ?>

                </div>
                <!-- END NOTES SECTION -->
                
                <a class="btn-primary" href="<?php echo get_post_type_archive_link('project'); ?>" style="display: inline-block;">
                    <i class="fas fa-arrow-left"></i> Back to All Projects
                </a>
            </div>

            <!-- Right Column: Project Sticky Sidebar -->
            <aside class="project-sidebar">
                <div class="project-sidebar__card">
                    <h3>Project Details</h3>
                    
                    <ul class="project-sidebar__list">

                        <!-- Supervisor (ACF Relationship) -->
                        <?php 
                        $relatedProfessors = get_field('related_professor');
                        if ($relatedProfessors) { 
                            foreach ($relatedProfessors as $professor) { 
                        ?>
                            <li>
                                <!-- Display the Professor's Image -->
                                <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; flex-shrink: 0; border: 2px solid var(--hover-color);">
                                    <?php echo get_the_post_thumbnail($professor->ID, 'thumbnail', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                </div>
                                
                                <div>
                                    <strong>Supervisor</strong>
                                    <span>
                                        <!-- Link to the single professor page -->
                                        <a href="<?php echo get_permalink($professor->ID); ?>" style="color: #111; text-decoration: none; transition: color 0.3s;">
                                            <?php echo get_the_title($professor->ID); ?>
                                        </a>
                                    </span>
                                </div>
                            </li>
                        <?php 
                            } // End foreach
                        } // End if 
                        ?>

                        <!-- Academic Semester -->
                        <?php if (get_field('academic_semester')) { ?>
                            <li>
                                <i class="fas fa-university"></i>
                                <div>
                                    <strong>Semester / Type</strong>
                                    <span><?php the_field('academic_semester'); ?></span>
                                </div>
                            </li>
                        <?php } ?>

                        <!-- Team Members & Tasks -->
                        <!-- تم التحديث للاسم المطابق للصورة: team_members_&_tasks -->
                        <?php if (get_field('team_members_&_tasks')) { ?>
                            <li>
                                <i class="fas fa-users"></i>
                                <div>
                                    <strong>Team & Tasks</strong>
                                    <!-- استخدمنا div بدلاً من span لأن حقل WYSIWYG يولد وسوم HTML تلقائياً -->
                                    <div class="generic-content" style="line-height: 1.6; font-size: 1rem; color: #444; margin-top: 5px;">
                                        <?php the_field('team_members_&_tasks'); ?>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>

                        <!-- Technologies -->
                        <!-- تم التحديث للاسم المطابق للصورة: technologies_used -->
                        <?php if (get_field('technologies_used')) { ?>
                            <li>
                                <i class="fas fa-laptop-code"></i>
                                <div>
                                    <strong>Technologies Used</strong>
                                    <span><?php the_field('technologies_used'); ?></span>
                                </div>
                            </li>
                        <?php } ?>
                        
                        <!-- Date Published (Standard WP) -->
                        <li>
                            <i class="fas fa-calendar-check"></i>
                            <div>
                                <strong>Published</strong>
                                <span><?php the_time('F Y'); ?></span>
                            </div>
                        </li>

                    </ul>
                </div>
            </aside>

        </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>