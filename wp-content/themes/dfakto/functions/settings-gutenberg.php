<?php

//== Theme gutenberg support
//https://developer.wordpress.org/reference/functions/add_theme_support/

if (!function_exists('we_theme_gut_support')) {
    function we_theme_gut_support()
    {
        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for Block Styles.
        add_theme_support('wp-block-styles');

        // Add support for Editor Styles.
        add_theme_support('editor-styles');

        // Add support for full and wide align images.
        add_theme_support('align-wide');

        // Add support for responsive embedded content.
        add_theme_support('responsive-embeds');

        // Add support for custom line height controls.
        add_theme_support('custom-line-height');

        // Add support for experimental link color control.
        add_theme_support('experimental-link-color');

        // Add support for experimental cover block spacing.
        add_theme_support('custom-spacing');

        // Since WP 5.5.0
        add_theme_support('core-block-patterns');

        // Since WP 5.8
        //add_theme_support( 'block-templates' );

        //$editor_stylesheet = 'style-editor.css';

        // Enqueue editor styles.
        //add_editor_style($editor_stylesheet); // see wp-content/themes/custom/functions/assets.php


        $red_500 = '#FD7762';

        $blue_500 = '#26C1D9';

        $black_700 = '#072038';



        $white_label = esc_attr('Blanc');
        $black_label = esc_attr('Noir');
        $gray_label = esc_attr('Gris');

        $blue_label = esc_attr('Bleu');
        $yellow_label = esc_attr('Jaune');
        $orange_label = esc_attr('Orange');
        $purple_label = esc_attr('Violet');
        $brown_label = esc_attr('Marron');
        $green_label = esc_attr('Vert');
        $red_label = esc_attr('Rouge');

        $light_label = esc_attr(' clair');
        $variant_label = esc_attr(' variant');

        add_theme_support(
            'editor-color-palette',
            array(
                array(
                    'name'  => $blue_label,
                    'slug'  => 'blue-500',
                    'color' => $blue_500,
                ),
                array(
                    'name'  => $red_label,
                    'slug'  => 'red-500',
                    'color' => $red_500,
                ),
                array(
                    'name'  => $black_label,
                    'slug'  => 'black-700',
                    'color' => $black_700,
                ),
            )
        );

        // https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#block-gradient-presets

        // add_theme_support(
        //     'editor-gradient-presets',
        //     array(
        //         array(
        //             'name'     => esc_html('Bleu primaire vers transparent'),
        //             'gradient' => 'linear-gradient(52deg, rgba(16, 66, 152, 0) 0%, rgb(9, 34, 75) 100%)',
        //             'slug'     => 'blue-50deg',
        //         ),
        //     )
        // );
    }
}

add_action('after_setup_theme', 'we_theme_gut_support');



//== Disable Native Gutenberg Features
if (!function_exists('we_theme_gut_dont_support')) {

    function we_theme_gut_dont_support()
    {
        add_theme_support('disable-custom-font-sizes');
        add_theme_support('editor-font-sizes', []);
    }
    add_action('after_setup_theme', 'we_theme_gut_dont_support');
}
