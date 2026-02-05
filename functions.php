<?php
/**
 * GP Strategies functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Gp_Strategies
 */

declare(strict_types=1);

/**
 * Load Composer autoloader if present
 */
if ( file_exists( get_template_directory() . '/vendor/autoload.php' ) ) {
	require_once get_template_directory() . '/vendor/autoload.php';
}

// Define theme version.
if ( ! defined( 'GP_STRATEGIES_VERSION' ) ) {
	define( 'GP_STRATEGIES_VERSION', '1.0.5' );
}

// Define theme path constant.
if ( ! defined( 'ST_THEME_PATH' ) ) {
	define( 'ST_THEME_PATH', get_template_directory() );
}

/**
 * Load Core Bootstrap
 *
 * Loads all core functionality from /core/ directory.
 * Core files can be overridden in /inc/ directory.
 *
 * Core files loaded via bootstrap:
 * - core.php (Theme setup & configuration)
 * - scripts.php (Script & style enqueuing)
 * - template-functions.php (Template enhancements)
 * - template-tags.php (Template helper functions)
 * - customizer.php (Customizer panels & settings)
 * - customizer-functions.php (Customizer functionality)
 * - woocommerce.php (WooCommerce integration)
 * - jetpack.php (Jetpack integration)
 * - debug.php (Debug utilities)
 */
require_once ST_THEME_PATH . '/core/bootstrap.php';

// Load theme Custom Post Type.
require_once ST_THEME_PATH . '/inc/cpt.php';

// Load theme Widgets.
require_once ST_THEME_PATH . '/inc/widgets.php';

// Load Elementor custom widgets.
require_once ST_THEME_PATH . '/inc/elementor-widgets.php';

// Legacy Support.
require_once ST_THEME_PATH . '/inc/legacy.php';
