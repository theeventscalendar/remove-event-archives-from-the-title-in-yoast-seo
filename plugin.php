<?php
/**
 * Plugin Name: The Events Calendar Extension: Remove "Event Archives" from the Title in Yoast SEO
 * Description: Removes the “Event Archives” sting from HTML title tags that can arise when Yoast SEO is active.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1971
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

class Tribe__Extension__Remove_Event_Archives_from_Title_in_Yoast_SEO {

    /**
     * The semantic version number of this extension; should always match the plugin header.
     */
    const VERSION = '1.0.0';

    /**
     * Each plugin required by this extension
     *
     * @var array Plugins are listed in 'main class' => 'minimum version #' format
     */
    public $plugins_required = array(
        'Tribe__Events__Main' => '4.2'
    );

    /**
     * The constructor; delays initializing the extension until all other plugins are loaded.
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
    }

    /**
     * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
     */
    public function init() {

        // Exit early if our framework is saying this extension should not run.
        if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
            return;
        }

        add_action( 'pre_get_posts', array( $this, 'remove_wpseo_title_rewrite' ), 20 );
    }

    /**
     * Attempt to remove "Event Archives" from Yoast SEO titles.
     */
    public function remove_wpseo_title_rewrite() {
    
        // When The Events Calendar and Events Calendar Pro are both activated.
        if ( class_exists( 'Tribe__Events__Main' ) && class_exists( 'Tribe__Events__Pro__Main' ) ) {
            
            if ( tribe_is_month() || tribe_is_upcoming() || tribe_is_past() || tribe_is_day() || tribe_is_map() || tribe_is_photo() || tribe_is_week() ) {
                $wpseo_front = WPSEO_Frontend::get_instance();
                remove_filter( 'wp_title', array( $wpseo_front, 'title' ), 15 );
                remove_filter( 'pre_get_document_title', array( $wpseo_front, 'title' ), 15 );
            }
        // When just The Events Calendar is activated.
        } elseif ( class_exists( 'Tribe__Events__Main' ) && !class_exists( 'Tribe__Events__Pro__Main' ) ) {
           
            if ( tribe_is_month() || tribe_is_upcoming() || tribe_is_past() || tribe_is_day() ) {
                $wpseo_front = WPSEO_Frontend::get_instance();
                remove_filter( 'wp_title', array( $wpseo_front, 'title' ), 15 );
                remove_filter( 'pre_get_document_title', array( $wpseo_front, 'title' ), 15 );
            }
        }
    }
}

new Tribe__Extension__Remove_Event_Archives_from_Title_in_Yoast_SEO();
