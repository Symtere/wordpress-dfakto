<?php

$files = [
    'settings',
    'assets',
    'helpers',
    'class-wp-bootstrap-navwalker',
    'login',
    'navs-menus',
    'breadcrumb',
    'taxonomies/all',
    'post-types/all',
    'pagination',
    'acf',
    'wpshapere',
    'comments',
    'search',
    //'rgpd',
    //'language',
    //'woocommerce/all',
];

foreach ( $files as $file ) {
    require_once get_template_directory() . '/functions/' . $file . '.php';
}


require_once get_template_directory() . '/blocks/all.php';
