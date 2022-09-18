<?php /*
    2 possibilities to get block content
    1) Manual way
    2) Automatic way

    ------------

    ESCAPE fields for a better security

    title or string : esc_attr()
    content:
        allow all tags from WP editor => wp_kses_post($my_field)
        allow only br tags => wp_kses($my_field,['br' => []]);
    url : esc_url($my_field)
*/
?>

<?php // 1) Manual way ?>

    <?php
        $my_field = get_field('my_field');

        if ( $my_field ) : ?>
            <div<?php echo function_exists('set_block_attr') ? set_block_attr($block,'my-block-container-class') : ''; ?>>
                <?php function_exists('set_block_container') ? set_block_container($block) : ''; ?>
                    <div class="my-htlm">
                        <?php echo $my_field ? sprintf('<div class="tt">%s</div>',esc_attr($my_field)) : '';?>
                    </div>
                <?php function_exists('set_block_container') ? set_block_container($block,'end') : ''; ?>
            </div>
        <?php endif; ?>

<?php // 2) Automatic way ?>

    <?php
        ob_start();
        $my_field = get_field('my_field');

        if ( $my_field ) : ?>

            <div class="my-htlm">
                <?php echo $my_field ? sprintf('<div class="tt">%s</div>',esc_attr($my_field)) : '';?>
            </div>

        <?php endif; ?>

        <?php
            $content = ob_get_clean();
            set_block_content( $block, $content, 'my-block-container-class' );
        ?>


