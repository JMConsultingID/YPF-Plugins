<?php


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'YPF_PLUGIN_VERSION', '1.0.1' );


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
    $settings_link = '<a href="admin.php?page=ypf-plugins-menu">Settings</a>';
    array_push($links, $settings_link);
    return $links;
}

/**
 * Register scripts and styles for Elementor test widgets.
 */
function ypf_plugins_widgets() {
    // Register styles        
    wp_register_style( 'ypf-font-awesome-css', plugins_url( '/public/assets/css/font-awesome.min.css', __FILE__ ) );
    wp_register_style( 'ypf-swiper-bundle-css', plugins_url( '/public/assets/css/swiper-bundle.min.css', __FILE__ ) );
    wp_register_style( 'ypf-plugins-css', plugins_url( '/public/assets/css/ypf-plugins.css', __FILE__ ), array('ypf-plugins'), '1.0.0', true );

    // Register scripts        
    wp_register_script( 'ypf-swiper-bundle-js', plugins_url( '/public/assets/js/swiper-bundle.min.js', __FILE__ ) );
    wp_register_script( 'ypf-plugins-js', plugins_url( '/public/assets/js/ypf-plugins.js', __FILE__ ), [ 'jquery' ] );
}
add_action( 'wp_enqueue_scripts', 'ypf_plugins_widgets' );

require plugin_dir_path( __FILE__ ) . 'elementor/class-ypf-plugins-elementor.php';

// Initialize the plugin class
if ( ! class_exists( 'YPF_Plugins' ) ) {

    class YPF_Plugins {

        private $menu_slug = 'ypf-plugins-menu';
        private $pricing_table_slug = 'ypf-plugins-pricing-table';

        public function __construct() {
            add_action( 'admin_menu', array( $this, 'ypf_create_menu' ) );
        }

        // Function to create menu and sub menu
        public function ypf_create_menu() {
            // Create new top-level menu
            add_menu_page( 
                'YPF Plugins', 
                'YPF Plugins', 
                'manage_options',
                $this->menu_slug, 
                array( $this, 'ypf_settings_page' ), 
                'dashicons-admin-generic' 
            );

            // Create a sub menu
            add_submenu_page( 
                $this->menu_slug, 
                'YPF Pricing Table', 
                'YPF Pricing Table', 
                'manage_options', 
                $this->pricing_table_slug, 
                array( $this, 'ypf_pricing_table_settings_page' )
            );
        }

        // Function for the main settings page
        public function ypf_settings_page() {
            // Page content
            echo '<div class="wrap">';
            echo '<h1>YPF Plugins Settings</h1>';
            echo '</div>';
        }

        // Function for the pricing table settings page
        public function ypf_pricing_table_settings_page() {
            // Page content for Pricing Table settings
            echo '<div class="wrap">';
            echo '<h1>YPF Pricing Table Settings</h1>';
            // Check if the user has the right permission
            if ( !current_user_can( 'manage_options' ) )  {
                wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
            }

            // Settings form
            ?>
            <form method="post" action="options.php">
                <?php settings_fields( 'ypf-plugin-settings-group' ); ?>
                <?php do_settings_sections( 'ypf-plugin-settings-group' ); ?>
                <table class="form-table">
                    <tr valign="top">
                    <th scope="row">Enable Pricing Table</th>
                    <td><input type="checkbox" name="enable_pricing_table" value="1" <?php checked(1, get_option('enable_pricing_table'), true); ?> /></td>
                    </tr>
                     
                    <tr valign="top">
                    <th scope="row">Enable Elementor Widget</th>
                    <td><input type="checkbox" name="enable_elementor_widget" value="1" <?php checked(1, get_option('enable_elementor_widget'), true); ?> /></td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">Select Style Widget</th>
                    <td>
                        <select name="style_widget">
                            <option value="style1" <?php selected( get_option('style_widget'), 'style1'); ?>>Style 1</option>
                            <option value="style2" <?php selected( get_option('style_widget'), 'style2'); ?>>Style 2</option>
                            <option value="style3" <?php selected( get_option('style_widget'), 'style3'); ?>>Style 3</option>
                        </select>
                    </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>

            </form>
            </div>
            <?php
        }
    }

    $ypf_plugins = new YPF_Plugins();
}

?>