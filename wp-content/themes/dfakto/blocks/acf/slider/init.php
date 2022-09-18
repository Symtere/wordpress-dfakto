<?php

function register_slider_acf_block_types()
{

    if( function_exists('acf_register_block_type') ) {

        acf_register_block_type(array(
            'name'              => 'slider',
            'title'             => "Slider",
            'description'       => "Slider",
            'category'          => 'theme',
            'icon'              => LOGO_SVG,
            'keywords'          => array( 'custom', 'slider' ),
            'mode'              => 'edit',
            'multiple'          => false,
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
            'render_template' => 'blocks/acf/slider/render.php',
        ));
    }
}
add_action('acf/init', 'register_slider_acf_block_types');
