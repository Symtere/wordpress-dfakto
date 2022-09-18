<?php


/*
   WP Shapere
   ========================================================================== */

function custom_wpshapere_css() { ?>

    <style type='text/css'>
        #adminmenu .wp-submenu, .folded #adminmenu .wp-has-current-submenu .wp-submenu,
        .folded #adminmenu a.wp-has-current-submenu:focus+.wp-submenu {
            padding: 7px 0 8px;
        }
        #adminmenu .wp-has-current-submenu ul>li>a,
        .folded #adminmenu li.menu-top .wp-submenu>li>a,
        #adminmenu .wp-submenu a {
            padding: 5px 12px;
        }
        #adminmenu .wp-submenu-head,
        #adminmenu a.menu-top {
            padding: 0;
        }
        .wp-not-current-submenu.wp-menu-separator {

        }
        #collapse-button {
            margin: 0;
        }
        .wp-core-ui .button-primary, .postbox,.wp-core-ui .button-primary.focus,
        .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover,
        .wp-core-ui .button, .wp-core-ui .button-secondary, .wp-core-ui .button-secondary:focus,
        .wp-core-ui .button-secondary:hover, .wp-core-ui .button.focus, .wp-core-ui .button.hover,
        .wp-core-ui .button:focus, .wp-core-ui .button:hover, #wpadminbar .menupop .ab-sub-wrapper,
        #wpadminbar .shortlink-input, .theme-browser .theme {
            border: 1px solid #ccd0d4 !important;
        }
        .menu.ui-sortable .menu-item-handle, .meta-box-sortables.ui-sortable .hndle, .sortUls div.menu_handle, .wp-list-table thead, .menu-item-handle, .widget .widget-top {
            background-color: #fff !important;
        }
        #wpadminbar .quicklinks .ab-sub-wrapper {
            background: #0f6bab !important;
            border: 0 !important;
        }
        #wpadminbar .quicklinks .ab-sub-wrapper .ab-item {
            color: #fff !important;
        }
        #wpadminbar .quicklinks .ab-sub-wrapper .ab-item:hover {
            color: #c5e1ef !important;
        }
        .menu.ui-sortable .menu-item-handle {
            border: 1px solid #dcdcde !important;
        }
        .meta-box-sortables.ui-sortable .hndle, .sortUls div.menu_handle, .wp-list-table thead, .menu-item-handle, .widget .widget-top {
            border: 0 !important;
        }
        .acf-flexible-content .layout .acf-fc-layout-order {
            background:#1ea8ed;color: #fff;
        }
        .acf-flexible-content .layout .acf-fc-layout-handle {
            background: #fbfbfb;
        }
    </style>
<?php }

add_action( 'admin_head', 'custom_wpshapere_css' );

/* ACF style admin => for gutenberg */
/*
#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu,
#adminmenu li.current a.menu-top,
#adminmenu .wp-menu-arrow,
#adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head,
#adminmenu .wp-menu-arrow div {
    background: #007cba;
}
.edit-post-meta-boxes-area .postbox-header,
.edit-post-meta-boxes-area .postbox-header h2.ui-sortable-handle {
    background-color: #007cba !important;
}
.edit-post-meta-boxes-area .postbox-header {
    border-top: 0 !important;
}
.edit-post-meta-boxes-area .postbox-header h2.ui-sortable-handle,
.postbox-header .handlediv, .postbox-header .postbox .handlediv.button-link,
.postbox-header .item-edit, .postbox-header .toggle-indicator, .postbox-header .accordion-section-title:after,
.acf-postbox .acf-hndle-cog,
.postbox .handle-order-higher[aria-disabled="true"], .postbox .handle-order-lower[aria-disabled="true"],
.edit-post-meta-boxes-area .postbox .handle-order-higher, .edit-post-meta-boxes-area .postbox .handle-order-lower {
    color: #fff !important;
}

*/

function custom_wpshapere_login_css() { ?>
    <style type='text/css'>
        div#login {
            margin-top: 0;
        }
        .login #backtoblog {
            padding: 0;
        }
        .login #nav {
            padding: 0 15px 0 0;
        }
        .login #backtoblog, .login #nav {
            display: inline-block;
        }
    </style>
<?php }

add_action( 'login_head', 'custom_wpshapere_login_css' );
