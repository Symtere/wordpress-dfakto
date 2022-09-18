<?php
    ob_start();

    $datas_keys = get_field('data_keys');

    if ( $datas_keys ) :

        $nb_keys = count($datas_keys);
        $cols = (12 / $nb_keys);
?>
    <div class="row justify-content-center data-keys-nb-<?php echo $nb_keys; ?>">
        <?php foreach ($datas_keys as $key) :
            $link_url = get_acf_array_field($key['link'],'url');
            $link_title = get_acf_array_field($key['link'],'title');
            $link_target = get_acf_array_field($key['link'],'target');
        ?>
            <div class="data-key-col <?php echo $nb_keys == 4 ? 'col-md-6 col-lg-'. $cols : 'col-md-'. $cols; ?>">
                <div class="data-key">
                    <div class="dk-body">
                        <?php echo !empty($key['key']) ? sprintf('<div class="dk-key">%s</div>',$key['key']) : ''; ?>
                        <?php echo !empty($key['content']) ? sprintf('<div class="dk-content">%s</div>',$key['content']) : ''; ?>
                    </div>
                    <?php if ( $link_url ) : ?>
                        <div class="dk-footer">
                            <a class="dk-link btn btn-white"  href="<?php echo $link_url; ?>" title="<?php echo $link_title; ?>"<?php echo $link_target ? ' target="'. $link_target .'"' : ''; ?>">
                                <?php echo $link_title ? $link_title : "Voir"; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php endif;

    $content = ob_get_clean();
    set_block_content( $block, $content, 'datas-keys' );

