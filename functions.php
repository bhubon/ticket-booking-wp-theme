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
    wp_enqueue_script('bem-main', get_template_directory_uri() . '/assets/js/main.js', ['jquery'], '1.0.0', false);
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
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes', 'comments']
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

    register_taxonomy('speaker_cat', 'speaker', [
        'hierarchical' => true,
        'label' => __('Speaker Category'),
        'query_var' => true,
        'show_admin_column' => true,
        'rewrite' => [
            'slug' => 'speaker-category',
            'with_front' => true
        ]
    ]);
}
add_action('init', 'db_event_managent_custom_posts');


function bd_event_management_elementor_widgets($widgets_manager) {
    require_once "inc/widgets.php";

    $widgets_manager->register(new BEM_Sponsors());
    $widgets_manager->register(new BEM_Speakers());
}

add_action('elementor/widgets/register', 'bd_event_management_elementor_widgets');


/**
 * get_sponsor_details ajax call
 *
 * @return void
 */
function bd_event_management_get_sponsor_details() {
    $id = sanitize_text_field($_POST['id']);
    $post = get_post($id);

    $html = '<div class="sponsor-details">
            <h3 class="font-bold text-3xl mb-2">' . $post->post_title . '</h3>
            <p>' . wpautop($post->post_content) . '</p>
    </div>';

    echo $html;
    die();
}

add_action('wp_ajax_get_sponsor_details', 'bd_event_management_get_sponsor_details');
add_action('wp_ajax_nopriv_get_sponsor_details', 'bd_event_management_get_sponsor_details');

/**
 * get_categorized_speakers ajax call
 *
 * @return void
 */
function bd_event_management_get_categorized_speakers() {
    $term_id = sanitize_text_field($_POST['id']);

    $q =  new WP_Query([
        'post_type' => 'speaker',
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'speaker_cat',
                'field' => 'term_id',
                'terms' => $term_id,
            ],
        ],
    ]);

    $html = '';

    if ($q->have_posts()) :
        while ($q->have_posts()) :
            $q->the_post();

            $html .= '<div class="px-4 w-1/4">
            <div class="speaker-image-wrapper">
                <div class="speaker-image">
                    ' . get_the_post_thumbnail(get_the_ID(), 'large') . '
                </div>
            </div>
            <h3>' . get_the_title() . '</h3>
        </div>';


        endwhile;
    endif;
    wp_reset_query();

    echo $html;
    die();
}

add_action('wp_ajax_get_categorized_speakers', 'bd_event_management_get_categorized_speakers');
add_action('wp_ajax_nopriv_get_categorized_speakers', 'bd_event_management_get_categorized_speakers');
