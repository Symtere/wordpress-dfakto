<?php
$taxonomy = $args && array_key_exists('taxonomy',$args) ? $args['taxonomy'] : '';
$taxonomy_rest_name = $args && array_key_exists('taxonomy_rest_name',$args) ? $args['taxonomy_rest_name'] : $taxonomy ;
$filter_title = $args && array_key_exists('filter_title',$args) ? '<div class="filter-by-label">'. $args['filter_title'] .'</div>' : '';
$terms = $args && array_key_exists('terms',$args) && is_array($args['terms']) && ! is_wp_error($args['terms']) ? $args['terms'] : false;
$limit_by_count = $args && array_key_exists('limit_by_count',$args) ? intval($args['limit_by_count']): 0;
$display_count = $args && array_key_exists('display_count',$args) && $args['display_count'] ? true : false;
$uniqid = uniqid();
$taxonomy_id = esc_attr($uniqid . '-' . $taxonomy_rest_name);
//d($terms);

if ( $terms ) : ?>
    <div class="filter-by" data-filtertype="radio" data-taxonomy="<?php echo esc_attr($taxonomy_rest_name); ?>">
        <?php echo $filter_title; ?>
        <?php $i = 0; foreach ($terms as $t) :
            $term_id = esc_attr($uniqid . '-' . $t->term_id);
            $count = esc_attr($t->count);
            $counter = $display_count ? sprintf(' (%s)',$count) : '';

            if ( $count > $limit_by_count ) :
                $i++;
        ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="<?php echo $term_id; ?>" name="<?php echo esc_attr($uniqid); ?>" value="<?php echo esc_attr($t->term_id); ?>"<?php echo $i == 1 ? ' checked' : ''; ?>>
                <label class="form-check-label" for="<?php echo $term_id; ?>"><?php echo esc_attr($t->name); ?><?php echo $counter; ?></label>
            </div>
        <?php endif; endforeach; ?>
    </div>
<?php endif; ?>
