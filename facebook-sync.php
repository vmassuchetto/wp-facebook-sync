<?php
/*
 * Plugin Name: Facebook Sync
 * Plugin URI: http://vinicius.soylocoporti.org.br/facebook-sync-wordpress-plugin
 * Description: Sync content from Facebook to WordPress.
 * Version: 0.01
 * Author: Vinicius Massuchetto
 * Author URI: http://vinicius.soylocoporti.org.br
 */

class FB_Sync {

    var $random;
    var $slug;
    var $basedir;
    var $baseurl;

    function FB_Sync () {

        $this->random = rand( 0, 10000 );
        $this->slug = 'fb_sync';
        $this->link_create_app = 'http://developers.facebook.com/apps';
        $this->link_explorer = 'https://developers.facebook.com/tools/explorer';

        $this->basedir = plugin_dir_path( __FILE__ );
        $this->baseurl = plugin_dir_url( __FILE__ );

        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );

    }

    function admin_init() {

        $this->register_settings();

        if ( !$this->is_plugin_page() )
            return false;

        if ( $this->have_credentials() ) {

            require( $this->basedir . 'inc/facebook-php-sdk/facebook.php' );
            $config = array(
                'appId'  => get_option( $this->slug . '_app_id' ),
                'secret' => get_option( $this->slug . '_app_secret' ),
            );
            $this->fb = new Facebook( $config );

        }

        wp_enqueue_style( $this->slug, $this->baseurl . 'css/admin.css' );

    }

    function admin_menu() {
        add_menu_page(
            __( 'Facebook Sync', $this->slug ),
            __( 'FB Sync', $this->slug ),
            'edit_posts', $this->slug,
            array( $this, 'admin_main' ),
            false, '59.' . $this->random );
        add_submenu_page(
            $this->slug,
            __( 'Settings', $this->slug ),
            __( 'Settings', $this->slug ),
            'edit_posts', $this->slug,
            array( $this, 'admin_main' ) );
        add_submenu_page(
            $this->slug,
            __( 'Test Sync', $this->slug ),
            __( 'Test Sync', $this->slug ),
            'edit_posts', $this->slug . '_test',
            array( $this, 'admin_test' ) );
    }

    function admin_main() {
        include( $this->basedir . 'lib/admin-main.php' );
    }

    function admin_test() {
        include( $this->basedir . 'lib/admin-test.php' );
    }

    function is_page_updated() {
        if ( !empty( $_GET['settings-updated'] )
            && 'true' == $_GET['settings-updated'] )
            return true;
        return false;
    }

    function is_plugin_page() {
        if ( !empty( $_GET['page'] )
            && preg_match( '/^' . $this->slug . '/', $_GET['page'] ) )
            return true;
        return false;
    }

    function have_credentials() {
        if ( get_option( $this->slug . '_app_id' )
            && get_option( $this->slug . '_app_secret' )
            && get_option( $this->slug . '_username' ) )
            return true;
        return false;
    }

    function have_access_token() {
        if ( get_option( $this->slug . '_access_token' ) )
            return true;
        return false;
    }

    function register_settings() {
        $settings = array(
            'app_id',
            'app_secret',
            'access_token'
        );
        foreach ( $settings as $s ) {
            register_setting( $this->slug, $this->slug . '_' . $s );
        }
    }

    function fetch() {

        if ( !get_option( $this->slug . '_app_id' ) ||
            !get_option( $this->slug . '_app_secret' ) )
            return false;


        //$fb_posts = $fb->api( '/' . get_option( $this->slug . '_username' ) . '/feed', 'GET' );
        $fb_posts = $fb->api( '/me/feed', 'GET' );

        print_r( $fb_posts );

    }

}

function fb_sync_init() {
    new FB_Sync();
}
add_action( 'plugins_loaded', 'fb_sync_init' );
