<?php

function register_datas_keys_acf_block_types()
{

    if ( function_exists('acf_register_block_type') ) {

        acf_register_block_type(array(
            'name'              => 'datas-keys',
            'title'             => "Chiffres clés",
            'category'          => 'theme',
            'icon'              => LOGO_SVG,
            'keywords'          => array( 'custom', 'chiffres' ),
            'mode'              => 'edit',
            'multiple'          => true, // allows the block to be added multiple times
            'supports'          => [
                'mode' => false,
                'anchor' => true,
                'className' => true,
                'align' => true,
                'alignWide' => true,
                'color' => [
                    'gradients' => true,
                    'background' => true,
                    'text' => false
                ],
            ],
            'render_template' => 'blocks/acf/datas-keys/render.php',
        ));
    }
}
add_action('acf/init', 'register_datas_keys_acf_block_types');
