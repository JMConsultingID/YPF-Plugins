<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action='options.php' method='post'>

        <h2>YPF Pricing Table</h2>

        <?php
        settings_fields( 'ypfPricingTableOptionsGroup' );
        do_settings_sections( 'ypfPricingTableOptionsGroup' );
        ?>

        <table class="form-table">
            <tr valign="top">
                <th scope="row">Enable Pricing Table:</th>
                <td>
                    <input type="checkbox" id="ypf_enable_pricing_table" name="ypf_enable_pricing_table" value="1" <?php checked(1, get_option('ypf_enable_pricing_table'), true); ?> />
                    <label for="ypf_enable_pricing_table">Enable the pricing table feature.</label>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Enable Elementor Widget:</th>
                <td>
                    <input type="checkbox" id="ypf_enable_elementor_widget" name="ypf_enable_elementor_widget" value="1" <?php checked(1, get_option('ypf_enable_elementor_widget'), true); ?> />
                    <label for="ypf_enable_elementor_widget">Enable the Elementor widget feature. <code>[under development, but you can use it]</code></label>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Select Widget Style:</th>
                <td>
                    <select id="ypf_widget_style" name="ypf_widget_style">
                        <option value="style1" <?php selected(get_option('ypf_widget_style'), 'style1'); ?>>Style 1</option>
                        <option value="style2" <?php selected(get_option('ypf_widget_style'), 'style2'); ?>>Style 2</option>
                        <option value="style3" <?php selected(get_option('ypf_widget_style'), 'style3'); ?>>Style 3</option>
                    </select>
                    <label for="ypf_widget_style">Choose the style for the Elementor widget. <code>[under development]</code></label>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Default Shortcode Format :</th>
                <td>
                    <code>[ypf-pricing-table productID="23" free_trial_btn="無料体験" challenge_begins_btn="チャレンジ開始"]</code>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Download ACF Configuration :</th>
                <td>
                    This plugin requires the <a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank">Advanced Custom Fields Plugin</a>. Please ensure it is installed and activated. here is to download the default configuration file for the plugin. <a href="https://staging.finpr.com/upload/import-settings-acf.js">Download here</a>.</p>
                </td>
            </tr>
            
        </table>
        <p>If you have any questions or need assistance, Please Open an issue in the <a href="https://github.com/JMConsultingID/ypf-plugins">[GitHub repository]</a></p>

        <?php submit_button(); ?>

    </form>
</div>
