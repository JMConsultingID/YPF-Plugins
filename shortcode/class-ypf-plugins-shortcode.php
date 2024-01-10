<?php
function ypf_pricing_table_shortcode( $atts ) {
    // Extract shortcode attributes
    $atts = shortcode_atts( array(
        'productID' => '',
    ), $atts );

    $selected_product_id = $atts['productID'];

    if ( ! empty( $selected_product_id ) ) {
        // Your code to fetch the product and display details
        // ...

        return 'Product ID: ' . $selected_product_id; // For testing
    } else {
        return '<p>Please specify a product ID.</p>';
    }
}
add_shortcode( 'ypf-pricing-table', 'ypf_pricing_table_shortcode' );
