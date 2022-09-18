<?php

/**
 * Set search query
 * @param object $query The main WordPress query.
 */
function we_set_search_query( $query )
{
    if ( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
        $query->set( 'post_type', array( 'page', 'post' ) );
        $query->set( 'showposts',12 );
        $query->set('orderby','title');
        $query->set( 'order','ASC' );
    }
}
add_action( 'pre_get_posts', 'we_set_search_query' );
