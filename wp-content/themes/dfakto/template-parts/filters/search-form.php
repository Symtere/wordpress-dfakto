<?php
    $input_id = $args && array_key_exists('id',$args) ? $args['id'] : uniqid();
    $container_class_name = $args && array_key_exists('container_class_name',$args) ? $args['container_class_name'] : 'search-area';
    $class_name = $args && array_key_exists('class_name',$args) ? $args['class_name'] . ' ' : 'app-search-form ';
    $placeholder = $args && array_key_exists('placeholder',$args) ? $args['placeholder'] : 'Que recherchez-vous ?';
    $autocomplete = $args && array_key_exists('autocomplete',$args) ? $args['autocomplete'] : 'off';
    $autofocus = $args && array_key_exists('autofocus',$args) ? ' autofocus' : '';
    $input_type = $args && array_key_exists('input_type',$args) ? $args['input_type'] : 'search';
    $aria_search_label = $args && array_key_exists('aria_search_label',$args) ? $args['aria_search_label'] : 'Rechercher';
    $aria_submit_label = $args && array_key_exists('aria_submit_label',$args) ? $args['aria_submit_label'] : 'Lancer la recherche';
?>
<div class="<?php echo $container_class_name; ?>">
    <form method="GET" class="<?php echo $class_name; ?> form-group" action="<?php echo get_the_permalink(); ?>">
        <label class="sa-label sr-only" for="<?php echo $input_id; ?>-input"><?php echo $aria_search_label; ?></label>
        <input id="<?php echo $input_id; ?>-input" class="form-control" name="search-input" type="<?php echo $input_type; ?>" placeholder="<?php echo $placeholder; ?>" autocomplete="<?php echo $autocomplete; ?>"<?php echo $autofocus; ?> >
        <button class="btn btn-primary" type="submit" aria-label="<?php echo $aria_submit_label; ?>">
            <i class="far fa-search"></i>
            <span class="d-none spinner-grow spinner-grow-sm text-primary" role="status"></span>
        </button>
    </form>
</div>
