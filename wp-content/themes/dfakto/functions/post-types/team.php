<?php

function theme_register_post_type_team()
{

    $labels = [
        'name' => 'Equipe',
        'singular_name' => 'Equipe',
    ];

    $args = [
        'label' => 'Equipe',
        'labels' => $labels,
        'description' => '',
        'publicly_queryable' => true,
        'public' => false,
        'show_in_rest' => false,
        'rest_base' => '',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'delete_with_user' => false,
        'exclude_from_search' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        //'rewrite' => [ 'slug' => 'equipe', 'with_front' => true ],
        'query_var' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'],
        'taxonomies' => ['category'],
        'menu_icon' => 'dashicons-admin-users',
    ];

    register_post_type('team', $args );
}

add_action('init', 'theme_register_post_type_team');
