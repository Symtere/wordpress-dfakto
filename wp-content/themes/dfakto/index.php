<?php

    /* Template Name: Homepage */

    get_header(); ?>

    <div class="index-page page-content">
        <div class="container main-container">
            <?php while ( have_posts() ) : the_post();
                the_content();
            ?>
            <?php endwhile; ?>
            <?php get_template_part( 'template-parts/ui', ''); ?>
        </div>
    </div>

<?php get_footer();
