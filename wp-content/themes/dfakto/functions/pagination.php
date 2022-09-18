<?php

//== Set => $GLOBALS['wp_query'] = $custom_query;
function theme_pagination($new_query = null)
{

    if (isset($new_query)) {
        $GLOBALS['wp_query'] = $new_query;
    }

    $pagination = get_the_posts_pagination(
        array(
            'mid_size'  => 1,
            'screen_reader_text' => ' ',
            'prev_text' => '<span class="nav-prev-text"><i class="fas fa-chevron-left"></i></span>',
            'next_text' => '<span class="nav-next-text"><i class="fas fa-chevron-right"></i></span>',
        )
    );

    if ($pagination) {
        echo $pagination;
    }

    wp_reset_query();
}


function set_pagination_posts_per_page($query)
{

    if ($query->is_tax()) {
        set_query_var('posts_per_page', 2);
    }
}
//add_action( 'pre_get_posts', 'set_pagination_posts_per_page' );
