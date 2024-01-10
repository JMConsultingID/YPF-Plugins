<?php
/**
 * @wordpress-plugin
 * Plugin Name:       YPF Plugins
 * Plugin URI:        https://yourpropfirm.com/
 * Description:       A plugin to create custom pricing tables and integrate with Elementor widgets.
 * Version:           1.0.1
 * Author:            Ardika JM Consulting
 * Author URI:        https://yourpropfirm.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ypf-plugins
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
class YPF_Plugins {

    /**
     * The unique identifier of this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     */
    public function __construct() {
        if (defined('YPF_PLUGINS_VERSION')) {
            $this->version = YPF_PLUGINS_VERSION;
        } else {
            $this->version = '1.0';
        }
        $this->plugin_name = 'ypf-plugins';

        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     */
    private function load_dependencies() {
        // Load dependencies, if any
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     */
    private function define_admin_hooks() {
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     */
    public function add_plugin_admin_menu() {
        add_menu_page('YPF Plugins', 'YPF Plugins', 'manage_options', $this->plugin_name, array($this, 'display_plugin_admin_page'), 'dashicons-admin-generic');
        add_submenu_page($this->plugin_name, 'YPF Pricing Table', 'YPF Pricing Table', 'manage_options', $this->plugin_name . '-pricing-table', array($this, 'display_ypf_pricing_table_admin_page'));
    }

    /**
     * Register settings for the plugin.
     */
    public function register_settings() {
        register_setting('ypfPricingTableOptionsGroup', 'ypf_enable_pricing_table');
        register_setting('ypfPricingTableOptionsGroup', 'ypf_enable_elementor_widget');
        register_setting('ypfPricingTableOptionsGroup', 'ypf_select_style_widget');
    }

    /**
     * The page that will be displayed in the Admin dashboard.
     */
    public function display_plugin_admin_page() {
        include_once 'admin/partials/ypf-plugins-admin-display.php';
    }

    /**
     * The page that will be displayed in the "YPF Pricing Table" submenu.
     */
    public function display_ypf_pricing_table_admin_page() {
        include_once 'admin/partials/ypf-plugins-pricing-table-admin-display.php';
    }

}

/**
 * Begins execution of the plugin.
 */
function run_ypf_plugins() {
    $plugin = new YPF_Plugins();
}
run_ypf_plugins();

/**
 * Check for required plugins on activation.
 */
function ypf_plugins_activate() {
    if (!class_exists('ACF')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('This plugin requires ACF. Please install Advanced Custom Fields and activate it.');
    }
}
register_activation_hook(__FILE__, 'ypf_plugins_activate');

// Check if ACF is active, if not show admin notice
add_action('admin_init', 'ypf_check_acf_installed');
function ypf_check_acf_installed(){
    if ( !class_exists('ACF') ) {
        add_action('admin_notices', 'ypf_acf_admin_notice');
    }
}

function ypf_acf_admin_notice(){
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e('YPF Plugins requires Advanced Custom Fields to function properly.', 'ypf-plugin'); ?></p>
    </div>
    <?php
}

// Add settings link to plugins page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'ypf_plugins_settings_link');
function ypf_plugins_settings_link($links) {
    $settings_link = '<a href="admin.php?page=ypf-plugins">Settings</a>';
    array_push($links, $settings_link);
    return $links;
}

/**
 * Register scripts and styles for Elementor test widgets.
 */
function ypf_plugins_widgets() {
    // Check if the pricing table is enabled
    if ( get_option('ypf_enable_pricing_table') ) {
        // Register styles        
        wp_register_style( 'ypf-font-awesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', __FILE__ );
        wp_register_style( 'ypf-swiper-bundle-css', plugins_url( '/public/assets/css/swiper-bundle.min.css', __FILE__ ) );
        wp_register_style( 'ypf-plugins-css', plugins_url( '/public/assets/css/ypf-plugins.css', __FILE__ ), array('ypf-font-awesome-css', 'ypf-swiper-bundle-css'), '1.0.0', 'all' );


        // Register scripts        
        wp_register_script( 'ypf-swiper-bundle-js', plugins_url( '/public/assets/js/swiper-bundle.min.js', __FILE__ ), array('jquery'), '1.0.0', true );
        wp_register_script( 'ypf-plugins-js', plugins_url( '/public/assets/js/ypf-plugins.js', __FILE__ ), array('jquery', 'ypf-swiper-bundle-js'), '1.0.0', true );

        // Enqueue styles and scripts
        wp_enqueue_style( 'ypf-plugins-css',999 );
        wp_enqueue_script( 'ypf-plugins-js',999 ); 
    }
}
add_action( 'wp_enqueue_scripts', 'ypf_plugins_widgets', );

// Include the Elementor class
if ( get_option('ypf_enable_pricing_table') ) {
    require plugin_dir_path( __FILE__ ) . 'elementor/class-ypf-plugins-elementor.php';
    require plugin_dir_path( __FILE__ ) . 'shortcode/class-ypf-plugins-shortcode.php';
}   
?>