<?php

function bd_event_management_theme_supports() {
    add_theme_support('post-thumbnails');

    add_theme_support('title-tag');

    register_nav_menus([
        'main-menu' => 'Main Menu'
    ]);
}

add_action('after_setup_theme', 'bd_event_management_theme_supports');

/**
 * Calling the theme files
 *
 * @return void
 */
function bd_event_management_theme_files() {
    wp_enqueue_style('bd-event-management-theme', get_stylesheet_uri());

    //tailwind cdn script
    wp_enqueue_script('tailwindcss', '//cdn.tailwindcss.com', [], '3.3.5', false);
}
add_action('wp_enqueue_scripts', 'bd_event_management_theme_files');


function  db_event_managent_custom_posts() {

    /**
     * Register sponsor post type
     */
    register_post_type('sponsor', [
        'labels' => [
            'name' => __('Sponsors'),
            'singular_name' => __('Sponsor'),
            'add_new_item' => __('Add New Sponsor'),
        ],
        'public' => false,
        'show_ui' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes']
    ]);
    /**
     * Register speakers post type
     */
    register_post_type('speaker', [
        'labels' => [
            'name' => __('Speakers'),
            'singular_name' => __('Speaker'),
            'add_new_item' => __('Add New Speaker'),
        ],
        'public' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes']
    ]);
    /**
     * Register person post type
     */
    register_post_type('person', [
        'labels' => [
            'name' => __('Persons'),
            'singular_name' => __('Person'),
            'add_new_item' => __('Add New Person'),
        ],
        'public' => false,
        'show_ui' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes']
    ]);
    /**
     * Register schedule post type
     */
    register_post_type('schedule', [
        'labels' => [
            'name' => __('Schedules'),
            'singular_name' => __('Schedule'),
            'add_new_item' => __('Add New Schedule'),
        ],
        'public' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes']
    ]);

    register_taxonomy('sponsor_cat', 'sponsor', [
        'hierarchical' => true,
        'label' => __('Sponsor Category'),
        'query_var' => true,
        'show_admin_column' => true,
        'rewrite' => [
            'slug' => 'sponsor-category',
            'with_front' => true
        ]
    ]);
}
add_action('init', 'db_event_managent_custom_posts');


function bd_event_management_elementor_widgets($widgets_manager){
    require_once "inc/widgets.php";

    $widgets_manager->register(new BEM_Sponsors());
}

add_action('elementor/widgets/register','bd_event_management_elementor_widgets');