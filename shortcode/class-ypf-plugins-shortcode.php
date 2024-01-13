<?php
function ypf_pricing_table_shortcode( $atts ) {
    // Extract shortcode attributes
    $atts = shortcode_atts( array(
        'productid' => '',
        'ypf-step-table' => '',
        'format' => 'tab', // 'tab' or 'single'
        'free_trial_btn' => '', // Default text for the Free Trial button
        'challenge_begins_btn' => '', // Default text for the Challenge Begins button
    ), $atts );

    $selected_product_id = $atts['productid'];
    $table_format = $atts['format'];
    $tooltips_post = get_option('ypf_select_post_tooltips');
    $tooltips_post_id = isset($tooltips_post) ? $tooltips_post : '1397';

    if ( ! empty( $selected_product_id ) ) {
        $product = wc_get_product( $selected_product_id );

        if ( $product ) {
            ob_start(); // Start output buffering
                echo '<div class="ypf-pricing-table-container ypf-tab-panel">';
                // Display the product information here
                // Split the 'ypf-table' attribute into an array and get the first item
                $tables = array_map('trim', explode(',', $atts['ypf-step-table']));
                $first_table = $tables[0] ?? ''; // Fallback to an empty string if no tables are set
                ?>
                <div class="pricing__table product-<?php echo $selected_product_id; ?>">
                <?php
                // Display titles from the first ypf-table
                if (!empty($first_table)) {
                    echo '<div class="pt__title">';
                    display_acf_group_labels_and_tooltips($first_table, 'fx_challenge_tooltips', $selected_product_id, $tooltips_post_id);
                    echo '</div>';
                }
                ?>

                <div class="pt__option">

                <?php display_swiper_navigation_buttons('navBtnLeft', 'navBtnRight'); ?>

                <?php
                // Determine the swiper container ID based on the 'ypf-table-format' attribute
                $swiper_container_id = $table_format === 'single' ? 'pricingTableSliderSingle' : 'pricingTableSlider';
                ?>

                <div class="pt__option__slider swiper" id="<?php echo esc_attr($swiper_container_id); ?>">
                    <div class="swiper-wrapper">

                        <?php 

                            // Split the 'ypf-table' attribute into an array
                            $step_tables = explode(',', $atts['ypf-step-table']);
                            foreach ($step_tables as $step_table) {
                                $step_table = trim($step_table); // Remove any whitespace
                                if (!empty($step_table)) {
                                    ?>
                                    <div class="swiper-slide pt__option__item">
                                        <div class="pt__item">
                                            <div class="pt__item__wrap">
                                                <?php
                                                    display_acf_group_fields($step_table, $selected_product_id, $step_table);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                        ?>

                    </div>
                </div>

                </div>
                </div>

                <?php
            echo '</div>'; // Close ypf-tab-panel

            // Fetch URLs from ACF fields
            $free_trial_url = get_field('free_trial_url', $selected_product_id);
            $challenge_begins_url = get_field('challenge_begins_url', $selected_product_id);

            ?>

            <div class="ypf-btn-wrap">
                <?php if (!empty($atts['free_trial_btn'])): ?>
                <a href="<?php echo esc_url($free_trial_url); ?>" class="btn ypf-button free-trial"><?php echo esc_html($atts['free_trial_btn']); ?> <i class="fa-solid fa-square-arrow-up-right"></i></a>
                <?php endif; ?>
                <?php if (!empty($atts['challenge_begins_btn'])): ?>
                <a href="<?php echo esc_url($challenge_begins_url); ?>" class="btn ypf-button challenge-begins"><?php echo esc_html($atts['challenge_begins_btn']); ?> <i class="fa-solid fa-square-arrow-up-right"></i></a>
                <?php endif; ?>
            </div>


            <?php
            return ob_get_clean(); // Return the buffered output
        } else {
            return '<p>Product not found.</p>';
        }
    } else {
        return '<p>Please specify a product ID.</p>';
    }
}
add_shortcode( 'ypf-pricing-table', 'ypf_pricing_table_shortcode' );