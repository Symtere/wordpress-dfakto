<?php
$pager_prev = $args && array_key_exists('pager_prev',$args) && $args['pager_prev'] ? esc_attr($args['pager_prev']) : '';
$pager_next = $args && array_key_exists('pager_next',$args) && $args['pager_next'] ? esc_attr($args['pager_next']) : '';

$next = get_next_post_link('%link', '<span class="btn btn-primary">'. $pager_prev .'</span>');
$prev = get_previous_post_link('%link', '<span class="btn btn-primary">'. $pager_next .'</span>');

if ( $next || $prev ) : ?>
    <div class="single-pagination center-pagination">
        <?php echo $next ? sprintf('<div class="sp-next">%s</div>',$next) : ''; ?>
        <?php echo ( $next && $prev ) ? '<div class="sp-sep"></div>' : ''; ?>
        <?php echo $prev ? sprintf('<div class="sp-prev">%s</div>',$prev) : ''; ?>
    </div>
<?php endif;
