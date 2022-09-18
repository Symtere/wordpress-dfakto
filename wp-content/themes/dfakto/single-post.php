<?php get_header(); ?>

    <div class="single-post-page page-content">
        <div class="container single-container">
            <?php while ( have_posts() ) : the_post();
                    $post_id = get_the_id();
                    $post_title = esc_attr(get_the_title());
                    $banner_post_img = get_field('banner_img');
                    $post_archive_link = defined('NEWS_PAGE_ID') ? esc_url(get_the_permalink(NEWS_PAGE_ID)) : '#';
                    $post_archive_text = 'Retour';
                    $back_link = sprintf('<a class="single-back-link" href="%s" title="%s">%s</a>',$post_archive_link,$post_archive_text,$post_archive_text);
                    //d($banner_post_img);
                ?>
                <div class="single-cover-container">
                    <?php get_template_part( 'template-parts/banner', '', [
                        'img_url' => $banner_post_img ? $banner_post_img['url'] : '',
                        'img_alt' =>  $banner_post_img ? $banner_post_img['alt'] : 'Actualités',
                        // 'title_tag' => 'h2',
                        // 'title_class' => 'h1',
                        // 'title' => 'Actualités',
                        'height' => 300,
                    ]); ?>
                </div>
                <div class="single-post-container">
                    <div class="single-post-meta text-white">
                        <?php echo $back_link; ?>
                        <h1 class="h2 text-uppercase"><?php echo $post_title; ?></h1>
                        <span><?php the_date('d/m/Y'); ?></span>
                    </div>
                    <div class="single-post-content">
                        <?php the_content(); ?>
                    </div>
                    <?php get_template_part( 'template-parts/single-pagination', '', [
                        'pager_prev' => 'Actualité suivante', // Wp pagination is reversed ....
                        'pager_next' => 'Actualité précédente', // Wp pagination is reversed ....
                        //'has_sep' => true,
                        //'pager_class'= > 'my-class' // default `center-pagination`
                    ]); ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

<?php get_footer();
