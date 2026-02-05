<?php
/**
 * GP Strategies core functions & overrides
 *
 * @package Gp_Strategies
 */

if ( ! function_exists( 'gp_strategies_setup' ) ) {
	/**
	 *  Sets up theme defaults and registers support for various WordPress features.
	 *
	 *  Note that this function is hooked into the after_setup_theme hook, which
	 *  runs before the init hook. The init hook is too late for some features, such
	 *  as indicating support for post thumbnails.
	 *
	 * @return void
	 */
	function gp_strategies_setup(): void {
		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on GP Strategies, use a find and replace
		* to change 'gp-strategies' to the name of your theme in all the template files.
		*/
		load_theme_textdomain( 'gp-strategies', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'gp-strategies' ),
			)
		);

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
}
add_action( 'after_setup_theme', 'gp_strategies_setup' );


if ( ! function_exists( 'gp_strategies_content_width' ) ) {
	/**
	 *  Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 *  Priority 0 to make it available to lower priority callbacks.
	 *
	 * @return void
	 * @global int $content_width
	 */
	function gp_strategies_content_width(): void {
		$GLOBALS['content_width'] = apply_filters( 'gp_strategies_content_width', 640 );
	}
}
add_action( 'after_setup_theme', 'gp_strategies_content_width', 0 );


/**
 * Add legacy block category for imported blocks from gpstrategies-2023 theme.
 *
 * This supplements the parent theme's st_add_theme_block_categories() function,
 * keeping the existing 'gp-strategies' category while adding a new 'gpstrategies' legacy category.
 *
 * @param array $categories Current list of categories.
 *
 * @return array
 * @since 1.0.0
 */
function gp_add_legacy_block_category( array $categories ): array {
	$legacy_category = array(
		'slug'  => 'gpstrategies',
		'title' => __( '[Legacy] - GP Strategies Sections', 'gp-strategies' ),
		'icon'  => 'admin-appearance',
	);
	array_unshift( $categories, $legacy_category );

	return $categories;
}
add_filter( 'block_categories_all', 'gp_add_legacy_block_category', 11, 1 );


/**
 * Override ACF options pages registration.
 * Adds Global Blocks sub-page for legacy field groups.
 *
 * @return void
 */
function my_acf_op_init(): void {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	$parent = acf_add_options_page(
		array(
			'page_title' => __( '[Legacy] - Theme General Settings' ),
			'menu_title' => __( 'Theme Settings' ),
			'post_id'    => 'options',
			'redirect'   => false,
		)
	);

	// Add Global Blocks subpage (required for legacy field groups).
	acf_add_options_page(
		array(
			'page_title'  => __( '[Legacy] - Global Blocks' ),
			'menu_title'  => __( 'Global Blocks' ),
			'parent_slug' => $parent['menu_slug'],
			'post_id'     => 'global',
		)
	);
}
add_action( 'acf/init', 'my_acf_op_init' );
