<?php

/*
   Clean
   ========================================================================== */
/* https://gist.github.com/Auke1810/f2a4cf04f2c07c74a393a4b442f22267 */

//== Pour le logiciel de publication Windows Live Writer
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

//== Wordpress version
remove_action('wp_head', 'wp_generator');

//== Flux RSS des catégories, tags
remove_action('wp_head', 'feed_links_extra', 3 );

//== WP emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
//add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 ); // Remove width and height dynamic attributes to thumbnails
//add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 ); // Remove width and height dynamic attributes to post images
//add_filter( 'max_srcset_image_width', create_function('', 'return 1;') ); // Disable WordPRess responsive srcset images



/*
   Move Yoast to bottom
   ========================================================================== */

function yoast_seo_to_bottom() {
    return 'low';
}
if ( has_filter('wpseo_metabox_prio') ) {
    add_filter( 'wpseo_metabox_prio', 'yoast_seo_to_bottom');
}


/*
   Images sizes
   ========================================================================== */
/*
    WP CLI list images =>  wp media image-size
    WP CLI regenrate sizes : wp media regenerate --yes
 */

function set_images_size( $sizes ) {
    unset( $sizes['2048x2048'] );
    unset( $sizes['1536x1536'] );
    unset( $sizes['large'] );
    unset( $sizes['medium_large'] );
    unset( $sizes['medium'] );
    unset( $sizes['alm-thumbnail'] );
    unset( $sizes['alm-thumbnail'] );

    return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'set_images_size' );


/*
   Body classes
   ========================================================================== */

function add_slug_body_class( $classes ) {
    global $post;

    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );


/*
   Global
   ========================================================================== */

//== Theme support
//https://developer.wordpress.org/reference/functions/add_theme_support/
if (!function_exists('we_theme_support'))
{
    function we_theme_support()
    {
        add_theme_support('menus');
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('widgets');
        add_theme_support('woocommerce');
        add_theme_support('custom-logo');
        add_theme_support('responsive-embeds');
        add_theme_support(
            'html5',
            array(
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
                'navigation-widgets',
            )
        );
    }
}
add_action('after_setup_theme', 'we_theme_support');

/*
   Gutenberg settings
   ========================================================================== */

require_once get_template_directory() . '/functions/settings-gutenberg.php';
//add_filter('use_block_editor_for_post', '__return_false'); // disable Gutenberg editor


/*
   Filters
   ========================================================================== */

//==  Add Filters
add_filter('auto_update_plugin', '__return_false');


//== Remove Filters
//remove_filter ( 'acf_the_content', 'wpautop' ); // Remove <p> tags from WISIWYG ACF
//remove_filter( 'the_excerpt', 'wpautop' ); // Remove <p> tags from Excerpt altogether


/*
   Content
   ========================================================================== */

remove_filter( 'the_content', 'wpautop' );

add_filter( 'the_content', function ($content) {
    return has_blocks() ? $content : wpautop($content);
});


/*
   Excerpt
   ========================================================================== */

function we_limit_excerpt_length( $length ) {
    return 18;
}
add_filter( 'excerpt_length', 'we_limit_excerpt_length', 999 );
remove_filter( 'the_excerpt', 'wpautop' );

function we_change_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'we_change_excerpt_more' );



/*
   Constants
   ========================================================================== */

//== Font awesome rocket pro svg by default, change to Client or custom SVG Logo
define('LOGO_SVG', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M117.8 127.1H207C286.9-3.743 409.5-8.542 483.9 5.255C495.6 7.41 504.6 16.45 506.7 28.07C520.5 102.5 515.7 225.1 384 304.1V394.2C384 419.7 370.6 443.2 348.7 456.2L260.2 508.6C252.8 513 243.6 513.1 236.1 508.9C228.6 504.6 224 496.6 224 488V373.3C224 350.6 215 328.1 199 312.1C183 296.1 161.4 288 138.7 288H24C15.38 288 7.414 283.4 3.146 275.9C-1.123 268.4-1.042 259.2 3.357 251.8L55.83 163.3C68.79 141.4 92.33 127.1 117.8 127.1H117.8zM384 88C361.9 88 344 105.9 344 128C344 150.1 361.9 168 384 168C406.1 168 424 150.1 424 128C424 105.9 406.1 88 384 88zM166.5 470C117 519.5 .4762 511.5 .4762 511.5C.4762 511.5-7.516 394.1 41.98 345.5C76.37 311.1 132.1 311.1 166.5 345.5C200.9 379.9 200.9 435.6 166.5 470zM119.8 392.2C108.3 380.8 89.81 380.8 78.38 392.2C61.92 408.7 64.58 447.4 64.58 447.4C64.58 447.4 103.3 450.1 119.8 433.6C131.2 422.2 131.2 403.7 119.8 392.2z"/></svg>');

// define('NEWS_PAGE_ID', xxx);
