<?php
function get_all_tooltips_posts() {
    $args = array(
        'post_type' => 'tooltips-table',
        'posts_per_page' => -1,  // Retrieve all posts
    );

    $posts = get_posts($args);
    return $posts;
}

/**
 * Register scripts and styles for Elementor test widgets.
 */
function ypf_plugins_widgets() {
    // Check if the pricing table is enabled
    if ( get_option('ypf_enable_pricing_table') ) {
        // Register styles        
        wp_register_style( 'ypf-font-awesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');
        wp_register_style( 'ypf-swiper-bundle-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css');
        wp_register_style( 'ypf-plugins-css', plugins_url( '/public/assets/css/ypf-plugins.css', __FILE__ ), array('ypf-font-awesome-css', 'ypf-swiper-bundle-css'), '1.0.0', 'all' );


        // Register scripts        
        wp_register_script( 'ypf-swiper-bundle-js', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js', array('jquery'), null, true );
        wp_register_script( 'ypf-popper-js', 'https://unpkg.com/@popperjs/core@2.11.8/dist/umd/popper.min.js', null, array(), null, true );
        wp_register_script( 'ypf-tippy-js', 'https://unpkg.com/tippy.js@6.3.7/dist/tippy-bundle.umd.min.js', null, array(), null, true );

        wp_register_script( 'ypf-plugins-js', plugins_url( '/public/assets/js/ypf-plugins.js', __FILE__ ), array('jquery', 'ypf-swiper-bundle-js','ypf-popper-js', 'ypf-tippy-js'), '1.0.0', true );

    }
}
add_action( 'wp_enqueue_scripts', 'ypf_plugins_widgets', 2);

function check_for_shortcode_and_enqueue_scripts() {
    if ( get_option('ypf_enable_pricing_table') ) {
            // Enqueue scripts and styles here
            wp_enqueue_style('ypf-plugins-css');
            wp_enqueue_script('ypf-plugins-js');
    }
}
add_action('wp', 'check_for_shortcode_and_enqueue_scripts');

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

function display_acf_group_labels_and_tooltips_el($group_field_name, $tooltips_field_name, $product_id, $tooltips_switch, $tooltips_post_id_elementor) {
    // Fetch group field values and object for the product
    $group_field_values = get_field($group_field_name, $product_id);
    $group_field_object = get_field_object($group_field_name, $product_id);

    // Fetch tooltips field values from the global tooltips post
    $tooltips_field_values = get_field($tooltips_field_name, $tooltips_post_id_elementor);

    if ($group_field_object) {
        echo '<div class="pt__title__wrap">';

        foreach ($group_field_object['sub_fields'] as $index => $sub_field) {
            $sub_field_label = $sub_field['label'];
            $sub_field_name = $sub_field['name'];
            $sub_field_tooltips_name = 'tooltips_' . $sub_field['name'];
            $sub_field_tooltip = isset($tooltips_field_values[$sub_field_tooltips_name]) ? $tooltips_field_values[$sub_field_tooltips_name] : '';

            $sub_field_tooltip_text = '';
            if ($tooltips_switch == 'yes') {
                if (!empty($sub_field_tooltip)) { 
                    $sub_field_tooltip_text = '<span class="data-template" data-template="'. esc_html($sub_field_tooltips_name) . '"><i aria-hidden="true" class="fas fa-info-circle"></i></span>';
                }
            }
            echo '<div class="pt__row heading-vertical ' . esc_html($sub_field_name) . ' ypf_side_title_bg_elementor ypf_side_title_text_elementor pt__table_general_border"><div class="pt__row-heading-text">' . esc_html($sub_field_label) . $sub_field_tooltip_text . '</div></div>'; 
        }

        echo '<div style="display: none;">';
        if ($tooltips_switch == 'yes') {
            foreach ($group_field_object['sub_fields'] as $index => $sub_field) {
                $sub_field_tooltips_name = 'tooltips_' . $sub_field['name'];
                $sub_field_tooltip = isset($tooltips_field_values[$sub_field_tooltips_name]) ? $tooltips_field_values[$sub_field_tooltips_name] : '';
                echo '<div id="'. esc_html($sub_field_tooltips_name) . '" data-post="'.esc_html($tooltips_post_id_elementor).'">' . esc_html($sub_field_tooltip) . '</div>';                   
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
            $additional_class = $is_first_item ? 'ypf_step_title_bg_elementor ypf_step_title_text_elementor' : 'ypf_table_content_bg_elementor ypf_table_content_text_elementor';

            echo '<div class="pt__row ' . esc_attr($css_class_prefix) . ' val val-' . esc_attr($sub_field_name) . ' ' . $additional_class . ' pt__table_general_border">' . $sub_field_value . '</div>';
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