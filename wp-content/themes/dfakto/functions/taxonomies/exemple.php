<?php

function theme_register_taxonomy_exemple()
{

    $labels = [
        'name' => __( 'Exemples', 'custom_bo' ),
        'singular_name' => __( 'Exemple', 'custom_bo' ),
    ];

    $args = [
        'label' => __( 'Exemple', 'custom_bo' ),
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'query_var' => true,
        //'rewrite' => [ 'slug' => 'my-exemple-rewrite-slug', 'with_front' => true, ],
        'show_admin_column' => true,
        'show_in_rest' => true,
        //'rest_base' => 'exemple',
        'rest_controller_class' => 'WP_REST_Terms_Controller',
        'show_in_quick_edit' => true,
    ];
    register_taxonomy( 'exemple', [], $args );
}
add_action( 'init', 'theme_register_taxonomy_exemple' );
