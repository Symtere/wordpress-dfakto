<?php

$shortcodes = [
    'contact-map',
    'news-list',
];

foreach ( $shortcodes as $shortcode ) {
    require_once get_template_directory() . '/blocks/shortcodes/' . $shortcode . '.php';
}
