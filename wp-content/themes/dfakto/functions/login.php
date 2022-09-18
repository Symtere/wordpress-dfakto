<?php

//== Language switcher
add_filter( 'login_display_language_dropdown', '__return_false' );

//== Login logo url
add_filter( 'login_headerurl', function() {
    return site_url();
});


// add_action('login_enqueue_scripts')

add_action( 'login_head', function() { ?>
    <style>
        body.login {
            padding-left: 1rem;
            padding-right: 1rem;
            background-color: #000 !important;
            background-image: url('') !important;
            background-position: 50%;
            background-repeat: no-repeat !important;
            background-size: cover !important;
        }
        body.login .login_footer_content,
        body.login #login {
            max-width: 400px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }
        body.login #login h1 a {
            display: block;
            padding-bottom: 30px;
            margin: 0 auto;
            max-width: 400px;
            width: 100%;
            background-position: 50% 0;
            background-repeat: no-repeat;
            background-image: url('') !important;
            background-size: 100%;
            /*background-size: cover;*/
        }
        body.login #loginform,
        body.login #lostpasswordform {
            background: transparent;
            border: 2px solid #fff;
        }
        body.login #login label,
        body.login #login a {
            color: #fff;
        }
        body.login .message {
            background: rgb(255 255 255 / 10%);
            border: 0;
            color: #fff;
        }
        body.login input[type="checkbox"]:checked::before {
            content: url(data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%2020%2020%27%3E%3Cpath%20d%3D%27M14.83%204.89l1.34.94-5.81%208.38H9.02L5.78%209.67l1.34-1.25%202.57%202.4z%27%20fill%3D%27%23e5202b%27%2F%3E%3C%2Fsvg%3E);
        }

        body.login #loginform input:focus,
        body.login #lostpasswordform input:focus {
            border-color: #e5202b;
            box-shadow: 0 0 0 1px rgb(253 23 36 / 70%);
        }
        body.login #login a {
            outline: 0 !important;
            box-shadow: none !important;
        }
        body.login #login a:hover,
        body.login #login a:focus {
            color: #e5202b;
        }
        body.login .button-primary {
            background-color: #e5202b;
            border-color: #e5202b !important;
            color: #fff;
            transition: .35s;
        }
        body.login .button-primary:hover,
        body.login .button-primary:focus {
            background-color: transparent;
        }
        body.login .login_footer_content {
            border: 0;
            margin-top: .5rem;
            color: #fff;
            font-weight: 700;
        }
        body.login .privacy-policy-page-link {
            display: none;
        }
        body.login #nav {
            width: 49%;
            padding-right: 0;
        }
        body.login #backtoblog {
            width: 49%;
            text-align: right;
        }

        @media (min-width: 570px) {

            body.login #login h1 a {
                height: 117px;
            }
        }
        @media (max-width: 569px) {

            body.login #login h1 a {
                width: 300px;
            }
        }
    </style>
<?php });
