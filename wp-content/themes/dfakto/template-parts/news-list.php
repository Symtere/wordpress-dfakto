<?php

$btn_title = $args && array_key_exists('btn_title',$args) && $args['btn_title'] ? esc_attr($args['btn_title']) : '';
$per_page = $args && array_key_exists('per_page',$args) && $args['per_page'] ? esc_attr($args['per_page']) : 3;
$news_page_id = defined('NEWS_PAGE_ID') ? esc_url(get_the_permalink(NEWS_PAGE_ID)) : '#';
$archive_page_id = $args && array_key_exists('archive_page_id',$args) && $args['archive_page_id'] ? esc_url(get_the_permalink($args['archive_page_id'])) : $news_page_id;
$pagination = $args && array_key_exists('pagination',$args) && $args['pagination'] ? true : false;
$has_footer = ($btn_title || $pagination);

$news_query = new WP_Query([
    'posts_per_page' => $per_page,
    'post_type' => 'post',
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
]);

if ( $news_query->have_posts() ) : ?>
    <div class="news-list">
        <div class="row mt-3 mt-md-5">
            <?php while ( $news_query->have_posts() ) : $news_query->the_post();
                $post_id = $post->ID;
                $title = esc_attr($post->post_title);

                $img = get_featured_img($post_id);
                $img_url = $img['url'];
                $img_alt = $img['alt'] ? $img['alt'] : $title;
            ?>
            <div class="news-card-col col-md-6 col-lg-4">
                <article class="news-card-item position-relative">
                    <div class="news-card-img">
                        <?php echo $img_url ? sprintf(' <img class="nci-img ci-img" loading="lazy" src="%s" alt="%s">',$img_url,$img_alt) : ''; ?>
                    </div>
                    <div class="nci-meta">
                        <div class="nci-meta-wr">
                            <div class="nci-title">
                                <a href="<?php echo get_the_permalink(); ?>" class="nci-link stretched-link" rel="bookmark">
                                    <?php echo $title; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <?php endwhile; ?>
        </div>
         <?php echo $has_footer ? '<div class="news-list-footer mt-3">' : '';
            echo $btn_title ? sprintf('<a href="%s" class="mt-4 news-list-btn btn btn-primary">%s</a></div>',$archive_page_id ,$btn_title) : '';
            echo $pagination ? theme_pagination($news_query) : wp_reset_query();
            echo $has_footer ? '</div>' : '';
        ?>
    </div>
<?php endif;
