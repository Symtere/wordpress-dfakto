<?php
    ob_start();

    $icons_texts = get_field('icon_and_text');

    if ( $icons_texts ) :

?>
    <div class="row justify-content-center ">
        <?php foreach ($icons_texts as $icon_text) :
            $icon = $icon_text['icon'];
            $text = $icon_text['text'];
        ?>
            <div class="icon-text-col">
                <div class="icon-text">
                    <div class="it-icon">
                        <?php echo $icon ? $icon : ""; ?>
                    </div>
                    <div class="it-text">
                        <?php echo $text ? $text : ""; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php endif;

    $content = ob_get_clean();
    set_block_content( $block, $content, 'icons-texts' );

