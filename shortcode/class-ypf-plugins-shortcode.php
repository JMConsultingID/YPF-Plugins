<?php
function ypf_pricing_table_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'productid' => '',
        'free_trial_btn' => '',
        'challenge_begins_btn' => '',
        // No need to explicitly define ypf-table-1, ypf-table-2, etc. here
    ), $atts);

    $selected_product_id = $atts['productid'];

    ob_start(); // Start output buffering

    if (!empty($selected_product_id)) {
        echo '<div class="ypf-pricing-table-container ypf-tab-panel">';
        echo '<div class="pricing__table product-' . esc_attr($selected_product_id) . '">';

        // Assume a maximum number of tables, for example, 10
        for ($i = 1; $i <= 10; $i++) {
            $table_key = 'ypf-table-' . $i;
            if (isset($atts[$table_key])) {
                echo "<div>Displaying ACF group field for {$table_key}: {$atts[$table_key]}</div>";
                // Replace this with your actual function to display the group field
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
