<div class="wrap">

    <div class="icon32" id="icon-options-general"><br></div>
    <h2><?php _e( 'Facebook Sync Options', $this->slug ); ?></h2>

    <form method="POST" action="options.php">

        <?php settings_fields( $this->slug ); ?>

        <table class="form-table">

            <tr valid="top">
                <th scope="row" colspan="2">
                    <h3><?php _e( 'Facebook Credentials', $this->slug ); ?></h3>
                </th>
            </tr>

            <?php if ( !get_option( $this->slug . '_app_id' ) || !get_option( $this->slug . '_app_secret' ) ) : ?>

                <tr valign="top">
                    <td colspan="2">
                        <?php printf( __( 'In order to use this plugin you need to <a href="%s">create a Facebook Application</a>.', $this->slug ), $this->link_create_app ); ?>
                    </td>
                </tr>

            <?php endif; ?>

            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo $this->slug; ?>_app_id">
                        <?php _e( 'Facebook App ID', $this->slug ); ?>
                    </label>
                </th>
                <td>
                    <input
                        type="text"
                        name="<?php echo $this->slug; ?>_app_id"
                        value="<?php echo get_option( $this->slug . '_app_id' ); ?>" />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo $this->slug; ?>_app_secret">
                        <?php _e( 'Facebook App Secret', $this->slug ); ?>
                    </label>
                </th>
                <td>
                    <input
                        type="text"
                        name="<?php echo $this->slug; ?>_app_secret"
                        value="<?php echo get_option( $this->slug . '_app_secret' ); ?>" />
                </td>
            </tr>

        </table>

        <?php submit_button(); ?>

        <textarea style="width:100%; height:300px;">

            <?php echo $this->fetch(); ?>

        </textarea>

    </form>

</div>
