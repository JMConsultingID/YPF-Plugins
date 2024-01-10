<?php
class Elementor_YpfPlugins_Widget_Pricing_Table extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ypfplugins_pricing_table';
	}

	public function get_title() {
		return esc_html__( 'YPF Plugins Pricing Table', 'ypf-plugins' );
	}

	public function get_icon() {
		return 'eicon-image-hotspot';
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

		$this->add_control(
            'post_type',
            [
                'label' => __('Post Type', 'ypf-plugins'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $this->get_available_post_types(),
            ]
        );

		$this->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();

   	// Query to get all products
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1, // Adjust as needed
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => 'pricing-table', // Make sure to use the actual slug of the category
            ),
        ),
    );
    $products = new WP_Query($args);

    if ($products->have_posts()) {
        echo '<div class="ypf-product-tabs">';

        // Generate the tab buttons
        echo '<ul class="ypf-tabs-buttons">';
        while ($products->have_posts()) {
            $products->the_post();
            echo '<li>' . get_the_title() . '</li>';
        }
        echo '</ul>';

        // Generate the tab content
        $products->rewind_posts();
        $number = 1;
        echo '<div class="ypf-tabs-content">';
        while ($products->have_posts()) {
            $products->the_post();
            $product_id = get_the_ID();

            echo '<div class="ypf-tab-panel">';
            // Display the product information here
            echo '<h2>' . get_the_title() . '</h2>';
            ?>
            <div class="pricing__table">
		  	<div class="pt__title">
		    <div class="pt__title__wrap">

            <?php
            // Fetch the ACF group field for the current product
            $step_1_fx_challenge = get_field('step_1:_fx_challenge', $product_id);
            
            // Get the field object for the group
            $group_field_object = get_field_object('step_1:_fx_challenge', $product_id);
            
            if ($group_field_object) {
                foreach ($group_field_object['sub_fields'] as $sub_field) {
                    // The label is in the field object
                    $sub_field_label = isset($sub_field['label']) ? $sub_field['label'] : $sub_field['label'];
                    $sub_field_name = $sub_field['name'];                    
                    echo '<div class="pt__row heading-vertical '. esc_html($sub_field_name) . '">' . esc_html($sub_field_label) . '</div>';
                }
            }
            ?>

            </div>
		  	</div>

		  	<div class="pt__option">

		    <div class="pt__option__mobile__nav">
		        <a id="navBtnLeft-<?php echo $number; ?>" href="#" class="mobile__nav__btn">
		          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
		            <path d="M22.1538 11.9819H1.81972" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
		            <path d="M11.9863 22.1535L1.82043 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
		          </svg>
		        </a>
		        <a id="navBtnRight-<?php echo $number; ?>" href="#" class="mobile__nav__btn">
		            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
		              <path d="M1.81934 11.9819H22.1534" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
		              <path d="M11.9863 22.1535L22.1522 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
		            </svg>
		        </a>
		    </div>

		    <div class="pt__option__slider swiper" id="pricingTableSlider-<?php echo $number; ?>">
		      <div class="swiper-wrapper">

		      	<div class="swiper-slide pt__option__item">
		          <div class="pt__item">
		            <div class="pt__item__wrap">

		            	<?php
			            // Fetch the ACF group field for the current product
			            $step_1_fx_challenge = get_field('step_1:_fx_challenge', $product_id);
			            
			            // Get the field object for the group
			            $group_field_object = get_field_object('step_1:_fx_challenge', $product_id);
			            
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
			            $step_2_inspection_period = get_field('step_2:_inspection_period', $product_id);
			            
			            // Get the field object for the group
			            $group_field_object = get_field_object('step_2:_inspection_period', $product_id);
			            
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
			            $step_3_prop_trader = get_field('step_3:_prop_trader', $product_id);
			            
			            // Get the field object for the group
			            $group_field_object = get_field_object('step_3:_prop_trader', $product_id);
			            
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
            $number++;
        }
        echo '</div>'; // Close ypf-tabs-content

        echo '</div>'; // Close ypf-product-tabs
    }
    wp_reset_postdata();

		?>
		<script>
			 // Pricing table - mobile only slider
			var init = false;
			var pricingCardSwiper;
			var pricingLoanSwiper
			function swiperCard() {
			  if (window.innerWidth <= 991) {
			    if (!init) {
			      init = true;
			      pricingCardSwiper = new Swiper("#pricingTableSlider-1", {
			        slidesPerView: "auto",
			        spaceBetween: 5,
			        grabCursor: true,
			        keyboard: true,
			        autoHeight: false,
			        navigation: {
			          nextEl: "#navBtnRight-1",
			          prevEl: "#navBtnLeft-1",
			        },
			      });
			    }
			  } else if (init) {
			    pricingCardSwiper.destroy();
			    init = false;
			  }
			}
			swiperCard();
			window.addEventListener("resize", swiperCard);
		</script>
		<?php
	}

	// Helper function to get available post types
    private function get_available_post_types() {
        $post_types = get_post_types(['public' => true], 'objects');
        $options = [];

        foreach ($post_types as $post_type) {
            $options[$post_type->name] = $post_type->labels->singular_name;
        }

        return $options;
    }
}