<?php
/**
 * Plugin Name: YPF Plugins
 * Description: A plugin to create custom pricing tables and integrate with Elementor widgets.
 * Version: 1.0
 * Author: Ardi
 * Author URI: https://yourpropfirm.com
 */

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
    $settings_link = '<a href="#">Settings</a>';
    array_push($links, $settings_link);
    return $links;
}

require plugin_dir_path( __FILE__ ) . 'elementor/class-ypf-plugins-elementor.php';

// Initialize the plugin class
if ( ! class_exists( 'YPF_Plugins' ) ) {

    class YPF_Plugins {

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
                'ypf-plugins', 
                'ypf_plugins_settings_page', 
                'dashicons-admin-generic' 
            );

            // Create a sub menu
            add_submenu_page( 
                'ypf-plugins', 
                'YPF Pricing Table', 
                'YPF Pricing Table', 
                'manage_options', 
                'ypf-plugins-pricing-table', 
                'ypf_plugins_pricing_table_settings'
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
