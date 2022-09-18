<div class="loader-row">
    <?php
        $loaders = [
            'grid', 'audio', 'rings', 'oval', 'three-dots', 'spinning-circles',
            'puff', 'circles', 'tail-spin', 'bars', 'ball-triangle'
        ];
        $i = 0; foreach ($loaders as $loader) {
            printf('<div class="lr-item "><div class="lri-title">%s</div><img class="lri-img" src="%s" alt=""></div>',$loader . '.svg',get_loader_url($loader . '.svg'));
        }
    ?>
</div>
