<?php
defined( 'ABSPATH' ) || exit;
/**
 * Plugin Name: Next FeedBuilder
 * Description: FeedBuilder for Woo-commerce Template, Blog Template Builder, which will be supported for both Elementor and Gutenberg Page Builder.
 * Plugin URI: http://products.themedev.net/next-feed/
 * Author: ThemeDev
 * Version: 1.0.3
 * Author URI: http://themedev.net
 *
 * Text Domain: next-feed
 *
 * @package NextFeed
 * @category free
 *
 * Next FeedBuilder is mainly a WooCommerce plugin/Addons that provides another service for Blog sites which will be supported for both Elementor and Gutenberg Page Builder. It helps the user to build custom product page, archive page, blog page and more. It has plenty of product layouts alongside blog layouts with eye-catching designs. This plugin also has unlimited styling options that makes your website a beauty paradise.
 *
 * License:  GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

define( 'NEXTFEED_FILE_', __FILE__ );

include 'loader.php'; 
include 'plugin.php';

// load plugin
add_action( 'plugins_loaded', function(){
	// load text domain
	load_plugin_textdomain( 'next-feed',  false, basename( dirname( __FILE__ ) ) . '/languages' );

	// load plugin instance
	\NextFeed\Plugin::instance()->init();
}, 110); 


	

