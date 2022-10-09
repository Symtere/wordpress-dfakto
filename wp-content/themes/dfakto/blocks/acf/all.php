<?php

$blocks = [
    'alternate-media-content',
    'slider',
    'datas-keys',
    'accordion',
    'icon-text',
    'testimonial',
];

foreach ( $blocks as $block ) {
    require_once get_template_directory() . '/blocks/acf/' . $block . '/init.php';
}
