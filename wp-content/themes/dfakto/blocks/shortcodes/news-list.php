<?php

function news_list_shortcode($atts)
{
    ob_start();

    $atts = shortcode_atts(
        [
            'btn_title' => '',
            'archive_page_id' => '',
            'per_page' => '',
            'pagination' => '',
        ],
        $atts
    );

    get_template_part( 'template-parts/news-list', '', [
        'btn_title' => esc_attr($atts['btn_title']),
        'per_page' => esc_attr($atts['per_page']),
        'archive_page_id' => esc_attr($atts['archive_page_id']),
        'pagination' => esc_attr($atts['pagination']),
    ]);

    $content = ob_get_clean();
    return $content;
}

add_shortcode( 'news-list', 'news_list_shortcode' );
