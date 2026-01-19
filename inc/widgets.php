<?php
/**
 * GP Strategies widgets functions
 *
 * Register widget area
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @package Gp_Strategies
 */

if ( ! function_exists( 'gp_strategies_widgets_init' ) ) {
	/**
	 * Register sidebar
	 *
	 * @return void
	 */
	function gp_strategies_widgets_init(): void {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Sidebar', 'gp-strategies' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Add widgets here.', 'gp-strategies' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'gp_strategies_widgets_init' );
