<?php

//== Change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', function() {
    return __( 'Ajouter à mon devis', 'woocommerce' );
});
//== Change add to cart text on product archives page
add_filter( 'woocommerce_product_add_to_cart_text', function() {
    return __( 'Ajouter à mon devis', 'woocommerce' );
});

add_filter( 'wc_add_to_cart_message_html', function( $message, $product_id ) {
    $title = $product_id ? get_the_title( $product_id ) : 'Produit';
    $message = sprintf(
        '<a href="%s" tabindex="1" class="button wc-forward">%s</a>&laquo;%s&raquo; a été ajouté à votre devis.',
        esc_url(wc_get_cart_url()),
        "Voir mon devis",
        esc_attr($title)
    );

    return $message;
}, 10, 2);

// See translations => wp-content/plugins/woocommerce/i18n/languages/woocommerce.pot
add_filter( 'gettext', function( $translation, $text, $domain ) {

    if ( $domain === 'woocommerce' ) {

        if ( $text === 'Cart updated.') {
            $translation = 'Devis mis à jour.';
        }
        if ( $text === 'Proceed to checkout' ) { // Valider la commande
            $translation = 'Valider mon devis';
        }
        if ( $text ===  'Update cart' ) { // Mettre à jour le panier
            $translation = 'Mettre à jour mon devis';
        }
        if ( $text === 'View cart' ) { // Voir le panier
            $translation = 'Voir mon devis';
        }
        if ( $text === 'Your cart is currently empty.' ) {
            $translation = 'Votre devis est vide.';
        }
        if ( $text === 'Return to shop' ) {
            $translation = 'Retourner sur le site';
        }
        if ( $text === 'Your order' ) {
            $translation = 'Votre devis';
        }
        if ( $text === 'Order details' ) {
            $translation = 'Détails de votre devis';
        }
        if ( $text === 'Order number:' ) {
            $translation = 'Numéro de devis:';
        }
    }

    return $translation;

}, 10, 3 );

add_filter( 'woocommerce_thankyou_order_received_text', function() {
    return "Merci. Votre devis a été envoyé.";
});
add_filter( 'woocommerce_order_button_text', function() {
    return "Valider";
});

add_filter('woocommerce_checkout_fields', function($fields) {
    $fields['order']['order_comments']['label'] = 'Devis';
    $fields['order']['order_comments']['placeholder'] = 'Commentaires concernant votre devis';
    return $fields;
}, 10 , 1);

//== wc_get_order_statuses()
// add_filter( 'wc_order_statuses', function() {
//     $order_statuses['wc-completed']  = _x( 'Devis reçus', 'Order status', 'woocommerce' );
//     $order_statuses['wc-processing'] = _x( 'Votre devis est en cours de traitement', 'Order status', 'woocommerce' );
//     $order_statuses['wc-on-hold']    = _x( 'Votre devis est en attente', 'Order status', 'woocommerce' );
//     $order_statuses['wc-pending']    = _x( 'Votre devis est en cours', 'Order status', 'woocommerce' );

//     return $order_statuses;

// }, 20, 1 );
