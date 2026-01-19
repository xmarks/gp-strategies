<?php
/**
 * ST Core Bootstrap
 *
 * This file loads all core functionality.
 * Core files provide generic, updatable functionality.
 * Override functions in /inc/ for project-specific customizations.
 *
 * @package Gp_Strategies
 */

declare(strict_types=1);

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define core constants.
if ( ! defined( 'ST_CORE_VERSION' ) ) {
	define( 'ST_CORE_VERSION', '1.0.0' );
}

if ( ! defined( 'ST_CORE_PATH' ) ) {
	define( 'ST_CORE_PATH', __DIR__ );
}

/**
 * Theme Naming Patterns
 *
 * Defines this theme's naming conventions.
 * Used by toolkit commands for proper pattern replacement during core updates.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ST_THEME_PATTERNS' ) ) {
	define(
		'ST_THEME_PATTERNS',
		array(
			'git_repo'        => 'xmarks/gp-strategies',
			'text_domain'     => 'gp-strategies',
			'function_names'  => 'gp_strategies_',
			'doc_block'       => 'Gp_Strategies',
			'prefix_handlers' => 'gp-strategies-',
			'constants'       => 'GP_STRATEGIES_',
			'theme_name'      => 'GP Strategies',
			'theme_uri'       => 'https://github.com/xmarks/gp-strategies/',
			'author_name'     => 'ProCoders',
			'author_uri'      => 'https://procoders.tech/',
		)
	);
}

/**
 * Load core files in order
 * Each core file loads its /inc/ override first, then defines fallback functions.
 */
$core_files = array(
	'core.php',                    // Theme setup & configuration.
	'scripts.php',                 // Script & style enqueuing.
	'template-functions.php',      // Template enhancements.
	'template-tags.php',           // Template helper functions.
	'customizer.php',              // Customizer panels & settings.
	'customizer-functions.php',    // Customizer functionality.
	'woocommerce.php',             // WooCommerce integration.
	'jetpack.php',                 // Jetpack integration.
	'debug.php',                   // Debug utilities.
);

foreach ( $core_files as $file ) {
	$filepath = ST_CORE_PATH . '/' . $file;
	if ( file_exists( $filepath ) ) {
		require_once $filepath;
	}
}

/**
 * Fires after core files are loaded
 *
 * Allows themes to hook after core initialization.
 *
 * @since 1.0.0
 */
do_action( 'st_core_loaded' );
