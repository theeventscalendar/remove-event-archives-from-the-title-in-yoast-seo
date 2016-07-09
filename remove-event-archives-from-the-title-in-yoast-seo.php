<?php
/**
 * Plugin Name: The Events Calendar — Remove “Event Archives” from the Title in Yoast SEO
 * Description: Removes the “Event Archives” sting from HTML title tags that can arise when Yoast SEO is active.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1x
 * License: GPLv2 or later
 */
 
defined( 'WPINC' ) or die;

function tribe_remove_wpseo_title_rewrite() {
    
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

add_action( 'pre_get_posts', 'tribe_remove_wpseo_title_rewrite', 20 );
