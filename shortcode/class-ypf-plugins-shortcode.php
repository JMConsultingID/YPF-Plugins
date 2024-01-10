<?php
function ypf_pricing_table_shortcode( $atts ) {
    // Debugging: Output the raw attributes
    ob_start();
    var_dump($atts);
    $result = ob_get_clean();
    return 'Received attributes: ' . esc_html($result);
}
add_shortcode( 'ypf-pricing-table', 'ypf_pricing_table_shortcode' );
