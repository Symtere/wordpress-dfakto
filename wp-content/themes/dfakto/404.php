<?php get_header(); ?>
    <div class="container main-container">
        <div class="no-page-banner-first">
            <div class="text-center page-404-content d-flex align-items-center justify-content-center">
                <div>
                    <h1 class="mb-5 text-primary text-uppercase"><i class="fa-solid fa-cloud-exclamation"></i> <?php echo __( 'Page non trouvée','custom' ); ?></h1>
                    <p class="mb-5 h4"><?php echo __( "Le contenu que vous recherchez n'est pas disponible ou a été supprimé", 'custom' ); ?></p>
                    <a href="<?php echo home_url(); ?>" class="btn btn-primary">
                        <span><?php echo __( "Revenir à l'accueil", 'custom' ); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php get_footer();
