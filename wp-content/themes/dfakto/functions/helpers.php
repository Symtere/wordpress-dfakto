<?php


/*
   Debug
   ========================================================================== */

ini_set("xdebug.var_display_max_children", '-1');
ini_set("xdebug.var_display_max_data", '-1');
ini_set("xdebug.var_display_max_depth", '-1');

function dd($dump)
{
    var_dump($dump);
    die;
}
function d($dump)
{
    var_dump($dump);
}
function dp($dump)
{
    echo '<pre>';
    var_dump($dump);
    echo '</pre>';
}


/*
   Assets
   ========================================================================== */


function get_asset_version($file_path)
{
    return date('ymdGis', filemtime( $file_path ));
}

/**
 * assets function
 * Return file path by folder,
 *
 * @param string $type
 * @param string $content
 * @return string
 */
function assets( $type, $content )
{
    return esc_url(get_template_directory_uri() . '/assets/' . $type . '/'. $content);
}

// Img
function get_img_url( $content )
{
    return assets( 'img', $content );
}
function img_url( $content )
{
    echo assets( 'img', $content );
}

// SVG
function get_svg_url( $content )
{
    return assets( 'svg', $content );
}
function svg_url( $content )
{
    echo assets( 'svg', $content );
}

// Loaders
function get_loader_url( $content )
{
    return assets( 'svg/loaders', $content );
}
function loader_url( $content )
{
    echo assets( 'svg/loaders', $content );
}

// Font
function get_font_url( $content )
{
    return assets( 'fonts', $content );
}
function font_url( $content )
{
    echo assets( 'fonts', $content );
}

// JS
function get_js_url( $content )
{
    return assets( 'js', $content );
}
function js_url( $content )
{
    echo assets( 'js', $content );
}

// CSS
function get_css_url( $content )
{
    return assets( 'css', $content );
}
function css_url( $content )
{
    echo assets( 'css', $content );
}

// Lib
function get_lib_url( $content )
{
    return assets( 'lib', $content );
}

// Shortcodes
function get_shortcode_dir($file)
{
    return get_theme_file_uri('functions/shortcodes/' . $file);
}

/*
   Logos && favicons
   ========================================================================== */

/**
 * Admin logos and favicon by ACF or WP customizer
 * !! ACF => see functions/acf.php and uncomment favicon add_action
 */


// WP customizer

// Favicon
function set_favicon()
{
    $favicon = get_img_url('favicon.png');

    if ( has_site_icon() ) {
        wp_site_icon();
    }
    else {
        echo '<link rel="icon" type="image/png" href="' . esc_url( $favicon ) . '" />';
    }
}
// add_action( 'wp_head', 'set_favicon' );
// add_action( 'login_head', 'set_favicon' );
// add_action( 'admin_head', 'set_favicon' );

// Logo header
function get_logo()
{
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    $logo_url = has_custom_logo() ? esc_url( $logo[0] ) : get_svg_url('logo.svg');

    return '<img class="brand-h-logo img-fluid" loading="eager" src="' . $logo_url . '" alt="' . get_bloginfo( 'name' ) . '">';
}

// Logo footer
function get_logo_footer()
{
    $custom_logo = get_theme_mod( 'logo_footer' );
    $custom_logo_id = attachment_url_to_postid($custom_logo);
    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    $logo_url = null != $logo && !is_wp_error($logo) ? esc_url( $logo[0] ) : get_svg_url('logo-footer.svg');

    return '<img class="brand-f-logo img-fluid" loading="lazy" src="' . $logo_url . '" alt="' . get_bloginfo( 'name' ) . '">';
}

//== Theme customizer
function theme_customizer($wp_customize)
{

    $wp_customize->remove_control( 'custom_css' ); // remove custom css possibility

    $wp_customize->add_setting('logo_footer', array( // add logo footer
        'sanitize_callback' => 'esc_url_raw'
        //'default' => 'Ajouter un logo',
    ));

    // https://developer.wordpress.org/reference/classes/wp_customize_cropped_image_control/
    $wp_customize->add_control(
        new WP_Customize_Cropped_Image_Control( $wp_customize, 'logo_footer',
            [
                'label' => 'Logo footer',
                'section' => 'title_tagline',
                'settings' => 'logo_footer',
                'flex_width' => true,
                'flex_height' => true,
                'priority' => 9,
            ]
        )
    );
    /*
    //adding section in wordpress customizer
    $wp_customize->add_section('copyright_extras_section', array(
        'title' => 'Copyright Text Section'
    ));

    //adding setting for copyright text
    $wp_customize->add_setting('text_setting', array(
        'default'  => 'Default Text For copyright Section',
    ));

    $wp_customize->add_control('text_setting', array(
        'label'   => 'Copyright text',
        'section' => 'copyright_extras_section',
        'type'    => 'text',
    ));
    */
}
add_action('customize_register', 'theme_customizer');


/*
   Template page
   ========================================================================== */

// Get page by template file name
function get_pages_by_template_file( $page_template_filename )
{
    return get_pages( array(
        'meta_key' => '_wp_page_template',
        'meta_value' => $page_template_filename
    ));
}

// Remove html tags and trim text
function theme_excerpt( $text, $num_words = 55, $more = ' [...]' )
{
    $content = strip_tags( $text );
    return wp_trim_words( $content, $num_words, $more );
}


/*
   Terms
   ========================================================================== */

/**
 * get_imploded_terms function
 * Return implode term separated by ,
 *
 * @param int $post_id
 * @param string $taxonomy
 * @param string $separator
 * @return string|false
 */
function get_imploded_terms($post_id, $taxonomy, $separator = ', ')
{
    $terms = get_the_terms($post_id, $taxonomy);
    $terms_name = [];

    if (!is_wp_error($terms) && isset($terms) && !empty($terms)) {

        foreach ($terms as $term) {
            $terms_name[] = $term->name;
        }
    }
    $terms_name = !empty($terms_name) ? implode($separator, $terms_name) : false;

    return $terms_name;
}

/**
 * get_terms_by_id function
 * Return array of terms
 *
 * @param int $post_id
 * @param string $taxonomy
 * @return array
 */
function get_terms_by_id($post_id, $taxonomy)
{
    $terms = get_the_terms($post_id, $taxonomy);
    $terms_id = (array) [];

    if ( $terms && !empty($terms) && !is_wp_error($terms) ) {

        foreach ($terms as $term) {
            $terms_id[] = (integer) intval($term->term_id);
        }
    }

    return $terms_id;
}

/**
 * get_rest_terms function
 * Return array of terms for custom REST API
 *
 * @param int $post_id
 * @param string $taxonomy
 * @return array
 */
function get_rest_terms($id,$taxonomy)
{
    $get_terms = get_the_terms($id,$taxonomy);
    $terms = (array) [];

    if ( $get_terms && !is_wp_error($get_terms) ) {

        foreach ($get_terms as $key => $term) {

            $terms[$key]['id'] = (int) esc_attr($term->term_id);
            $terms[$key]['name'] = (string) esc_attr($term->name);
            //$terms[$key]['slug'] = (string) esc_attr($term->slug);
        }
    }

    return $terms;
}



/*
   Images
   ========================================================================== */

/**
 * Image attributes by ID
 *
 * @param integer|string $id
 * @return array
 */
function img_attributes($id)
{
    return [
        'id' => $id,
        'url' => wp_get_attachment_image_url($id),
        'alt' => get_post_meta( $id, '_wp_attachment_image_alt', true),
    ];
}

/**
 * Featured Image
 * Return array with url and alt
 * @param integer|string $id
 * @param string $size
 * @param string $default_url (default img in assets/img)
 * @return array
 */
function get_featured_img($id, $size = 'full', $default_url = 'default-img.gif')
{
    $field = (array) [];

    $img_id = get_post_thumbnail_id($id);

    $img_url = wp_get_attachment_image_src( $img_id , $size );
    $img_alt = get_post_meta( $img_id , '_wp_attachment_image_alt', true);

    $field['url'] = $img_url ? (string) esc_url($img_url[0]) : get_img_url($default_url);
    $field['alt'] = $img_alt ? (string) esc_attr($img_alt) : '';

    return $field;
}


/*
   Array
   ========================================================================== */

/**
 * check_array function
 *
 * @param string $key
 * @param array $arr
 * @return boolean
 */
function check_array($key, $arr)
{
    if ( is_array($arr) && array_key_exists($key,$arr) && !empty($arr[$key]) ) {
        return true;
    }
    return false;
}


/*
   Check if core-cover exists and is first entry of post_content
   ========================================================================== */

function page_has_core_cover_first()
{
    global $post;

    $post_content = $post->post_content;

    if ( $post_content && !empty($post_content) ) {

        $content = parse_blocks($post_content);

        if ( !empty($content) ) {

            if ( !empty($content[0]) && array_key_exists('blockName',$content[0]) ) {
                $has_core_cover = $content[0]['blockName'] === 'core/cover' ? true : false;
            }
        }
    }

    if ( isset($has_core_cover) && $has_core_cover ) {
        the_content();
    }
    else {
        printf('<div class="no-page-banner-first">%s</div>', apply_filters('the_content', get_the_content()) );
    }
}


/*
   Blocks
   ========================================================================== */

/**
 * render_block_by_id function
 *
 * @param integer $id
 * @return string
 */

function render_block_by_id($id)
{
    $block = get_post($id);
    echo $block ? apply_filters('the_content', $block->post_content) : '';
}


/*
   Set custom content before _content
   ========================================================================== */

function set_custom_content_before()
{
    // if ( is_cart() || is_checkout() ) {
    //     echo get_block(783); // get custom gutenberg reusable block by ID
    // }
}
//add_action('theme_before_page_content','set_custom_content_before');


/*
   Set custom content after _content
   ========================================================================== */

function set_custom_content_after()
{

}
//add_action('theme_after_page_content','set_custom_content_after');
