<div class="wrap">

    <div class="icon32" id="icon-options-general"><br></div>
    <h2><?php _e( 'Facebook Sync Settings', $this->slug ); ?></h2>

    <?php if ( $this->is_page_updated() ) : ?>

        <div class="updated"><p><?php _e( 'Options succesfully saved.', $this->slug ); ?></p></div>

    <?php endif; ?>

    <form method="POST" action="options.php" id="<?php echo $this->slug; ?>_form">

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

            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo $this->slug; ?>_user_id">
                        <?php _e( 'Facebook User ID', $this->slug ); ?>
                    </label>
                </th>
                <td>
                    <input
                        type="text"
                        name="<?php echo $this->slug; ?>_user_id"
                        value="<?php echo get_option( $this->slug . '_user_id' ); ?>" />
                    <p class="description">
                        <?php _e( 'This can be a user, page or group ID. To get your ID visit http://graph.facebook.com/YOUR_USERNAME', $this->slug ); ?>
                    </p>
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

            <?php if ( $this->have_credentials() && $this->have_access_token() ) : ?>

                <tr valid="top">
                    <th scope="row" colspan="2">
                        <h3><?php _e( 'Settings', $this->slug ); ?></h3>
                    </th>
                </tr>

                <?php
                    $types = array(
                        'status_updates' => __( 'Status updates' ),
                        'status_updates_comments' => __( 'Comments on status updates (requires the above setting)' )
                    );
                ?>

                <tr valign="top">
                    <th scope="row">
                        <?php _e( 'Content to be copied', $this->slug ); ?>
                    </th>
                    <td>
                    <fieldset>

                        <?php foreach( $types as $k => $v ) : ?>

                            <?php $id = $this->slug . '_content_' . $k; ?>

                            <label for="<?php echo $id; ?>">
                                <input
                                    type="checkbox"
                                    value="<?php echo $k; ?>"
                                    id="<?php echo $id; ?>"
                                    name="<?php echo $this->slug; ?>_content[]"
                                    <?php echo in_array( $k, $this->content ) ? 'checked="checked"' : ''; ?> />
                                <?php echo $v; ?>
                            </label><br/>

                        <?php endforeach; ?>

                    </fieldset>
                    </td>
                </tr>

            <?php endif; ?>

            <tr valign="top">
                <td colspan="2">
                    <p>
                        <a
                            class="button"
                            href="javascript:void(0);"
                            id="<?php echo $this->slug; ?>_test_sync">
                            <?php _e( 'Test Sync', $this->slug ); ?>
                        </a>&nbsp;
                        <?php submit_button( false, 'primary', false, false ); ?>
                    </p>
                </td>
            </tr>

        </table>

        <input type="hidden" name="<?php echo $this->slug; ?>_save" value="1" />

    </form>

    <div id="<?php echo $this->slug; ?>_test_sync_result"></div>

</div>

<script type="text/javascript">

var form = jQuery('#<?php echo $this->slug; ?>_form');
var test = jQuery('#<?php echo $this->slug; ?>_test_sync');
var result = jQuery('#<?php echo $this->slug; ?>_test_sync_result');

test.click(function(){

    jQuery.ajax({
        url: ajaxurl,
        data: {
            'action': '<?php echo $this->slug; ?>_test_sync',
            'form': form.serialize()
        },
        success: function(data) {
            jQuery(result).html(data);
            result.slideDown();
        }
    });

});


</script>
