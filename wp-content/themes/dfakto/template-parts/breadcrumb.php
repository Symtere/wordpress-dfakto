<?php

$active_page = $args && array_key_exists('active_page',$args) ? ' ' . $args['active_page'] : ' ';
$class_name = $args && array_key_exists('class_name',$args) ? ' ' . $args['class_name'] : ' ';

$breadcrumb = '<!-- wp:group {"className":"breadcrumb-group '. $class_name . '"} -->
<div class="wp-block-group breadcrumb-group'. $class_name . '"><!-- wp:paragraph -->
<p><a href="'. get_site_url() . '">Accueil </a>> '. $active_page .'</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';

echo apply_filters('the_content', $breadcrumb );
