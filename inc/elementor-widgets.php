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
 * Enqueue scripts for Elementor editor preview
 *
 * @return void
 */
function gp_strategies_elementor_editor_scripts(): void {
	// Enqueue widget styles.
	wp_enqueue_style( 'plugins.splidejs.core' );
	wp_enqueue_style( 'plugins.elementor.vertical-slider' );

	// Enqueue widget scripts.
	wp_enqueue_script( 'plugins.splidejs.splide' );
	wp_enqueue_script( 'plugins.elementor.vertical-slider' );

	// Editor-specific script.
	wp_enqueue_script( 'plugins.elementor.vertical-slider-editor' );
}
add_action( 'elementor/editor/before_enqueue_scripts', 'gp_strategies_elementor_editor_scripts' );
add_action( 'elementor/preview/enqueue_scripts', 'gp_strategies_elementor_editor_scripts' );

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
	// GP Vertical Slider widget.
	require_once get_template_directory() . '/inc/elementor-widgets/vertical-slider/class-vertical-slider.php';
	$widgets_manager->register( new GP_Vertical_Slider_Widget() );
}
add_action( 'elementor/widgets/register', 'gp_strategies_register_elementor_widgets' );
