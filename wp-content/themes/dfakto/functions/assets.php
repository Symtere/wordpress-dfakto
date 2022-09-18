<?php

/*
    STYLES (@front)
   ========================================================================== */

function register_theme_styles()
{
    //wp_register_style( 'fa-style', '//pro.fontawesome.com/releases/v5.15.4/css/all.css', [], '5.15.4' ); // Font Awesome V5 (CDN) (V6 uses now Kit)
    wp_register_style( 'swiper-style', get_lib_url('swiperjs/swiper-bundle.css'), [], '8.1.5' );
    wp_register_style( 'app-style', get_template_directory_uri() . '/style.css', [], get_asset_version(get_stylesheet_directory() . '/style.css') );
}

function theme_style_attributes( $html, $handle )
{

    if ( 'fa-style' === $handle ) { // Font Awesome V5 => see fa-script
        return str_replace( "media='all'", 'media="all" integrity="sha384-rqn26AG5Pj86AF4SO72RK5fyefcQ/x32DNQfChxWvbXIyXFePlEktwD18fEz+kQU" crossorigin="anonymous"', $html );
    }

    return $html;
}
//add_filter( 'style_loader_tag', 'theme_style_attributes', 10, 2 );

function enqueue_theme_styles()
{
    /* conditionnal here if needed */

    //wp_enqueue_style( 'fa-style' );
    wp_enqueue_style( 'swiper-style' );
    wp_enqueue_style( 'app-style' );
}


/*
    SCRIPTS (@front)
   ========================================================================== */

function register_theme_scripts()
{
    wp_register_script( 'bootstrap-script', get_lib_url( 'bootstrap.bundle.min.js' ), [], '5.1.3', true );
    wp_register_script( 'fa-script', '//kit.fontawesome.com/5d697b1d4b.js', [], '6.0.0', false ); // Since Font Awesome V6 (Kit instead of CDN)
    wp_register_script( 'axios-script', get_lib_url( 'scripts.js' ), [], '0.26.0', true );
    wp_register_script( 'swiper-script', get_lib_url( 'swiperjs/swiper-bundle.min.js' ), [], '8.1.5', true );
    wp_register_script( 'sharethis-script', '//platform-api.sharethis.com/js/sharethis.js', [], false );
    wp_register_script( 'app-script', get_js_url( 'app.js' ), [], get_asset_version(get_template_directory() . '/assets/js/app.js' ), true );
    wp_register_script( 'fetch-script', get_js_url( 'fetch-api.js' ), [], get_asset_version(get_template_directory() . '/assets/js/fetch-api.js' ), true );
    wp_register_script( 'jarallax-script', '//cdnjs.cloudflare.com/ajax/libs/jarallax/2.0.4/jarallax.min.js', [], '2.0.4', true );
}

function add_scripts_params( $tag, $handle, $src )
{
    $st_key_field = function_exists('get_field_option') ? get_field_option( 'sharethis_key' ) : false;
    $st_key = $st_key_field && !empty( $st_key_field ) ? $st_key_field : '5fad0b46cc85000012ec2e4e';

    if ( $st_key_field && 'sharethis-script' === $handle ) {
        $tag = '<script src="' . esc_url( $src ) . '#property='. $st_key .'&product=custom-share-buttons" async="async" id="sharethis-script-js"></script>';
    }
    if ( 'fa-script' === $handle ) { // Since Font Awesome V6
        $tag = '<script src="' . esc_url( $src ) . '" crossorigin="anonymous" id="fa-script-js"></script>';
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'add_scripts_params', 10, 3 );

function enqueue_theme_scripts()
{
    wp_enqueue_script( 'bootstrap-script' );
    wp_enqueue_script( 'fa-script' );
    //wp_enqueue_script( 'sharethis-script' );
    //wp_enqueue_script( 'axios-script' );
    wp_enqueue_script( 'swiper-script' );
    wp_enqueue_script( 'jarallax-script' );

    wp_enqueue_script( 'fetch-script' );
    wp_localize_script( 'fetch-script', 'wp_api',
        [
            'nonce' => wp_create_nonce('wp_rest'),
            'rest_url' => untrailingslashit(rest_url()),
            'site_url' => esc_url(site_url()),
            'assets_url' => esc_attr(get_template_directory_uri() . '/assets/'),
        ]
    );

    wp_enqueue_script( 'app-script' );

    // if ( is_singular( 'post' ) ) {
    //     wp_enqueue_script( 'sharethis-script' );
    // }
}


/*
    Editor SCRIPTS && STYLE (@admin)
   ========================================================================== */

//== Equeue Editor CSS/JS
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_script( 'editor-script', get_js_url( 'editor.js' ), ['wp-edit-post', 'wp-blocks', 'wp-dom-ready'], '1.0.0', true );
    wp_enqueue_style( 'style-editor', get_template_directory_uri() . '/style-editor.css', [], '1.0.0' );
});


/*
    Admin SCRIPTS && STYLE (@admin)
   ========================================================================== */

function enqueue_admin_assets()
{
    //wp_enqueue_style( 'acf-admin-style', get_css_url('acf-admin.css'), true, '1.0');
}



/*
    ACTIONS
   ========================================================================== */

add_action( 'init', 'register_theme_styles' );
add_action( 'init', 'register_theme_scripts' );
add_action( 'wp_enqueue_scripts', 'enqueue_theme_scripts' );
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );
//add_action( 'admin_enqueue_scripts', 'enqueue_admin_assets' );

//remove_filter( 'admin_head', 'wp_check_widget_editor_deps' );
