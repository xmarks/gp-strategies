<?php
/**
 * Override core scripts.php functions here
 *
 * @package Gp_Strategies
 */

/**
 * ┌─────────────────────────────────────────────────────────────────────────┐
 * │                                                                         │
 * │  IMPORTANT: DO NOT MODIFY /core/scripts.php                             │
 * │  Override functions here instead to preserve core functionality         │
 * │                                                                         │
 * └─────────────────────────────────────────────────────────────────────────┘
 */

if ( ! function_exists( 'gp_strategies_custom_scripts' ) ) {
	/**
	 * Custom Scripts & Styles
	 *
	 * Add your custom scripts and styles here.
	 * This function is called automatically by gp_strategies_scripts() in /core/scripts.php
	 *
	 * WHEN TO USE THIS:
	 * - Adding third-party libraries (not managed via /assets/ directories)
	 * - Conditional script loading based on page templates or post types
	 * - Scripts that require specific dependencies
	 * - Any custom wp_enqueue_script() or wp_enqueue_style() calls
	 *
	 * EXAMPLES:
	 * - Load scripts only on specific pages
	 * - Add Google Fonts, Analytics, or other third-party services
	 * - Enqueue registered scripts conditionally
	 *
	 * @return void
	 */
	function gp_strategies_custom_scripts(): void {
		/**
		 * ──────────────────────────────────────────────────────────────────────
		 * ADD YOUR CUSTOM SCRIPTS/STYLES BELOW
		 * ──────────────────────────────────────────────────────────────────────
		 */
	}
}
