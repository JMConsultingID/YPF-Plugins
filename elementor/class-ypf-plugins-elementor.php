<?php

function add_ypf_plugins_categories( $elements_manager ) {

    $elements_manager->add_category(
        'ab-ypfplugins-category',
        [
            'title' => esc_html__( 'YPF Plugins Widget', 'ypf-plugins' ),
            'icon' => 'fa fa-plug',
        ]
    );
}
add_action( 'elementor/elements/categories_registered', 'add_ypf_plugins_categories' );

function register_ypfplugins_widget( $widgets_manager ) {

    require_once( __DIR__ . '/widgets/ypf-plugins-widget-pricing-table.php' );

    

    $widgets_manager->register( new \Elementor_YpfPlugins_Widget_Pricing_Table() );   
}
add_action( 'elementor/widgets/register', 'register_ypfplugins_widget' );

/**
 * Register scripts and styles for Elementor test widgets.
 */
function elementor_test_widgets_dependencies() {
    // Register styles        
    wp_register_style( 'font-awesome-css', plugins_url( '/public/assets/css/font-awesome.min.css', __FILE__ ) );
    wp_register_style( 'swiper-bundle-css', plugins_url( '/public/assets/css/swiper-bundle.min.css', __FILE__ ) );
    wp_register_style( 'ypf-plugins-css', plugins_url( '/public/assets/css/ypf-plugins.css', __FILE__ ) );
    
    // Register scripts        
    wp_register_script( 'swiper-bundle-js', plugins_url( '/public/assets/js/swiper-bundle.min.js', __FILE__ ), [], false, true );
    wp_register_script( 'ypf-plugins-js', plugins_url( '/public/assets/js/ypf-plugins.js', __FILE__ ), [ 'jquery' ], false, true );

}
add_action( 'wp_enqueue_scripts', 'elementor_test_widgets_dependencies' );