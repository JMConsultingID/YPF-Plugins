<?php
function ypf_pricing_table_shortcode( $atts ) {
    // Extract shortcode attributes
    $atts = shortcode_atts( array(
        'productid' => '',
    ), $atts );

    $selected_product_id = $atts['productid'];

    if ( ! empty( $selected_product_id ) ) {
        $product = wc_get_product( $selected_product_id );

        if ( $product ) {
            ob_start(); // Start output buffering
                echo '<div class="ypf-pricing-table-container ypf-tab-panel">';
                // Display the product information here
                ?>
                <div class="pricing__table">
                <div class="pt__title">
                <div class="pt__title__wrap">

                <?php
                // Fetch the ACF group field for the current product
                $step_1_fx_challenge = get_field('step_1:_fx_challenge', $selected_product_id);
                $fx_challenge_tooltips = get_field('fx_challenge_tooltips', $selected_product_id);
                
                // Get the field object for the group
                $group_field_object = get_field_object('step_1:_fx_challenge', $selected_product_id);
                $group_field_tooltips_object = get_field_object('fx_challenge_tooltips', $selected_product_id);
                
                if ($group_field_object) {
                    foreach ($group_field_object['sub_fields'] as $index => $sub_field) {
                        // The label is in the field object
                        $sub_field_label = isset($sub_field['label']) ? $sub_field['label'] : $sub_field['label'];
                        $sub_field_name = $sub_field['name'];
                        $sub_field_tooltips_name = 'tooltips_'.$sub_field['name'];

                        $sub_field_tooltip = isset($fx_challenge_tooltips[$sub_field_tooltips_name]) ? $fx_challenge_tooltips[$sub_field_tooltips_name] : '';
                        $sub_field_tooltip_text ='';
                        if (!empty($sub_field_tooltip)) { 
                            $sub_field_tooltip_text = '<span class="data-template" data-template="'. esc_html($sub_field_tooltips_name) . '"><i aria-hidden="true" class="fas fa-info-circle"></i></span>';
                        }
                                          
                        echo '<div class="pt__row heading-vertical '. esc_html($sub_field_name) . '"><div class="pt__row-heading-text">' . esc_html($sub_field_label) . $sub_field_tooltip_text . '</div></div>';                    

                    }
                    echo '<div style="display: none;">';
                    foreach ($group_field_object['sub_fields'] as $index => $sub_field) {
                        $sub_field_name = $sub_field['name'];
                        $sub_field_tooltips_name = 'tooltips_'.$sub_field['name'];
                        $sub_field_tooltip = isset($fx_challenge_tooltips[$sub_field_tooltips_name]) ? $fx_challenge_tooltips[$sub_field_tooltips_name] : $fx_challenge_tooltips[$sub_field_tooltips_name];
                        echo '<div id="'. esc_html($sub_field_tooltips_name) . '">';
                        echo $sub_field_tooltip;
                        echo '</div>';                   
                    }
                    echo '</div>';
                }
                ?>

                </div>
                </div>

                <div class="pt__option">

                <div class="pt__option__mobile__nav">
                    <a id="navBtnLeft" href="#" class="mobile__nav__btn">
                      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.1538 11.9819H1.81972" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.9863 22.1535L1.82043 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </a>
                    <a id="navBtnRight" href="#" class="mobile__nav__btn">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M1.81934 11.9819H22.1534" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                          <path d="M11.9863 22.1535L22.1522 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>

                <div class="pt__option__slider swiper" id="pricingTableSlider">
                  <div class="swiper-wrapper">

                    <div class="swiper-slide pt__option__item">
                      <div class="pt__item">
                        <div class="pt__item__wrap">

                            <?php
                            // Fetch the ACF group field for the current product
                            $step_1_fx_challenge = get_field('step_1:_fx_challenge', $selected_product_id);
                            
                            // Get the field object for the group
                            $group_field_object = get_field_object('step_1:_fx_challenge', $selected_product_id);
                            
                            if ($step_1_fx_challenge && $group_field_object) {
                                foreach ($group_field_object['sub_fields'] as $sub_field) {
                                    // The label is in the field object
                                    $sub_field_label = $sub_field['label'];
                                    $sub_field_name = $sub_field['name'];
                                    // The value is in the values array
                                    $sub_field_value = !empty($step_1_fx_challenge[$sub_field['name']]) ? $step_1_fx_challenge[$sub_field['name']] : '-';
                        
                                    echo '<div class="pt__row step_1_fx_challenge val val-'. esc_html($sub_field_name) . '">' . esc_html($sub_field_value) . '</div>';
                                }
                            }
                            ?>

                        </div>
                      </div>
                    </div>

                    <div class="swiper-slide pt__option__item">
                      <div class="pt__item">
                        <div class="pt__item__wrap">

                            <?php
                            // Fetch the ACF group field for the current product
                            $step_2_inspection_period = get_field('step_2:_inspection_period', $selected_product_id);
                            
                            // Get the field object for the group
                            $group_field_object = get_field_object('step_2:_inspection_period', $selected_product_id);
                            
                            if ($step_2_inspection_period && $group_field_object) {
                                foreach ($group_field_object['sub_fields'] as $sub_field) {
                                    // The label is in the field object
                                    $sub_field_label = $sub_field['label'];
                                    $sub_field_name = $sub_field['name'];
                                    // The value is in the values array
                                    $sub_field_value = !empty($step_2_inspection_period[$sub_field['name']]) ? $step_2_inspection_period[$sub_field['name']] : '-';
                                    echo '<div class="pt__row step_2_inspection_period val val-'. esc_html($sub_field_name) . '">' . esc_html($sub_field_value) . '</div>';
                                }
                            }
                            ?>
                            
                        </div>
                      </div>
                    </div>

                    <div class="swiper-slide pt__option__item">
                      <div class="pt__item">
                        <div class="pt__item__wrap">

                            <?php
                            // Fetch the ACF group field for the current product
                            $step_3_prop_trader = get_field('step_3:_prop_trader', $selected_product_id);
                            
                            // Get the field object for the group
                            $group_field_object = get_field_object('step_3:_prop_trader', $selected_product_id);
                            
                            if ($step_3_prop_trader && $group_field_object) {
                                foreach ($group_field_object['sub_fields'] as $sub_field) {
                                    // The label is in the field object
                                    $sub_field_label = $sub_field['label'];
                                    $sub_field_name = $sub_field['name'];
                                    // The value is in the values array
                                    $sub_field_value = !empty($step_3_prop_trader[$sub_field['name']]) ? $step_3_prop_trader[$sub_field['name']] : '-';
                                    echo '<div class="pt__row step_3_prop_trader val val-'. esc_html($sub_field_name) . '">' . esc_html($sub_field_value) . '</div>';
                                }
                            }
                            ?>
                            
                        </div>
                      </div>
                    </div>

                  </div>
                </div>


                </div>
                </div>

                <?php
            echo '</div>'; // Close ypf-tab-panel
            return ob_get_clean(); // Return the buffered output
        } else {
            return '<p>Product not found.</p>';
        }
    } else {
        return '<p>Please specify a product ID.</p>';
    }
}
add_shortcode( 'ypf-pricing-table', 'ypf_pricing_table_shortcode' );
