<?php 
    add_filter('show_admin_bar', '__return_false');
    
    add_action('wp_enqueue_scripts' , 'MyFiles');
    function MyFiles(){

        //css
        wp_enqueue_style('main_css' , get_theme_file_uri('/CSS/main.css'));

        //js
        wp_enqueue_script('main_scripts', get_theme_file_uri('/build/index.js'), array('jquery'), time(), true);

        //font awesome library
        wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
        );

        // El Messiri font
        wp_enqueue_style(
            'el-messiri-font',
            'https://fonts.googleapis.com/css2?family=El+Messiri:wght@400;500;600;700&display=swap',
            array(),
            null
        );

        wp_localize_script('main_scripts', 'universityData', array('root_url' => get_site_url()));
        
    }



    add_action('after_setup_theme', 'university_features');
    function university_features(){
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        register_nav_menu('headerMenuLocation' , 'Header Menu Location');
        register_nav_menu('footerLocationOne', 'Footer Location One');
        register_nav_menu('footerLocationTwo', 'Footer Location Two');
    }


// ==========================================
// CUSTOMIZE LOGIN / REGISTER SCREEN & REDIRECTS
// ==========================================

// 1. Replace WP Logo with "ELITE." Text & Style Button
add_action('login_enqueue_scripts', 'elite_custom_login_screen');
function elite_custom_login_screen() {
    ?>
    <style type="text/css">
        /* Remove the WP Image Logo and Show Text */
        .login h1 a {
            background-image: none !important;
            text-indent: 0 !important; /* Brings the text back onto the screen */
            width: auto !important;
            height: auto !important;
            font-size: 2.5rem !important;
            font-family: "El Messiri", sans-serif !important;
            font-weight: 700 !important;
            color: #111111 !important; /* Dark text */
            text-decoration: none !important;
            line-height: 1.2 !important;
            margin-bottom: 20px !important;
        }

        /* Adds the signature Red Dot to match your website logo! */
        .login h1 a::after {
            content: '.';
            color: #ff3b30;
        }

        /* Make the Login Button match your Elite Red */
        .login form .button-primary {
            background-color: #ff3b30 !important;
            border-color: #ff3b30 !important;
            text-shadow: none !important;
            box-shadow: none !important;
            border-radius: 50px !important; /* Pill shape */
            transition: all 0.3s ease;
        }
        .login form .button-primary:hover {
            background-color: #cc2e25 !important;
            border-color: #cc2e25 !important;
        }
    </style>
    <?php
}

// 2. Change the text inside the link to "ELITE"
add_filter('login_headertext', 'elite_custom_login_title');
function elite_custom_login_title() {
    return 'ELITE';
}

// 3. Make the title link back to the homepage
add_filter('login_headerurl', 'elite_custom_login_url');
function elite_custom_login_url() {
    return site_url('/');
}

// ==========================================
// FORCE REDIRECTIONS
// ==========================================

// 4. Redirect after Logging In
add_filter('login_redirect', 'elite_login_redirect', 10, 3);
function elite_login_redirect($redirect_to, $request, $user) {
    // If you (the Admin) log in, go to the dashboard to manage the site.
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('administrator', $user->roles)) {
            return admin_url();
        }
    }
    // Everyone else (Professors, Students) goes straight to the homepage!
    return site_url('/');
}

// 5. Redirect after Logging Out
add_action('wp_logout', 'elite_logout_redirect');
function elite_logout_redirect() {
    wp_safe_redirect(site_url('/'));
    exit;
}

// 6. Redirect after Registration
add_filter('registration_redirect', 'elite_register_redirect');
function elite_register_redirect($registration_redirect) {
    // Send them to the homepage immediately after they register
    return site_url('/');
}
    
?>



