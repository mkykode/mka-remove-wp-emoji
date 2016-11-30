<?php
namespace RemoveEmoji;
/**
 * Plugin Name: Monkey Kode Remove WP Emoji
 * Plugin URI:  http://monkeykode.com
 * Description: Removes all additional emoji js, css from Wordpress.
 * Version:     1.0.0
 * Author:      Jull Weber
 * Author URI:  http://monkeykode.com
 * License:     GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}


function remove_emoji() {

	/**
	 * Remove emoji crap
	 *
	 */

	function flush_emojicons() {
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		// filter to remove TinyMCE emojis
		add_filter( 'tiny_mce_plugins', __NAMESPACE__  . '\\disable_emojicons_tinymce' );

	}
	function disable_emojicons_tinymce( $plugins ) {
	  if ( is_array( $plugins ) ) {
	    return array_diff( $plugins, array( 'wpemoji' ) );
	  } else {
	    return array();
	  }
	}
	add_action( 'init', __NAMESPACE__  . '\\flush_emojicons' );
	add_filter( 'emoji_svg_url','__return_false' );



}

remove_emoji();

