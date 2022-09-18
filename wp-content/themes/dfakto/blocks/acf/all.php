<?php

$blocks = [
    'alternate-media-content',
    'slider',
    'datas-keys',
    'accordion',
];

foreach ( $blocks as $block ) {
    require_once get_template_directory() . '/blocks/acf/' . $block . '/init.php';
}
