<?php

function we_register_blocks_patterns()
{
    $namespace = 'custom-patterns';

    // Add new pattern category
    register_block_pattern_category(
        $namespace, [ 'label' => '🚀 Custom' ],
    );

    register_block_pattern(
        'custom/breadcrumb',
        [
            'title' => "🧶 Fil d'ariane",
            'categories' => [ $namespace ],
            'keywords' => [ 'custom', 'breadcrumb', 'navigation', 'ariane' ],
            'content' => '<!-- wp:group {"className":"breadcrumb-group"} -->
            <div class="wp-block-group breadcrumb-group"><!-- wp:paragraph -->
            <p><a href="'. get_site_url() . '" data-type="page" data-id="2">Accueil </a>/ Lorem ipsum</p>
            <!-- /wp:paragraph --></div>
            <!-- /wp:group -->'
        ],
    );
    register_block_pattern(
        'custom/text-and-image',
        [
            'title' => '🖼️ Texte et image',
            'categories' => [ $namespace ],
            'keywords' => [ 'custom', "contenu" ],
            'content' => '<!-- wp:columns {"className":"txt-and-media-row"} -->
            <div class="wp-block-columns txt-and-media-row"><!-- wp:column {"verticalAlignment":"center"} -->
            <div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"style":{"typography":{"textTransform":"uppercase"}}} -->
            <h2 style="text-transform:uppercase">Titre</h2>
            <!-- /wp:heading -->
            <!-- wp:paragraph -->
            <p>Lorem ipsum dolores</p>
            <!-- /wp:paragraph -->
            <!-- wp:buttons -->
            <div class="wp-block-buttons"><!-- wp:button -->
            <div class="wp-block-button"><a class="wp-block-button__link" href="">En savoir plus</a></div>
            <!-- /wp:button --></div>
            <!-- /wp:buttons --></div>
            <!-- /wp:column -->
            <!-- wp:column -->
            <div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
            <figure class="wp-block-image size-full"><img src="" alt=""/></figure>
            <!-- /wp:image --></div>
            <!-- /wp:column --></div>
            <!-- /wp:columns -->
            '
        ],
    );
}
add_action( 'init', 'we_register_blocks_patterns' );
