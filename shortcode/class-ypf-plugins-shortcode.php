<?php
function ypf_pricing_table_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'productid' => '',
        'ypf-table' => '',
        'free_trial_btn' => '',
        'challenge_begins_btn' => '',
    ), $atts);

    $selected_product_id = $atts['productid'];

    ob_start(); // Start output buffering

    if (!empty($selected_product_id)) {
        echo '<div class="ypf-pricing-table-container ypf-tab-panel">';
        echo '<div class="pricing__table product-' . esc_attr($selected_product_id) . '">';

        // Split the 'ypf-table' attribute into an array
        $tables = explode(',', $atts['ypf-table']);
        foreach ($tables as $table) {
            $table = trim($table); // Remove any whitespace
            if (!empty($table)) {
                echo "<div>Displaying ACF group field: $table</div>";
                // Replace this with your actual function to display the group field
                // For example: display_acf_group_fields($table, $selected_product_id, 'some-css-class');
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
