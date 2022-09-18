<div id="aside-menu" class="aside-menu offcanvas offcanvas-start" tabindex="-1" aria-labelledby="aside-menu-label">
    <div class="offcanvas-header justify-content-end">
        <h5 id="aside-menu-label" class="sr-only">Navigation</h5>
        <button type="button" class="aside-menu-btn-close btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <?php //echo function_exists('get_acf_logo_header') ? sprintf('<a href="%s" title="Accueil">%s</a>',get_site_url(),get_acf_logo_header('lazy')) : ''; ?>
    </div>
    <div class="offcanvas-body">
        <div class="aside-menu-container d-flex">
            <?php echo function_exists('header_nav') ? header_nav('aside-nav') : ''; ?>
        </div>
    </div>
</div>
