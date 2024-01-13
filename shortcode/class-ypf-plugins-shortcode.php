<?php
function ypf_pricing_table_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'productid' => '',
        'free_trial_btn' => '',
        'challenge_begins_btn' => '',
        // Potentially more attributes
    ), $atts);

    $selected_product_id = $atts['productid'];

    ob_start(); // Start output buffering

    if (!empty($selected_product_id)) {
        echo '<div class="ypf-pricing-table-container ypf-tab-panel">';
        echo '<div class="pricing__table product-' . esc_attr($selected_product_id) . '">';

        // Handle ACF group fields
        foreach ($atts as $key => $value) {
            if (strpos($key, 'ypf-table-') === 0 && !empty($value)) {
                // Display ACF group field
                echo "<div>Displaying ACF group field: $value</div>";
                // Replace this with your actual function to display the group field
                // display_acf_group_fields($value, $selected_product_id, 'some-css-class');
            }
        }

        echo '</div>'; // Close pricing__table
        echo '</div>'; // Close ypf-tab-panel

        // Add buttons
        if (!empty($atts['free_trial_btn'])) {
            echo "<div>Free Trial Button: {$atts['free_trial_btn']}</div>";
        }
        if (!empty($atts['challenge_begins_btn'])) {
            echo "<div>Challenge Begins Button: {$atts['challenge_begins_btn']}</div>";
        }
    } else {
        echo '<p>Please specify a product ID.</p>';
    }

    return ob_get_clean(); // Return the buffered output
}
add_shortcode('ypf-pricing-table', 'ypf_pricing_table_shortcode');
