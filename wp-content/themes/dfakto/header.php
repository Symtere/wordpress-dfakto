<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta http-equiv="Content-Security-Policy" content="base-uri 'self'">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div class="main-wrapper">
        <header id="header" class="site-header">
            <div class="container">
                <div class="header-wr d-flex justify-content-between align-items-center">
                    <div class="brand-header">
                        <a class="navbar-brand" href="<?php echo site_url(); ?>">
                            <?php echo function_exists('get_acf_logo_header') ? get_acf_logo_header() : ''; ?>
                        </a>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-dark d-none d-xl-flex">
                        <?php echo function_exists('header_nav') ? header_nav() : ''; ?>
                    </nav>
                    <?php //echo function_exists('languages_list_header') ? languages_list_header() : ''; ?>
                    <?php echo function_exists('weglot_languages_list_header') ? weglot_languages_list_header() : ''; ?>
                    <div class="aside-nav-wr d-xl-none">
                        <button class="aside-menu-toggler btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#aside-menu" aria-controls="aside-menu" aria-label="<?php echo __( 'Navigation', 'custom' ); ?>">
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <main id="main" class="site-main">
