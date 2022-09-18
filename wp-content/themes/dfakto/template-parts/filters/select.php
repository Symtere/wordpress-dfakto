<?php
$taxonomy = $args && array_key_exists('taxonomy',$args) ? $args['taxonomy'] : '';
$taxonomy_rest_name = $args && array_key_exists('taxonomy_rest_name',$args) ? $args['taxonomy_rest_name'] : $taxonomy;
$filter_title = $args && array_key_exists('filter_title',$args) ? '<div class="filter-by-label">'. $args['filter_title'] .'</div>' : '';
$filter_all_text = $args && array_key_exists('filter_all_text',$args) ? $args['filter_all_text'] : 'Choisir ...';
$aria_filter_by_text = $args && array_key_exists('aria_filter_by_text',$args) ? $args['aria_filter_by_text'] : 'Filtrer';
$terms = $args && array_key_exists('terms',$args) && is_array($args['terms']) && ! is_wp_error($args['terms']) ? $args['terms'] : false;
$limit_by_count = $args && array_key_exists('limit_by_count',$args) ? intval($args['limit_by_count']): 0;
$display_count = $args && array_key_exists('display_count',$args) && $args['display_count'] ? true : false;
$uniqid = uniqid();

if ( $terms ) : ?>
    <div class="filter-by" data-filtertype="select" data-taxonomy="<?php echo esc_attr($taxonomy_rest_name); ?>">
        <?php echo $filter_title; ?>
        <select class="form-select" aria-label="<?php echo $aria_filter_by_text; ?>">
            <option value="" selected><?php echo $filter_all_text; ?></option>
            <?php foreach ($terms as $t) :
                $term_id = esc_attr($uniqid . '-' . $t->term_id);
                $count = esc_attr($t->count);
                $counter = $display_count ? sprintf(' (%s)',$count) : '';

                if ( $count > $limit_by_count ) :
            ?>
                <option value="<?php echo esc_attr($t->term_id); ?>"><?php echo esc_attr($t->name); ?><?php echo $counter; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
<?php endif; ?>
