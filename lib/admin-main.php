<div class="wrap">

    <div class="icon32" id="icon-options-general"><br></div>
    <h2><?php _e( 'Facebook Sync Settings', $this->slug ); ?></h2>

    <?php if ( $this->is_page_updated() ) : ?>

        <div class="updated"><p><?php _e( 'Options succesfully saved.', $this->slug ); ?></p></div>

    <?php endif; ?>

    <form method="POST" action="options.php">

        <?php settings_fields( $this->slug ); ?>

        <table class="form-table">

            <tr valid="top">
                <th scope="row" colspan="2">
                    <h3><?php _e( 'Facebook Credentials', $this->slug ); ?></h3>
                </th>
            </tr>

            <?php if ( !$this->have_credentials() ) : ?>

                <tr valign="top">
                    <td colspan="2">
                        <?php printf( __( 'In order to use this plugin you need to <a href="%s">create a Facebook Application</a> and provide the information below.', $this->slug ), $this->link_create_app ); ?>
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

            <?php if ( $this->have_credentials() ) : ?>

                <tr valign="top">
                    <th scope="row">
                        <label for="<?php echo $this->slug; ?>_access_token">
                            <?php _e( 'Stored Access Token', $this->slug ); ?>
                        </label>
                    </th>
                    <td>

                        <?php if ( $this->have_access_token() ) : ?>
                            <p><?php echo get_option( $this->slug . '_access_token' ); ?></p>
                        <?php else : ?>
                            <p><?php _e( 'You need now to require an access token to fetch info from Facebook.', $this->slug ); ?></p>
                        <?php endif; ?>

                        <?php
                            $params = array(
                                'scope' => 'email,user_activities',
                                'redirect_uri' => admin_url( 'admin.php?page=' . $this->slug )
                            );
                            $login_url = $this->fb->getLoginUrl( $params );
                        ?>

                        <p><?php printf( __( '<a href="%s">Click here</a> to get a new access token.', $this->slug ), $login_url ); ?></p>

                    </td>
                </tr>

            <?php endif; ?>

            <tr valign="top">
                <td colspan="2">
                    <p>
                        <a
                            class="button"
                            href="<?php echo admin_url( 'admin.php?page=' . $this->slug . '_test' ); ?>">
                            <?php _e( 'Test Credentials', $this->slug ); ?>
                        </a>&nbsp;
                        <?php submit_button( false, 'primary', false, false ); ?>
                    </p>
                </td>
            </tr>

        </table>


    </form>

</div>
