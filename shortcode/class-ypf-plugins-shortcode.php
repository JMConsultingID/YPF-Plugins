<?php
function ypf_pricing_table_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'productid' => '',
        'free_trial_btn' => '',
        'challenge_begins_btn' => '',
    ), $atts);

    ob_start(); // Start output buffering

    // Debugging: Output the attributes
    echo "<pre>Attributes: " . print_r($atts, true) . "</pre>";

    $selected_product_id = $atts['productid'];

    if (!empty($selected_product_id)) {
        echo '<div class="ypf-pricing-table-container ypf-tab-panel">';
        echo '<div class="pricing__table product-' . esc_attr($selected_product_id) . '">';

        // Iterate through attributes and display group fields
        foreach ($atts as $key => $value) {
            if (strpos($key, 'ypf-table-') === 0 && !empty($value)) {
                echo "<div>Processing $key: $value</div>";
                // Replace this with your actual function to display the group field
                echo "<div>Displaying group field: $value</div>";
            }
        }

        // Add buttons if set
        if (!empty($atts['free_trial_btn'])) {
            echo "<div>Free Trial Button: {$atts['free_trial_btn']}</div>";
        }
        if (!empty($atts['challenge_begins_btn'])) {
            echo "<div>Challenge Begins Button: {$atts['challenge_begins_btn']}</div>";
        }

        echo '</div>'; // Close pricing__table
        echo '</div>'; // Close ypf-tab-panel
    } else {
        echo '<p>Please specify a product ID.</p>';
    }

    return ob_get_clean(); // Return the buffered output
}
add_shortcode('ypf-pricing-table', 'ypf_pricing_table_shortcode');
