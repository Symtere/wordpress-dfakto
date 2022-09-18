<?php

/**
* Check if WooCommerce is activated
*/
if ( ! function_exists( 'is_woocommerce_activated' ) ) {

    function is_woocommerce_activated() {
        if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
    }
}

//== remove UGS (SKU) verification for variations
//add_filter( 'wc_product_has_unique_sku', '__return_false' );

function theme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    //add_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'after_setup_theme', 'theme_add_woocommerce_support', 100 );

//== Redirect shop archive page to custom page
function woo_redirect_shop_url()
{
    if ( is_shop() ) {
        wp_redirect( site_url() );
        exit();
    }
}
//add_action( 'template_redirect', 'woo_redirect_shop_url' );

//== Activate gutenberg on products page editor
function we_activate_gutenberg_products($can_edit, $post_type)
{
	if ( $post_type == 'product' ) {
		$can_edit = true;
	}

	return $can_edit;
}
//add_filter( 'use_block_editor_for_post_type', 'we_activate_gutenberg_products', 10, 2 );

//== Get cart items number
function get_cart_nb()
{
    $nb = WC()->cart->get_cart_contents_count();
    return $nb ? esc_attr($nb) : '';
}

//== Remove description and informations tabs
function remove_product_tabs()
{
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
}
//add_action( 'woocommerce_after_single_product_summary', 'remove_product_tabs', 2 );

//== Remove related products, upsells, crosssells
// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
// remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );


function we_add_woocomerce_footer_script()
{ ?>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            function addButtonFormClass(formAttr) {

                const form = document.querySelector(formAttr);

                if ( null !== form ) {

                    const formFields = form.querySelectorAll('.woocommerce-Input');
                    const submitBtn = form.querySelectorAll('button[type="submit"]');

                    if ( null !== formFields ) {

                        formFields.forEach(field => {
                            field.classList.add('form-control');
                        });
                    }
                    if ( null !== submitBtn ) {
                        let btnClasses = ['btn','btn-primary'];

                        submitBtn.forEach(button => {
                            button.classList.add(...btnClasses);
                        });
                    }
                }
            }

            addButtonFormClass('.single form.cart');
            addButtonFormClass('.variations_form.cart');
            addButtonFormClass('.lost_reset_password');
            addButtonFormClass('.woocommerce-account .woocommerce-form-login');
            addButtonFormClass('.woocommerce-MyAccount-content');
        });
    </script>
<?php }
add_action('wp_footer', 'we_add_woocomerce_footer_script');
