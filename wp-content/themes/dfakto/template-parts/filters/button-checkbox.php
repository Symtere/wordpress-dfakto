<?php
$taxonomy = $args && array_key_exists('taxonomy',$args) ? $args['taxonomy'] : '';
$taxonomy_rest_name = $args && array_key_exists('taxonomy_rest_name',$args) ? $args['taxonomy_rest_name'] : $taxonomy ;
$filter_title = $args && array_key_exists('filter_title',$args) ? '<div class="filter-by-label">'. $args['filter_title'] .'</div>' : '';
$terms = $args && array_key_exists('terms',$args) && is_array($args['terms']) && ! is_wp_error($args['terms']) ? $args['terms'] : false;
$btn_class = $args && array_key_exists('btn_class',$args) ? $args['btn_class'] : 'btn-outline-primary';
$limit_by_count = $args && array_key_exists('limit_by_count',$args) ? intval($args['limit_by_count']): 0;
$display_count = $args && array_key_exists('display_count',$args) && $args['display_count'] ? true : false;
$display_checkbox_all = $args && array_key_exists('display_checkbox_all',$args) ? true : false;
$uniqid = uniqid();
$taxonomy_id = esc_attr($uniqid . '-' . $taxonomy_rest_name);

if ( $terms ) : ?>
    <div class="filter-by" data-filtertype="button-checkbox" data-taxonomy="<?php echo esc_attr($taxonomy_rest_name); ?>">
        <?php echo $filter_title; ?>
        <?php if ( $display_checkbox_all ) : ?>
            <div class="btn-group form-check-all">
                <input class="btn-check form-check-input form-check-input-all" type="checkbox" name="<?php echo esc_attr($taxonomy_rest_name); ?>[]" id="<?php echo $taxonomy_id; ?>-all" value="" checked>
                <label class="btn <?php echo $btn_class; ?> form-check-label form-check-label-all" for="<?php echo $taxonomy_id; ?>-all">Tout</label>
            </div>
        <?php endif; ?>
        <?php foreach ($terms as $t) :
            $term_id = esc_attr($uniqid . '-' . $t->term_id);
            $count = esc_attr($t->count);
            $counter = $display_count ? sprintf(' (%s)',$count) : '';

            if ( $count > $limit_by_count ) :
        ?>
            <div class="btn-group form-check">
                <input class="btn-check" type="checkbox" id="<?php echo $term_id; ?>" name="<?php echo $term_id; ?>[]" value="<?php echo esc_attr($t->term_id); ?>">
                <label class="btn <?php echo $btn_class; ?>" for="<?php echo $term_id; ?>"><?php echo esc_attr($t->name); ?><?php echo $counter; ?></label>
            </div>
        <?php endif; endforeach; ?>
    </div>
<?php endif; ?>
