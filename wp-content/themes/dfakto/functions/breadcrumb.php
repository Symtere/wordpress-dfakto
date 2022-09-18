<?php

function theme_breadcrumb() {
    global $post;

    $locs = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object( $locs['main_menu'] );

    $page_breadcrumb = get_field( 'breadcrumb' );

    if ( isset( $page_breadcrumb ) && !empty( $page_breadcrumb ) ) {

        echo '<div class="breadcrumbs">'. $page_breadcrumb .'</div>';
    }
    elseif ( $menu ) {

        $items = wp_get_nav_menu_items( $menu->term_id );

        foreach ( $items as $k => $v ) {

            if ( $items[$k]->object_id == $post->ID ) {
                $current_menu_name = $items[$k]->title;
                $current_menu_id = $items[$k]->ID;
                $parent_menu_id = $items[$k]->menu_item_parent;
                break;
            }
        }
        if ( isset ( $parent_menu_id ) || isset( $current_menu_name) ) {

            $parent_menu_name = get_post( $parent_menu_id )->post_title;

            if ( ( $parent_menu_id == $current_menu_id ) || ( $parent_menu_id == '0' ) ) {
                $breadcrumb = $current_menu_name;
            }
            else {
                $breadcrumb = $parent_menu_name .' > '. $current_menu_name;
            }

            echo '<div class="breadcrumbs">'. $breadcrumb .'</div>';
        }
    }
    else {
       
    }
}
