<?php

if ( $args && array_key_exists('img_id',$args) && $args['img_id'] ) {
    $banner_img_url = esc_url(wp_get_attachment_url( $args['img_id'] ));
}
elseif ( $args && array_key_exists('img_url',$args) && $args['img_url'] ) {
    $banner_img_url = esc_url($args['img_url']);
}
else {
    $banner_img_url = get_img_url('default-banner.jpg');
}
$title_arg = $args && array_key_exists('title',$args) && $args['title'] ? esc_attr($args['title']) : '';
$title_tag = $args && array_key_exists('title_tag',$args) && $args['title_tag'] ? esc_attr($args['title_tag']) : 'h1';
$title_class = $args && array_key_exists('title_class',$args) && $args['title_class'] ? esc_attr($args['title_class']) . ' ' : '';
$banner_height = $args && array_key_exists('height',$args) && $args['height'] ? esc_attr($args['height']) : '500';
$banner_img_alt = $args && array_key_exists('img_alt',$args) && $args['img_alt'] ? esc_attr($args['img_alt']) : $title_arg;
$breadcrumb_arg = $args && array_key_exists('breadcrumb',$args) && $args['breadcrumb'] ? $args['breadcrumb'] : '';
$opacity = $args && array_key_exists('opacity',$args) && $args['opacity'] ? $args['opacity'] : '0';
$background_color = $args && array_key_exists('background_color',$args) && $args['background_color'] ? ' style="background-color:'. $args['background_color'] .'"' : '';
$background_gradient = $args && array_key_exists('background_gradient',$args) && $args['background_gradient'] ? ' style="background:'. $args['background_gradient'] .'"' : '';
$background_gradient_class = $background_gradient ? ' wp-block-cover__gradient-background has-background-gradient' : '';

$title_html = '<!-- wp:heading {"style":{"typography":{"textTransform":"uppercase"}},"textColor":"white"} -->
<'. $title_tag .' class="'. $title_class . 'has-white-color has-text-color" style="text-transform:uppercase">'. $title_arg .'</'. $title_tag .'><!-- /wp:heading -->';
$title = $title_arg ? $title_html : '';

$img = '<img class="wp-block-cover__image-background" alt="'. $banner_img_alt .'" src="'. $banner_img_url .'" data-object-fit="cover"/>';

$breadcrumb_html = '<!-- wp:group {"className":"breadcrumb-group"} -->
<div class="wp-block-group breadcrumb-group"><!-- wp:paragraph -->
<p><a href="'. get_site_url() .'" data-type="page" data-id="2">Accueil </a>/ '. $breadcrumb_arg .'</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';

$breadcrumb = $breadcrumb_arg ? $breadcrumb_html : '';

$banner = '<!-- wp:cover {"url":"'. $banner_img_url .'","dimRatio":'. $opacity  .',"minHeight":'.  $banner_height . ',"isDark":false,"align":"full"} -->
<div class="wp-block-cover alignfull is-light" style="min-height:'.  $banner_height . 'px;">
<span aria-hidden="true" class="wp-block-cover__background has-background-dim has-background-dim-'. $opacity  . $background_gradient_class .'"'. $background_color . $background_gradient .'></span>
' . $img . '
<div class="wp-block-cover__inner-container">
' . $title_html . $breadcrumb .'
</div></div>
<!-- /wp:cover -->';

//dd($banner);

echo apply_filters('the_content', $banner);
