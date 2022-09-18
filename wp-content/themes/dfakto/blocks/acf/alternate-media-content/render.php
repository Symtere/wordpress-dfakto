<?php
    // set Block to full width, in back office => bloc settings => alignment => alignfull
    $blocks = get_field('mlist_content');

    if ( $blocks ) :

        $blocks_alternate = get_field('mlist_color_choice');
        $alternate_color = get_field('mlist_color_picker');

        if ( $blocks_alternate && $alternate_color ) : ?>
            <style>
                .alternate-media-content:nth-child(even) {
                    background-color: <?php echo $alternate_color; ?>;
                }
            </style>
        <?php endif;

?>
    <div<?php echo function_exists('set_block_attr') ? set_block_attr($block,'alternates-media-content-list') : ''; ?>>

        <?php foreach ($blocks as $item ) : if ( !empty($item) ) :

            $media_type = !empty($item['img_video']) ? esc_attr($item['img_video']) : '';

            $title = !empty($item['title']) ? wp_kses($item['title'],['br'=>[]]) : false;
            $content = !empty($item['content']) ? wp_kses_post($item['content']) : false;

            $img_url = get_acf_array_field($item['img'],'url');
            $img_alt = get_acf_array_field($item['img'],'alt');

            $link_url = get_acf_array_field($item['link'],'url');
            $link_title = get_acf_array_field($item['link'],'title');
            $link_target = get_acf_array_field($item['link'],'target');
        ?>
        <div class="alternate-media-content">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 amc-col-media is-col-media-<?php echo $media_type; ?>">
                        <div class="amc-media is-media-<?php echo $media_type; ?>">
                            <?php if ( $media_type === 'img' && $img_url ) : ?>
                                <img src="<?php echo $img_url; ?>" loading="lazy" alt="<?php echo $img_alt ? $img_alt : ''; ?>">
                            <?php endif; ?>
                            <?php if ( $media_type === 'video' && !empty( $item['video'] ) ) : ?>
                                <div class="ratio ratio-16x9">
                                    <?php echo $item['video']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6 amc-col-content">
                        <div class="amc-content">
                            <?php echo $title ? sprintf('<h4>%s</h4>',$title) : ''; ?>
                            <?php echo $content ? $content : ''; ?>
                            <?php if ( $link_url ) : ?>
                                <a class="btn btn-primary" href="<?php echo $link_url; ?>"<?php echo !empty($link_target) ? ' target="'. $link_target .'"' : ''; ?>>
                                    <?php echo $link_title ? $link_title : "Découvrir"; ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; endforeach; ?>

    </div>

<?php endif; ?>
