<?php
/**
 * @wordpress-plugin
 * Plugin Name:       YPF Plugins
 * Plugin URI:        https://yourpropfirm.com/
 * Description:       A plugin to create custom pricing tables and integrate with Elementor widgets.
 * Version:           1.0.1
 * Author:            Ardi
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
        add_menu_page('YPF Plugins', 'YPF Plugins', 'manage_options', $this->plugin_name, array($this, 'display_plugin_admin_page'), 'dashicons-editor-table',99);
        add_submenu_page($this->plugin_name, 'YPF Pricing Table', 'YPF Pricing Table', 'manage_options', $this->plugin_name . '-pricing-table', array($this, 'display_ypf_pricing_table_admin_page'));
    }

    /**
     * Register settings for the plugin.
     */
    public function register_settings() {
        register_setting('ypfPricingTableOptionsGroup', 'ypf_enable_pricing_table');
        register_setting('ypfPricingTableOptionsGroup', 'ypf_enable_elementor_widget');
        register_setting('ypfPricingTableOptionsGroup', 'ypf_select_style_widget');
        register_setting('ypfPricingTableOptionsGroup', 'ypf_enable_tooltips');
        register_setting('ypfPricingTableOptionsGroup', 'ypf_select_post_tooltips');
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
        wp_register_style( 'ypf-font-awesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', __FILE__ );
        wp_register_style( 'ypf-swiper-bundle-css', plugins_url( '/public/assets/css/swiper-bundle.min.css', __FILE__ ) );
        wp_register_style( 'ypf-plugins-css', plugins_url( '/public/assets/css/ypf-plugins.css', __FILE__ ), array('ypf-font-awesome-css', 'ypf-swiper-bundle-css'), '1.0.0', 'all' );


        // Register scripts        
        wp_register_script( 'ypf-swiper-bundle-js', plugins_url( '/public/assets/js/swiper-bundle.min.js', __FILE__ ), array('jquery'), '1.0.0', true );
        wp_register_script( 'ypf-popper-js', 'https://unpkg.com/@popperjs/core@2.11.8/dist/umd/popper.min.js', __FILE__ , array(''), '2.0.0', true );
        wp_register_script( 'ypf-tippy-js', 'https://unpkg.com/tippy.js@6.3.7/dist/tippy-bundle.umd.min.js', __FILE__ , array(''), '2.0.0', true );
        wp_register_script( 'ypf-plugins-js', plugins_url( '/public/assets/js/ypf-plugins.js', __FILE__ ), array('jquery', 'ypf-swiper-bundle-js','ypf-popper-js', 'ypf-tippy-js'), '1.0.0', true );

    }
}
add_action( 'wp_enqueue_scripts', 'ypf_plugins_widgets', );

function check_for_shortcode_and_enqueue_scripts() {
    if ( get_option('ypf_enable_pricing_table') ) {
            // Enqueue scripts and styles here
            wp_enqueue_style('ypf-plugins-css');
            wp_enqueue_script('ypf-plugins-js');
    }
}
add_action('wp', 'check_for_shortcode_and_enqueue_scripts');


// Include the Elementor class
if ( get_option('ypf_enable_pricing_table') ) {
    require plugin_dir_path( __FILE__ ) . 'elementor/class-ypf-plugins-elementor.php';
    require plugin_dir_path( __FILE__ ) . 'shortcode/class-ypf-plugins-shortcode.php';
}

function display_acf_group_labels_and_tooltips_el($group_field_name, $tooltips_field_name, $product_id, $tooltips_post_id) {
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
            echo '<div class="pt__row heading-vertical ' . esc_html($sub_field_name) . ' pt__title__elementor"><div class="pt__row-heading-text">' . esc_html($sub_field_label) . $sub_field_tooltip_text . '</div></div>'; 
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

function display_acf_group_fields_el($group_field_name, $product_id, $css_class_prefix) {
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

function display_swiper_navigation_buttons_el($left_button_id, $right_button_id) {
    ?>
    <div class="pt__option__mobile__nav">
        <a id="<?php echo esc_attr($left_button_id); ?>" href="#" class="mobile__nav__btn swiper-button-prev">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.1538 11.9819H1.81972" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9863 22.1535L1.82043 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        <a id="<?php echo esc_attr($right_button_id); ?>" href="#" class="mobile__nav__btn swiper-button-next">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.81934 11.9819H22.1534" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9863 22.1535L22.1522 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
    <?php
}   
?>