<?php
function ypf_pricing_table_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'productid' => '',
        'free_trial_btn' => '',
        'challenge_begins_btn' => '',
        // Additional attributes can be handled here
    ), $atts);

    $selected_product_id = $atts['productid'];

    ob_start(); // Start output buffering

    if (!empty($selected_product_id)) {
        echo '<div class="ypf-pricing-table-container ypf-tab-panel">';
        echo '<div class="pricing__table product-' . esc_attr($selected_product_id) . '">';

        // Debugging: Check each attribute
        foreach ($atts as $key => $value) {
            if (strpos($key, 'ypf-table-') === 0) {
                echo "<div>Debugging: Found $key with value $value</div>";
                // Here you would call your function to display the ACF group field
            }
        }

        // Add buttons
        // ... (existing button code)

        echo '</div>'; // Close pricing__table
        echo '</div>'; // Close ypf-tab-panel
    } else {
        echo '<p>Please specify a product ID.</p>';
    }

    return ob_get_clean(); // Return the buffered output
}
add_shortcode('ypf-pricing-table', 'ypf_pricing_table_shortcode');

