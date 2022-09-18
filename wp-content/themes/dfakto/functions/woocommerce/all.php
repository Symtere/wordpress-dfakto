<?php

if ( class_exists( 'woocommerce' ) ) {

    $woo_files = [
        'settings',
        'text',
        'forms',
        'single',
    ];

    foreach ( $woo_files as $woo_file ) {
        require_once get_template_directory() . '/functions/woocommerce/' . $woo_file . '.php';
    }
}
