<div class="wrap">
    <h1><?php esc_html_e('Iogly Settings', 'iogly') ?></h1>
    <form method="post">
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="siteurl"><?php esc_html_e('Iogly API Key', 'iogly') ?></label></th>
                    <td>
                        <input name="iogly_api_key" type="text" id="iogly_api_key" value="<?php echo esc_attr(get_option('iogly_api_key')) ?>" class="regular-text code" aria-describedby="iogly-api-key-description">
                        <p class="description" id="iogly-api-key-description">
                            <?php esc_html_e('You can find the API Key in the ', 'iogly') ?><a href="https://iogly.com/admin/" target="_blank"><?php esc_html_e('Iogly admin', 'iogly') ?></a><?php esc_html_e('. (Instances > View)', 'iogly') ?></p>
                    </td>
                </tr>
            </tbody>
        </table>

        <p class="submit">
            <?php wp_nonce_field(Iogly_Admin::NONCE) ?>
            <input type="hidden" name="action" value="save-settings" />
            <input type="submit" class="button button-primary" value="Save" />
        </p>
    </form>
</div>
