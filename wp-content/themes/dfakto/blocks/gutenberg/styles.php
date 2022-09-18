<?php

// see => wp-content/themes/custom/assets/js/editor.js
function we_register_blocks_styles() {

    register_block_style('core/cover', [
        'name' => 'has-parallax',
        'label' => 'Parallax',
    ]);

}
//add_action('init', 'we_register_blocks_styles');

function we_enqueue_cover_assets() {
    $dir = get_stylesheet_directory_uri() . '/css';
    wp_register_style('my-cover', $dir . '/my-cover.css', false);
}
//add_action('wp_enqueue_scripts', 'we_enqueue_cover_assets', 99);
