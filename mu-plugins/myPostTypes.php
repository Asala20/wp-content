<?php 

function my_register_post_types() {

//event post type
    register_post_type('event' , array(

        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'rewrite'=>array(
            'slug'=> 'events',
        ),
        'show_in_rest' =>true,
        'has_archive' => true,
        'public'=>true,
        'labels'=> array(
            'name'=>'Events',
            'add_new_item'=>'Add new Event',
            'edit_item' => 'Edit Event',
            'All_items' => 'All Events',
            'singular_name' => 'Event',
        ),
        'menu_icon' => 'dashicons-calendar'
    ));


//Project Post Type (For ITE College)
    register_post_type('project', array(
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'rewrite' => array(
            'slug' => 'projects',
        ),
        'show_in_rest' =>true,
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Projects',
            'add_new_item' => 'Add New Project',
            'edit_item' => 'Edit Project',
            'all_items' => 'All Projects',
            'singular_name' => 'Project',
        ),
        'menu_icon' => 'dashicons-portfolio' // Gives it a cool briefcase/portfolio icon!
    ));


//professor post type
    register_post_type('professor' , array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite'=>array(
            'slug'=> 'professors',
        ),
        'has_archive' => true,
        'public'=>true,
        'labels'=> array(
            'name'=>'Professors',
            'add_new_item'=>'Add new Professor',
            'edit_item' => 'Edit Professor',
            'All_items' => 'All Professors',
            'singular_name' => 'Professor',
        ),
        'menu_icon' => 'dashicons-welcome-learn-more'
    ));




}
add_action('init','my_register_post_types');

?>
