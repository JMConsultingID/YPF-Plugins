<?php
function display_acf_group_labels_and_tooltips($group_field_name, $tooltips_field_name, $product_id, $tooltips_post_id) {
    // Fetch group field values and object for the product
    $group_field_values = get_field($group_field_name, $product_id);
    $group_field_object = get_field_object($group_field_name, $product_id);

    // Fetch tooltips field values from the global tooltips post
    $tooltips_field_values = get_field($tooltips_field_name, $tooltips_post_id);

    if ($group_field_object) {
        echo '<div class="pt__title__wrap">';

        foreach ($group_field_object['sub_fields'] as $index => $sub_field) {
            $sub_field_label = $sub_field['label'];
            $sub_field_name = $sub_field['name'];
            $sub_field_tooltips_name = 'tooltips_' . $sub_field['name'];
            $sub_field_tooltip = isset($tooltips_field_values[$sub_field_tooltips_name]) ? $tooltips_field_values[$sub_field_tooltips_name] : '';

            $sub_field_tooltip_text = '';
            if (get_option('ypf_enable_tooltips')) {
                if (!empty($sub_field_tooltip)) { 
                    $sub_field_tooltip_text = '<span class="data-template" data-template="'. esc_html($sub_field_tooltips_name) . '"><i aria-hidden="true" class="fas fa-info-circle"></i></span>';
                }
            }
            echo '<div class="pt__row heading-vertical ' . esc_html($sub_field_name) . '"><div class="pt__row-heading-text">' . esc_html($sub_field_label) . $sub_field_tooltip_text . '</div></div>'; 
        }

        echo '<div style="display: none;">';
        if (get_option('ypf_enable_tooltips')) {
            foreach ($group_field_object['sub_fields'] as $index => $sub_field) {
                $sub_field_tooltips_name = 'tooltips_' . $sub_field['name'];
                $sub_field_tooltip = isset($tooltips_field_values[$sub_field_tooltips_name]) ? $tooltips_field_values[$sub_field_tooltips_name] : '';
                echo '<div id="'. esc_html($sub_field_tooltips_name) . '">' . esc_html($sub_field_tooltip) . '</div>';                   
            }
          }
          echo '</div>';

        echo '</div>'; // Close pt__title__wrap
    }
}


function display_acf_group_fields($group_field_name, $product_id, $css_class_prefix) {
    // Fetch the ACF group field for the current product
    $group_field_values = get_field($group_field_name, $product_id);
            
    // Get the field object for the group
    $group_field_object = get_field_object($group_field_name, $product_id);
            
    if ($group_field_values && $group_field_object) {
        foreach ($group_field_object['sub_fields'] as $sub_field) {
            // The label is in the field object
            $sub_field_label = $sub_field['label'];
            $sub_field_name = $sub_field['name'];
            // The value is in the values array
            $sub_field_value = !empty($group_field_values[$sub_field['name']]) ? $group_field_values[$sub_field['name']] : '-';
            echo '<div class="pt__row ' . esc_attr($css_class_prefix) . ' val val-' . esc_attr($sub_field_name) . '">' . $sub_field_value . '</div>';
        }
    }
}

function display_swiper_navigation_buttons($left_button_id, $right_button_id) {
    ?>
    <div class="pt__option__mobile__nav">
        <a id="<?php echo esc_attr($left_button_id); ?>" href="#" class="mobile__nav__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.1538 11.9819H1.81972" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9863 22.1535L1.82043 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        <a id="<?php echo esc_attr($right_button_id); ?>" href="#" class="mobile__nav__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.81934 11.9819H22.1534" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9863 22.1535L22.1522 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
    <?php
}

function display_acf_group_labels_and_tooltips_el($group_field_name, $tooltips_field_name, $product_id, $tooltips_post_id) {
    // Fetch group field values and object for the product
    $group_field_values = get_field($group_field_name, $product_id);
    $group_field_object = get_field_object($group_field_name, $product_id);

    // Fetch tooltips field values from the global tooltips post
    $tooltips_field_values = get_field($tooltips_field_name, $tooltips_post_id);

    if ($group_field_object) {
        echo '<div class="pt__title__wrap">';

        foreach ($group_field_object['sub_fields'] as $index => $sub_field) {
            $sub_field_label = $sub_field['label'];
            $sub_field_name = $sub_field['name'];
            $sub_field_tooltips_name = 'tooltips_' . $sub_field['name'];
            $sub_field_tooltip = isset($tooltips_field_values[$sub_field_tooltips_name]) ? $tooltips_field_values[$sub_field_tooltips_name] : '';

            $sub_field_tooltip_text = '';
            if (get_option('ypf_enable_tooltips')) {
                if (!empty($sub_field_tooltip)) { 
                    $sub_field_tooltip_text = '<span class="data-template" data-template="'. esc_html($sub_field_tooltips_name) . '"><i aria-hidden="true" class="fas fa-info-circle"></i></span>';
                }
            }
            echo '<div class="pt__row heading-vertical ' . esc_html($sub_field_name) . ' pt__title__elementor pt__table_general_text_color pt__table_general_border_color"><div class="pt__row-heading-text">' . esc_html($sub_field_label) . $sub_field_tooltip_text . '</div></div>'; 
        }

        echo '<div style="display: none;">';
        if (get_option('ypf_enable_tooltips')) {
            foreach ($group_field_object['sub_fields'] as $index => $sub_field) {
                $sub_field_tooltips_name = 'tooltips_' . $sub_field['name'];
                $sub_field_tooltip = isset($tooltips_field_values[$sub_field_tooltips_name]) ? $tooltips_field_values[$sub_field_tooltips_name] : '';
                echo '<div id="'. esc_html($sub_field_tooltips_name) . '">' . esc_html($sub_field_tooltip) . '</div>';                   
            }
          }
        echo '</div>';
        echo '</div>'; // Close pt__title__wrap
    }
}

function display_acf_group_fields_el($group_field_name, $product_id, $css_class_prefix) {
    // Fetch the ACF group field for the current product
    $group_field_values = get_field($group_field_name, $product_id);
            
    // Get the field object for the group
    $group_field_object = get_field_object($group_field_name, $product_id);
            
    if ($group_field_values && $group_field_object) {
        $is_first_item = true; // Flag to check if we are on the first item
        foreach ($group_field_object['sub_fields'] as $sub_field) {
            // The label is in the field object
            $sub_field_label = $sub_field['label'];
            $sub_field_name = $sub_field['name'];
            // The value is in the values array
            $sub_field_value = !empty($group_field_values[$sub_field['name']]) ? $group_field_values[$sub_field['name']] : '-';
            // Determine the class to add based on whether it's the first item
            $additional_class = $is_first_item ? 'pt__title__elementor' : 'pt__table_content__elementor';

            echo '<div class="pt__row ' . esc_attr($css_class_prefix) . ' val val-' . esc_attr($sub_field_name) . ' ' . $additional_class . ' pt__table_general_text_color pt__table_general_border_color">' . $sub_field_value . '</div>';
            $is_first_item = false; // After the first iteration, set this flag to false
        }
    }
}

function display_swiper_navigation_buttons_el($left_button_id, $right_button_id) {
    ?>
    <div class="pt__option__mobile__nav">
        <a id="<?php echo esc_attr($left_button_id); ?>" href="#" class="mobile__nav__btn pt__mobile_button_background__elementor pt__mobile_button_arrow__elementor">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.1538 11.9819H1.81972" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9863 22.1535L1.82043 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        <a id="<?php echo esc_attr($right_button_id); ?>" href="#" class="mobile__nav__btn pt__mobile_button_background__elementor pt__mobile_button_arrow__elementor">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.81934 11.9819H22.1534" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9863 22.1535L22.1522 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
    <?php
}   
?>