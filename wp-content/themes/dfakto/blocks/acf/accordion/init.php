<?php

function register_accordion_acf_block_types()
{

    if ( function_exists('acf_register_block_type') ) {

        acf_register_block_type(array(
            'name'              => 'accordion',
            'title'             => "Accordion",
            'description'       => "Accordion",
            'category'          => 'theme',
            'icon'              => LOGO_SVG,
            'keywords'          => array( 'custom', 'accordion' ),
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
            'render_template' => 'blocks/acf/accordion/render.php',
        ));
    }
}
add_action('acf/init', 'register_accordion_acf_block_types');
