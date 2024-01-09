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
                    <label for="ypf_enable_elementor_widget">Enable the Elementor widget feature.</label>
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
                    <label for="ypf_widget_style">Choose the style for the Elementor widget.</label>
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>

    </form>
</div>
