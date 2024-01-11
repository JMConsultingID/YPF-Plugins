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

    // require_once( __DIR__ . '/widgets/ypf-plugins-widget-pricing-table.php' );
    require_once( __DIR__ . '/widgets/ypf-plugins-widget-pricing-table-product.php' );   

    

    // $widgets_manager->register( new \Elementor_YpfPlugins_Widget_Pricing_Table() ); 
    $widgets_manager->register( new \Elementor_YpfPlugins_Widget_Pricing_Table_Per_Product() );  
}
add_action( 'elementor/widgets/register', 'register_ypfplugins_widget' );