<?php

function register_alternate_media_content_acf_block_types()
{

    if ( function_exists('acf_register_block_type') ) {

        acf_register_block_type(array(
            'name'              => 'alternate-media-content',
            'title'             => "Liste media et texte gauche / droite)",
            'description'       => "Image ou vidéo avec texte gauche / droite)",
            'category'          => 'theme',
            'icon'              => LOGO_SVG,
            'keywords'          => array( 'custom', 'media', 'contenu' ), // TODO replace 'custom' by `client-name`
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
            'render_template' => 'blocks/acf/alternate-media-content/render.php',
        ));
    }
}
add_action('acf/init', 'register_alternate_media_content_acf_block_types');
