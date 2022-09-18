<?php

//== Wrap cart_from into a div for laoding JS changes
function add_div_to_woocommerce_before_add_to_cart_form()
{
    echo '<div class="single-product-form loading">';
}
add_action( 'woocommerce_before_add_to_cart_form', 'add_div_to_woocommerce_before_add_to_cart_form', 10, 0 );

function add_div_to_woocommerce_after_add_to_cart_form()
{
    echo '</div>';
}
add_action( 'woocommerce_after_add_to_cart_form', 'add_div_to_woocommerce_after_add_to_cart_form', 10, 0 );


//== Overwrite form fields
function overwrite_woo_input_classes( $args, $key, $value )
{
    switch ( $args['type'] ) {

        case 'checkbox':
            $args['input_class'] = array('form-check-input');
            $args['label_class'] = array('form-check-label');
        break;
        case 'radio':
            $args['input_class'] = array('form-check-input');
            $args['label_class'] = array('form-check-label');
        break;
        default :
            $args['class'][] = 'form-group';
            $args['input_class'] = array('form-control');
            $args['label_class'] = array('control-label');
        break;
    }

    return $args;
}
add_filter('woocommerce_form_field_args','overwrite_woo_input_classes',10,3);

//== Add class to selects
function add_dropdown_variation_attributse( $args )
{
    if ( is_product() ) {
        $args['class'] = 'form-select';
    }
    return $args;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'add_dropdown_variation_attributse' );
