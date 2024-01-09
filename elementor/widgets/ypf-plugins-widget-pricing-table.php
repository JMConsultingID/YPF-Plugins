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
	        'posts_per_page' => -1 // Adjust as needed
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
	        echo '<div class="ypf-tabs-content">';
	        while ($products->have_posts()) {
	            $products->the_post();
	            $product_id = get_the_ID();

	            echo '<div class="ypf-tab-panel">';
	            // Display the product information here
	            echo '<h2>' . get_the_title() . '</h2>';

	            // Fetch the ACF group field for the current product
	            $step_1_fx_challenge = get_field('step_1:_fx_challenge', $product_id);
	            if ($step_1_fx_challenge) {
	                echo '<ul>';
	                foreach ($step_1_fx_challenge as $sub_field_key => $sub_field_value) {
	                    // Assuming the subfield 'label' needs to be displayed
	                    // Fetch subfield object to get its label
	                    $sub_field_object = get_field_object($sub_field_key, $product_id);
	                    echo '<li>' . esc_html($sub_field_object['label']) . ': ' . esc_html($sub_field_value) . '</li>';
	                }
	                echo '</ul>';
	            }
	            echo '</div>'; // Close ypf-tab-panel
	        }
	        echo '</div>'; // Close ypf-tabs-content

	        echo '</div>'; // Close ypf-product-tabs
	    }
	    wp_reset_postdata();


		?>


		<div class="pricing__table">
		  <div class="pt__title">
		    <div class="pt__title__wrap">
		      <div class="pt__row"></div>
		      <div class="pt__row">Type of FX challenge (initial capital for trading)</div>
		      <div class="pt__row">Challenge period</div>
		      <div class="pt__row">Minimum trading period</div>
		      <div class="pt__row">Maximum loss rate per day</div>
		      <div class="pt__row">Overall loss rate</div>
		      <div class="pt__row">profit target</div>
		      <div class="pt__row">Maximum number of lots that can be owned at the same time</div>
		      <div class="pt__row">Profit distribution rate (trader: our company)</div>
		      <div class="pt__row">Entry amount</div>
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
		          <div class="pt__item recommend">
		            <div class="pt__item__wrap">
		              <div class="pt__row">STEP 1</div>
		              <div class="pt__row">150,000</div>
		              <div class="pt__row">Unlimited</div>
		              <div class="pt__row">Unlimited</div>
		              <div class="pt__row">Phone & Priority Support</div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row">
		                <a href="">Start Challenge</a>
		              </div>
		            </div>
		          </div>
		        </div>
		        <div class="swiper-slide pt__option__item">
		          <div class="pt__item">
		            <div class="pt__item__wrap">
		              <div class="pt__row">STEP 2</div>
		              <div class="pt__row">16,000</div>
		              <div class="pt__row">5 Seats</div>
		              <div class="pt__row">5 Audiences</div>
		              <div class="pt__row">24/7 Email & Chat Support</div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row">
		                <a href="">Start Challenge</a>
		              </div>
		            </div>
		          </div>
		        </div>
		        <div class="swiper-slide pt__option__item">
		          <div class="pt__item">
		            <div class="pt__item__wrap">
		              <div class="pt__row">STEP 2</div>
		              <div class="pt__row">5,000</div>
		              <div class="pt__row">3 Seats</div>
		              <div class="pt__row">3 Audiences</div>
		              <div class="pt__row">24/7 Email & Chat Support</div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row">Limited</div>
		              <div class="pt__row"><i class="fa-solid fa-check"></i></div>
		              <div class="pt__row">Limited</div>
		              <div class="pt__row">
		                <a href="">Start Challenge</a>
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>
		<script>
		// Pricing table - mobile only slider
		var init = false;
		var pricingCardSwiper;
		var pricingLoanSwiper
		function swiperCard() {
		  if (window.innerWidth <= 991) {
		    if (!init) {
		      init = true;
		      pricingCardSwiper = new Swiper("#pricingTableSlider", {
		        slidesPerView: "auto",
		        spaceBetween: 5,
		        grabCursor: true,
		        keyboard: true,
		        autoHeight: false,
		        navigation: {
		          nextEl: "#navBtnRight",
		          prevEl: "#navBtnLeft",
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