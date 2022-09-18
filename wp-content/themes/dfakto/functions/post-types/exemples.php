<?php

function theme_register_post_type_exemples()
{

    $labels = [
        'name' => __( "Exemples", 'custom_bo' ),
        'singular_name' => __( "Exemple", 'custom_bo' ),
    ];

    $args = [
        'label' => __( "Exemple", 'custom_bo' ),
        'labels' => $labels,
        'description' => '',
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_rest' => true, // Set to `true` for gutenberg support in post-type admin
        'rest_base' => '',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'has_archive' => false,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'delete_with_user' => false,
        'exclude_from_search' => false,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        //'rewrite' => [ 'slug' => 'my-custom-exemple-slug', 'with_front' => true ],
        'query_var' => true,
        'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ],
        'menu_icon' => 'dashicons-admin-multisite',
    ];

    register_post_type( 'exemples', $args );
}

add_action( 'init', 'theme_register_post_type_exemples' );
