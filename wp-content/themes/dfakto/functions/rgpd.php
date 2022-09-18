<?php
/*
   Insert RGPD banner and cookie
   ========================================================================== */

function theme_set_rgpd_navbar() {

    if ( !isset( $_COOKIE['site_rgpd'] ) ) {

        ob_start(); ?>

        <div class="rgpd-navbar">
            <div class="container">
                <div class="rgpd-navbar-container">
                    <div class="rgpd-choices">
                        <?php rgpd_nav(); ?>
                        <a class="btn rgpd-close" href="#"><?php echo __( "J'ai compris", 'custom' ); ?></a>
                    </div>
                    <div class="rgpd-content mb-3 mb-md-0">
                        <?php echo __( "En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies pour nous permettre de vous offrir le meilleur service.", 'custom' ); ?>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function setCookie( cname, cvalue, exdays ) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toUTCString();
                document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/';
            }

            let close = document.querySelector('.rgpd-close'),
                rgpbNavbar = document.querySelector('.rgpd-navbar');

            close.addEventListener('click', function(event) {
                event.preventDefault();
                rgpbNavbar.style.display = 'none';
                setCookie('site_rgpd', true, 360);
            });
        </script>

    <?php echo ob_get_clean();

    }
}
add_action( 'wp_footer', 'theme_set_rgpd_navbar', 999 );
