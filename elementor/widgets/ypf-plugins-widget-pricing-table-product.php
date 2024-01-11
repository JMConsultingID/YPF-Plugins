<?php
class Elementor_YpfPlugins_Widget_Pricing_Table_Per_Product extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ypfplugins_pricing_table_per_product';
	}

	public function get_title() {
		return esc_html__( 'YPF Plugins Pricing Table 1 Product', 'ypf-plugins' );
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

	// Check if a product ID is selected   
	if (!empty($selected_product_id)) {
    	// Fetch the product object
        $product = wc_get_product($selected_product_id);

        echo '<div class="ypf-pricing-table-container ypf-tab-panel">';
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

					$sub_field_tooltip = isset($fx_challenge_tooltips[$sub_field_tooltips_name]) ? $fx_challenge_tooltips[$sub_field_tooltips_name] : $fx_challenge_tooltips[$sub_field_tooltips_name];
                                      
                    echo '<div class="pt__row heading-vertical '. esc_html($sub_field_name) . '">' . esc_html($sub_field_label) . '<span class="data-space">Space</span><span class="data-template" data-template="'. esc_html($sub_field_tooltips_name) . '"><i aria-hidden="true" class="fas fa-info-circle"></i></span></div>';                    

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
}