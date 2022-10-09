<?php

$btn_title = $args && array_key_exists('btn_title', $args) && $args['btn_title'] ? esc_attr($args['btn_title']) : '';
$per_page = $args && array_key_exists('per_page', $args) && $args['per_page'] ? esc_attr($args['per_page']) : 3;
$news_page_id = defined('NEWS_PAGE_ID') ? esc_url(get_the_permalink(NEWS_PAGE_ID)) : '#';
$archive_page_id = $args && array_key_exists('archive_page_id', $args) && $args['archive_page_id'] ? esc_url(get_the_permalink($args['archive_page_id'])) : $news_page_id;
$pagination = $args && array_key_exists('pagination', $args) && $args['pagination'] ? true : false;
$has_footer = ($btn_title || $pagination);

$news_query = new WP_Query([
    'posts_per_page' => $per_page,
    'post_type' => 'post',
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
]);

if ($news_query->have_posts()) : ?>
    <div class="news-list">
        <div class="row mt-3 mt-md-5">
            <?php while ($news_query->have_posts()) : $news_query->the_post();
                $post_id = $post->ID;
                $title = esc_attr($post->post_title);
                $excerpt = esc_attr($post->post_excerpt);
                $categories = get_the_terms($post_id, 'category') ? get_the_terms($post_id, 'category') : '';

                $img = get_featured_img($post_id);
                $img_url = $img['url'];
                $img_alt = $img['alt'] ? $img['alt'] : $title;
            ?>
                <div class="news-card-col col-md-6 col-lg-4 mb-3">
                    <article class="news-card-item position-relative">
                        <?php /* ?>
                    <div class="news-card-img">
                        <?php echo $img_url ? sprintf(' <img class="nci-img ci-img" loading="lazy" src="%s" alt="%s">',$img_url,$img_alt) : ''; ?>
                    </div>
                    <?php */ ?>
                        <div class="nci-meta">
                            <div class="nci-meta-wr">
                                <?php if ($categories) { ?>
                                    <div class="nci-categories">
                                        <?php
                                        foreach ($categories as $key => $category) {
                                            echo sprintf('<span class="nci-category">%s</span>', $category->name);
                                        }
                                        ?>
                                    </div>
                                <?php } ?>
                                <div class="nci-title h5">
                                    <?php echo $title; ?>
                                </div>
                                <div class="nci-excerpt"><?php echo $excerpt; ?></div>
                            </div>
                            <div class="nci-post-meta d-flex justify-content-between align-items-center mt-5">
                                <div class="author-avatar-name d-flex align-items-center">
                                    <div class="author-avatar"><?php echo get_avatar($post->post_author) ?: '<img src="/wp-content/uploads/2022/10/avatar.png" alt="avatar" />'; ?></div>
                                    <div class="author-name"><?php echo get_the_author_meta('first_name', $post->post_author) . ' ' . get_the_author_meta('last_name', $post->post_author); ?></div>
                                </div>
                                <a href="<?php echo get_the_permalink(); ?>" class="nci-link stretched-link" rel="bookmark">
                                    <i class="fal fa-arrow-right"></i>
                                </a>

                            </div>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
        </div>
        <?php echo $has_footer ? '<div class="news-list-footer mt-3 text-center">' : '';
        echo $btn_title ? sprintf('<a href="%s" class="mt-4 news-list-btn btn btn-primary">%s</a>', $archive_page_id, $btn_title) : '';
        echo $pagination ? theme_pagination($news_query) : wp_reset_query();
        echo $has_footer ? '</div>' : '';
        ?>
    </div>
<?php endif;
