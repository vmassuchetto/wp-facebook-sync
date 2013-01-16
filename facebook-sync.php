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

        $this->basedir = plugin_dir_path( __FILE__ );
        $this->baseurl = plugin_dir_url( __FILE__ );

        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );

    }

    function admin_init() {
        $this->register_settings();
        wp_enqueue_style( $this->slug, $this->baseurl . 'css/admin.css' );
    }

    function admin_menu() {
        add_menu_page(
            __( 'Facebook Sync', $this->slug ),
            __( 'FB Sync', $this->slug ),
            'edit_posts', $this->slug, array( $this, 'admin_page' ),
            false, '59.' . $this->random );
    }

    function admin_page() {
        include( $this->basedir . 'lib/admin.php' );
    }

    function register_settings() {
        $settings = array(
            'app_id',
            'app_secret'
        );
        foreach ( $settings as $s ) {
            register_setting( $this->slug, $this->slug . '_' . $s );
        }
    }

    function fetch() {

        if ( !get_option( $this->slug . '_app_id' ) ||
            !get_option( $this->slug . '_app_secret' ) )
            return false;

        require( $this->basedir . 'inc/facebook-php-sdk/facebook.php' );

        $config = array(
            'appId'  => get_option( $this->slug . '_app_id' ),
            'secret' => get_option( $this->slug . '_app_secret' ),
        );

        $fb = new Facebook( $config );
        $fb_posts = $fb->api( '/viniciusmassuchetto/feed', 'GET' );

        print_r( $fb_posts );

    }

}

function fb_sync_init() {
    new FB_Sync();
}
add_action( 'plugins_loaded', 'fb_sync_init' );
