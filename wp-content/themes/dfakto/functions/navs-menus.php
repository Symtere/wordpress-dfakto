<?php

function get_menu_name($location)
{
    $locations = get_nav_menu_locations();
    $menu_id = $locations[ $location ];
    $menu = wp_get_nav_menu_object($menu_id);

    return $menu->name;
}

function register_theme_menu()
{
    register_nav_menus([
        'nav_header'  => __( 'Navigation Principale', 'custom-bo' ),
        'nav_footer' => __( 'Navigation Footer', 'custom-bo' ),
        //'nav_social_footer' => __( 'Navigation Social footer', 'custom-bo' ),
        'nav_rgpd' => __( 'Navigation RGPD', 'custom-bo' ),
    ]);
}

function header_nav($nav_class = 'flex-row main-nav', $uniq_id = '')
{
    wp_nav_menu([
        'container'       => '',
        'theme_location'  => 'nav_header',
        'depth'           => 2,
        'menu_class'      => 'nav navbar-nav ' . $nav_class,
        'menu_id'         => !empty($uniq_id) ? $uniq_id : $nav_class,
        'link_before'     => '<span>',
        'link_after'      => '</span>',
        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
        'walker'          => new WP_Bootstrap_Navwalker(),
    ]);
}
function footer_nav()
{

    wp_nav_menu([
        'container'       => '',
        'theme_location'  => 'nav_footer',
        'menu_class'      => 'footer-nav list-unstyled',
    ]);

    /*
    $footer_nav_args = [
        'theme_location'  => 'nav_footer',
        'container'       => false,
        'echo'            => false,
        'items_wrap'      => '%3$s',
        'depth'           => 0,
    ];
    echo strip_tags( wp_nav_menu( $footer_nav_args ), '<a>' );
    */
}
function footer_nav_social()
{
    wp_nav_menu([
        'container'      => '',
        'theme_location' => 'nav_social_footer',
        'menu_class'     => 'ft-social list-unstyled',
        'depth'          => 0,
    ]);
}

function rgpd_nav()
{
    $rgpd_args = [
        'theme_location'  => 'nav_rgpd',
        'container'       => false,
        'echo'            => false,
        'items_wrap'      => '%3$s',
        'depth'           => 0,
    ];
    echo strip_tags( wp_nav_menu( $rgpd_args ), '<a>' );
}

// ACF option to display menu title
function theme_display_menu_title( $items, $args )
{

    $menu = wp_get_nav_menu_object($args->menu);
    $menu_location = $args->theme_location;
    $display = function_exists('get_field') ? get_field('display_menu_title', $menu) : false;
    $footer_locations = ['nav_footer_1','nav_footer_2','nav_footer_3'];

    if ( $display ) {
        $items = '<li class="menu-nav-title">'. $menu->name .'</li>' . $items;
    }
    elseif ( in_array( $menu_location, $footer_locations ) ) {
        $items = '<li class="menu-nav-title mnt-empty">&nbsp;</li>' . $items;
    }

    return $items;
}
add_filter('wp_nav_menu_items', 'theme_display_menu_title', 10, 2);

// Add custom active class in nav menu
function theme_menu_current_class( $classes, $item )
{
    global $post;

    //var_dump($item);

    // if ( is_singular('cookery_recipe') && $item->object === 'cookery_recipe' ) {
    //     $classes[] = 'active';
    // }
    // if ( is_singular('cookery_recipe')  && in_array( 'recipe', $item->classes )  ) {
    //     $classes[] = 'active';
    // }
    // if ( is_singular('product')  && in_array( 'product', $item->classes )  ) {
    //     $classes[] = 'active';
    // }
    // if ( is_archive() && is_tax('dossiers') || is_singular('article_dossier') ) {

    //     if ( in_array( 'fruits-vegetables', $item->classes ) ) {
    //         $classes[] = 'active';
    //     }
    // }

    return $classes;
}

add_action( 'init', 'register_theme_menu' );
add_filter( 'nav_menu_css_class', 'theme_menu_current_class', 10, 2 );
