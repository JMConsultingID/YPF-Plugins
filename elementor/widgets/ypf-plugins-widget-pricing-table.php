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
        // Include swiper-bundle.min.js as a dependency
        return [ 'ypf-plugins-js', 'swiper-bundle-js' ];
    }

    public function get_style_depends() {
        // Include font-awesome.min.css and swiper-bundle.min.css as dependencies
        return [ 'ypf-plugins-css', 'font-awesome-css', 'swiper-bundle-css' ];
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