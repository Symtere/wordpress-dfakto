<?php get_header(); ?>

    <div class="container search-container">
        <div class="no-page-banner-first">
            <div class="main-page-search page-content">
                <h3 class="search-result-title text-center text-primary text-uppercase mt-md-5">
                    <?php
                    $results_nb = (int) $wp_query->found_posts;
                    $search_content = get_search_query();

                    if ($results_nb > 1) {
                        $results_txt = __(' résultats trouvés pour : ', 'theme');
                    } else {
                        $results_txt = __(' résultat trouvé pour :  ', 'theme');
                    }
                    ?>
                    <?php echo '<span>' . $results_nb . '</span>' . ' ' . $results_txt . '<span>' . $search_content .'</span>'; ?>
                </h3>
                <div class="search-result-section pt-5 pb-5">
                    <?php if (have_posts()) : ?>
                        <div class="search-result-list">
                            <?php while (have_posts()) : the_post(); ?>
                                <div class="search-result-item">
                                    <div class="sri-title">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="justify-content-center-pagination">
                            <?php theme_pagination(); ?>
                        </div>
                    <?php else : ?>
                        <div class="search-result-list">
                            <?php echo __('Pas de contenu', 'theme'); ?>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer();
