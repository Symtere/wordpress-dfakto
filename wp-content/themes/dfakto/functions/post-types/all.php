<?php

$files = [
    // 'team',
    // 'partners',
];

foreach ( $files as $file ) {
    require_once get_template_directory() . '/functions/post-types/' . $file . '.php';
}
