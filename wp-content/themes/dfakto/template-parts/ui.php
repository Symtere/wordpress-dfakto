<div class="bg-dark text-white p-3 my-4 h4 border">Titles</div>
<h1>Lorem ipsum titré h1</h1>
<h2>Lorem ipsum titré h2</h2>
<h3>Lorem ipsum titré h3</h3>
<h4>Lorem ipsum titré h4</h4>
<h5>Lorem ipsum titré h5</h5>
<h6>Lorem ipsum titré h6</h6>

<div class="bg-dark text-white p-3 my-4 h4 border">Typography</div>
<div class="row py-0">
    <div class="col-md-3">
        <b>List ul</b>
        <ul>
            <li>are unaffected by this style</li>
            <li>will still show a bullet</li>
            <li>and have appropriate left margin</li>
        </ul>
    </div>
    <div class="col-md-3">
        <b>List ol</b>
        <ol>
            <li>are unaffected by this style</li>
            <li>will still show a bullet</li>
            <li>and have appropriate left margin</li>
        </ol>
    </div>
    <div class="col-md-6">
        <b>Paragraph && style</b>
        <p>A well-known quote, contained in a blockquote element.</p>
        <p>A well-known quote, contained in a blockquote element.</p>
        <ul>
            <li>are unaffected by this style</li>
            <li>will still show a bullet</li>
            <li>and have appropriate left margin</li>
        </ul>
        <p>A well-known quote, contained in a blockquote element.</p>
        <h3>Lorem ipsum titré h3</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam voluptates perspiciatis,
        iure corrupti porro laudantium sequi veniam, ad qui ullam atque beatae iste vel dolorem maiores fugit ex, dolorum deleniti?</p>
    </div>
</div>

<div class="bg-dark text-white p-3 my-4 h4 border">Buttons - Links - Breadcrumb</div>
<?php
    $breadcrumb_links = sprintf('<a href="%s">%s</a> / <a href="#">Test</a> / %s',esc_url('#'),esc_attr(get_the_title()),'Page active');
?>
<div>
    <?php get_template_part( 'template-parts/breadcrumb', '', [
        'active_page' => $breadcrumb_links,
    ]); ?>
</div>

<a href="">Classic link</a>
<div class="row pt-0 mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="mt-3 mb-4">
            <a href="" class="btn btn-primary">btn-primary</a>
            <div class="mt-2 mb-2 wp-block-button is-style-btn-primary"><a class="wp-block-button__link">is-style-btn-primary</a></div>
            <hr>
            <a href="" class="btn btn-dark">btn-dark</a>
            <div class="mt-2 mb-2 wp-block-button is-style-btn-dark"><a class="wp-block-button__link">is-style-btn-dark</a></div>
            <hr>
            <div class="bg-dark p-4">
                <a href="" class="btn btn-white">btn-white</a>
                <div class="mt-2 wp-block-button is-style-btn-white"><a class="wp-block-button__link">is-style-btn-white</a></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="mt-3 mb-4">
            <a href="" class="btn btn-outline-primary">btn-outline-primary</a>
            <div class="mt-2 mb-2 wp-block-button is-style-btn-outline-primary"><a class="wp-block-button__link">is-style-btn-outline-primary</a></div>
            <hr>
            <a href="" class="btn btn-outline-dark">btn-outline-dark</a>
            <div class="mt-2 mb-2 wp-block-button is-style-btn-outline-dark"><a class="wp-block-button__link">is-style-btn-outline-dark</a></div>
            <hr>
            <div class="bg-dark p-4">
                <a href="" class="btn btn-outline-white">btn-outline-white</a>
                <div class="mt-2 wp-block-button is-style-btn-outline-white"><a class="wp-block-button__link">is-style-btn-outline-white</a></div>
            </div>
        </div>
    </div>
</div>

<?php echo function_exists('get_social_items') ? sprintf('<div class="bg-dark text-white p-3 my-4 h4 border">Social Nav</div>%s', get_social_items()) : ''; ?>
<div class="bg-dark text-white p-3 my-4 h4 border">Contact Map</div>
<div class="mb-4">
    Disponible en shortcode ou en function PHP, administrable en <a href="<?php echo get_admin_url(); ?>post.php?post=347&action=edit">block réutilisable</a>, visible dans la <a href="<?php echo get_the_permalink(329); ?>">page contact</a>.
</div>

<div class="bg-dark text-white p-3 my-4 h4 border">Share This</div>
<div class="mb-4">
    <div class="d-flex">
        <?php get_template_part( 'template-parts/share-this' ); ?>
        <?php get_template_part( 'template-parts/share-this', '', ['title' => 'Partager', 'class_name' => 'ms-auto'] ); ?>
    </div>
</div>

<div class="bg-dark text-white p-3 my-4 h4 border">Loaders</div>
<div class="mb-4">
    <?php get_template_part( 'template-parts/loaders' ); ?>
</div>

<div class="bg-dark text-white p-3 my-4 h4 border">Gutenberg colors palettes</div>
<div class="mb-4">
    <div class="d-flex">
        <?php
            $color_palette = current( (array) get_theme_support( 'editor-color-palette' ) );

            if ($color_palette) {
                foreach ($color_palette as $palette) {
                    printf('<div class="text-center me-2">
                        <div style="color:%2$s">%1$s</div>
                        <div class="d-flex align-items-center justify-content-center flex-column" style="background-color:%2$s;width:90px;height:90px;color:#fff;font-size:.85rem;">%2$s<div>%3$s</div></div>
                        </div>',
                        $palette['name'],
                        $palette['color'],
                        '$'.$palette['slug']
                    );
                }
            }
        ?>
    </div>
</div>
