<?php
function linkages_custom_menu_page_callback() {
    if ( isset( $_POST['submit'] ) ) {
        if ($_POST['api_key'] == '') {
            echo '<div class="notice notice-error"><p>This Field cannot be empty</p></div>';
        }
        else {
            $api_key = sanitize_text_field( $_POST['api_key'] );
            update_option( 'linkages_api_key', $api_key );
            echo '<div class="notice notice-success"><p>API key saved successfully!</p></div>';
        }
    }
    ?>
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <div class="wrap">

            <form method="post">
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="api_key">Linkages API key</label></th>
                        <td>
                            <?php if ( get_option( 'linkages_api_key' ) ): ?>
                                <input type="text" name="api_key" id="api_key" class="regular-text" value="<?php echo esc_attr( get_option( 'linkages_api_key' ) ); ?>">
                            <?php else: ?>
                                <input type="text" name="api_key" id="api_key" class="regular-text">
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
                <br />
                <?php submit_button( 'Save API Key', 'primary', 'submit', false ); ?>
            </form>
    
    </div>

    <div class="wrap">

            <p>We need this key to activate the plugin. Visit <a href="#">this link</a> to learn how to obtain a key.</p>

        </div>
    <?php
}