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

	public function get_script_depends() {
        return [ 'ypf-plugins-js' ];
    }

    public function get_style_depends() {
        return [ 'ypf-plugins-css' ];
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

	}

	public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_style( 'font-awesome-css', plugins_url( '/public/assets/css/font-awesome.min.css', __FILE__ ) );
        wp_register_style( 'swiper-bundle-css', plugins_url( '/public/assets/css/swiper-bundle.min.css', __FILE__ ) );
        wp_register_style( 'ypf-plugins-css', plugins_url( '/public/assets/css/ypf-plugins.css', __FILE__ ) );
        wp_register_script( 'swiper-bundle-js', plugins_url( '/public/assets/js/swiper-bundle.min.js', __FILE__ ));
        wp_register_script( 'ypf-plugins-js', plugins_url( '/public/assets/js/ypf-plugins.js', __FILE__ ), [ 'jquery' ] );
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