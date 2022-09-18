<?php

$files = [
    //'taxonomy',
];

foreach ( $files as $file ) {
    require_once get_template_directory() . '/functions/taxonomies/' . $file . '.php';
}