<?php
/**
 * Elementor Widgets Loader
 *
 * Register custom Elementor widgets for GP Strategies theme
 *
 * @package Gp_Strategies
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register scripts and styles for the widget
 *
 * @return void
 */
function gp_strategies_vss_register_scripts(): void {
	// SplideJS Core CSS.
	wp_register_style(
		'splide-core-css',
		get_template_directory_uri() . '/assets/css/styles-register/plugins/splidejs/core.min.css',
		array(),
		GP_STRATEGIES_VERSION
	);

	// SplideJS JavaScript.
	wp_register_script(
		'splide-js',
		get_template_directory_uri() . '/assets/js/scripts-register/plugins/splidejs/splide.min.js',
		array(),
		GP_STRATEGIES_VERSION,
		true
	);

	// Widget-specific CSS.
	wp_register_style(
		'vertical-slider-services-css',
		get_template_directory_uri() . '/assets/css/styles-register/plugins/vertical-slider-services.min.css',
		array( 'splide-core-css' ),
		GP_STRATEGIES_VERSION
	);

	// Widget-specific JavaScript.
	wp_register_script(
		'vertical-slider-services-js',
		get_template_directory_uri() . '/assets/js/scripts-register/plugins/vertical-slider-services.min.js',
		array( 'splide-js' ),
		GP_STRATEGIES_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'gp_strategies_vss_register_scripts' );

/**
 * Register scripts for Elementor editor
 *
 * @return void
 */
function gp_strategies_vss_editor_scripts(): void {
	// Register first.
	gp_strategies_vss_register_scripts();

	// Enqueue for preview.
	wp_enqueue_style( 'splide-core-css' );
	wp_enqueue_style( 'vertical-slider-services-css' );
	wp_enqueue_script( 'splide-js' );
	wp_enqueue_script( 'vertical-slider-services-js' );

	// Editor-specific script.
	wp_enqueue_script(
		'vertical-slider-services-editor',
		get_template_directory_uri() . '/assets/js/scripts-register/plugins/vertical-slider-services-editor.min.js',
		array( 'elementor-frontend', 'splide-js' ),
		GP_STRATEGIES_VERSION,
		true
	);
}
add_action( 'elementor/editor/before_enqueue_scripts', 'gp_strategies_vss_editor_scripts' );
add_action( 'elementor/preview/enqueue_scripts', 'gp_strategies_vss_editor_scripts' );

/**
 * Register custom widget category
 *
 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
 * @return void
 */
function gp_strategies_add_elementor_widget_categories( $elements_manager ): void {
	$elements_manager->add_category(
		'gp-strategies',
		array(
			'title' => esc_html__( 'GP Strategies', 'gp-strategies' ),
			'icon'  => 'fa fa-plug',
		)
	);
}
add_action( 'elementor/elements/categories_registered', 'gp_strategies_add_elementor_widget_categories' );

/**
 * Register custom Elementor widgets
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function gp_strategies_register_elementor_widgets( $widgets_manager ): void {
	// Debug log.
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( 'GP Strategies: Registering Elementor widgets...' );
	}

	// Include widget file.
	require_once get_template_directory() . '/inc/elementor-widgets/class-vertical-slider-services.php';

	// Register widget.
	$widgets_manager->register( new Vertical_Slider_Services_Widget() );

	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( 'GP Strategies: Vertical Slider Services widget registered.' );
	}
}
add_action( 'elementor/widgets/register', 'gp_strategies_register_elementor_widgets' );
