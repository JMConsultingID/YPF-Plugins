<?php
class Elementor_YpfPlugins_Widget_Pricing_Table_Per_Product extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ypfplugins_pricing_table_product';
	}

	public function get_title() {
		return esc_html__( 'YPF Plugins Product Table', 'ypf-plugins' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

	public function get_categories() {
		return [ 'ab-ypfplugins-category' ];
	}

	public function get_keywords() {
		return [ 'ypf plugins', 'ypf','pricing', 'table' ];
	}

	public function get_style_depends() {
        return ['ypf-plugins-css'];
    }

    public function get_script_depends() {
        return ['ypf-plugins-js'];
    }

	protected function register_controls() {

		// Content Tab Start

		$this->start_controls_section(
			'section_pricing_table',
			[
				'label' => esc_html__( 'Pricing Table Section', 'ypf-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        // Add a select control for products
        $this->add_control(
            'selected_product',
            [
                'label' => __('Select Product', 'text-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_woocommerce_products(),
                'default' => 'Select Product',
            ]
        );

		$this->end_controls_section();


	}

	protected function render() {		
	// Check if Elementor editor is active
    if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
        echo '<p>Elementor editor is active. Product details will be displayed on the frontend.</p>';
    }else {
	// Get the selected product ID from the widget settings
	$settings = $this->get_settings_for_display();
	$selected_product_id = $settings['selected_product'];
	$tooltips_post = get_option('ypf_select_post_tooltips');
	$tooltips_post_id = isset($tooltips_post) ? $tooltips_post : '861';

	// Check if a product ID is selected   
	if (!empty($selected_product_id)) {
    	// Fetch the product object
        $product = wc_get_product($selected_product_id);

        echo '<div class="ypf-pricing-table-container ypf-tab-panel">';
            ?>
            <div class="pricing__table product-<?php echo $selected_product_id; ?>">
		  	<div class="pt__title">
                <?php display_acf_group_labels_and_tooltips('step_1:_fx_challenge', 'fx_challenge_tooltips', $selected_product_id, $tooltips_post_id); ?>
            </div>

		  	<div class="pt__option">

		    <?php display_swiper_navigation_buttons('navBtnLeft', 'navBtnRight'); ?>

		    <div class="pt__option__slider swiper" id="pricingTableSlider">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide pt__option__item">
                            <div class="pt__item">
                                <div class="pt__item__wrap">
                                    <?php display_acf_group_fields('step_1:_fx_challenge', $selected_product_id, 'step_1_fx_challenge'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide pt__option__item">
                            <div class="pt__item">
                                <div class="pt__item__wrap">
                                    <?php display_acf_group_fields('step_2:_inspection_period', $selected_product_id, 'step_2_inspection_period'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide pt__option__item">
                            <div class="pt__item">
                                <div class="pt__item__wrap">
                                    <?php display_acf_group_fields('step_3:_prop_trader', $selected_product_id, 'step_3_prop_trader'); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

			</div>
			</div>

            <?php
      	echo '</div>'; // Close ypf-tab-panel
		} else {
        echo '<p>Please select a product.</p>';
    	}
	}
	}

    // Helper function to get WooCommerce products
    private function get_woocommerce_products() {
        $products = wc_get_products(array(
            'status' => 'publish',
            'limit' => -1,
        ));

        $product_options = [];
        foreach ($products as $product) {
            $product_options[$product->get_id()] = $product->get_name();
        }

        return $product_options;
    }

    private function display_acf_group_labels_and_tooltips($group_field_name, $tooltips_field_name, $product_id, $tooltips_post_id) {
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

	        if (get_option('ypf_enable_tooltips')) {
		        echo '<div style="display: none;">';
		        foreach ($group_field_object['sub_fields'] as $index => $sub_field) {
		            $sub_field_tooltips_name = 'tooltips_' . $sub_field['name'];
		            $sub_field_tooltip = isset($tooltips_field_values[$sub_field_tooltips_name]) ? $tooltips_field_values[$sub_field_tooltips_name] : '';
		            echo '<div id="'. esc_html($sub_field_tooltips_name) . '">' . esc_html($sub_field_tooltip) . '</div>';                   
		        }
		        echo '</div>';
	    	}

	        echo '</div>'; // Close pt__title__wrap
	    }
	}

	private function display_acf_group_fields($group_field_name, $product_id, $css_class_prefix) {
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

	private function display_swiper_navigation_buttons($left_button_id, $right_button_id) {
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

}