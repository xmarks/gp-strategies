<?php
/**
 * GP Strategies Custom Post Types and Taxonomies
 *
 * @link https://developer.wordpress.org/plugins/post-types/registering-custom-post-types/
 *
 * @package Gp_Strategies
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class GP_Custom_Post_Types
 *
 * Registers all custom post types and taxonomies for GP Strategies theme.
 */
class GP_Custom_Post_Types {

	/**
	 * Initialize the class and register hooks.
	 *
	 * @return void
	 */
	public static function init(): void {
		add_action( 'init', array( __CLASS__, 'register_post_types' ) );
		add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 0 );
		add_action( 'after_switch_theme', array( __CLASS__, 'flush_rewrite_rules' ) );
	}

	/**
	 * Flush rewrite rules on theme activation.
	 *
	 * @return void
	 */
	public static function flush_rewrite_rules(): void {
		self::register_post_types();
		self::register_taxonomies();
		flush_rewrite_rules();
	}

	/**
	 * Register all custom post types.
	 *
	 * @return void
	 */
	public static function register_post_types(): void {
		self::register_solutions_cpt();
		self::register_events_cpt();
		self::register_news_cpt();
		self::register_podcasts_cpt();
		self::register_webinars_cpt();
		self::register_resources_cpt();
		self::register_case_studies_cpt();
		self::register_training_course_cpt();
		self::register_acab_cpt();
	}

	/**
	 * Register all taxonomies.
	 *
	 * @return void
	 */
	public static function register_taxonomies(): void {
		self::register_solutions_taxonomy();
		self::register_events_taxonomy();
		self::register_news_taxonomy();
		self::register_podcasts_taxonomy();
		self::register_resources_taxonomy();
		self::register_case_studies_taxonomy();
		self::register_training_course_taxonomies();
		self::register_acab_taxonomy();
		self::register_industry_taxonomy();
		self::register_topic_taxonomy();
	}

	/**
	 * Register Solutions CPT.
	 *
	 * @return void
	 */
	private static function register_solutions_cpt(): void {
		$labels = array(
			'name'               => 'Solutions',
			'singular_name'      => 'Solution',
			'add_new'            => 'Add Solution',
			'all_items'          => 'All Solutions',
			'add_new_item'       => 'Add Solution',
			'edit_item'          => 'Edit Solution',
			'new_item'           => 'New Solution',
			'view_item'          => 'View Solution',
			'search_items'       => 'Search Solutions',
			'not_found'          => 'No Solutions found',
			'not_found_in_trash' => 'No Solutions found in trash',
			'parent_item_colon'  => 'Parent Solution',
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'solutions' ),
			'capability_type'     => 'page',
			'hierarchical'        => true,
			'show_in_rest'        => true,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-lightbulb',
			'exclude_from_search' => false,
		);

		register_post_type( 'solutions-cpt', $args );
	}

	/**
	 * Register Events CPT.
	 *
	 * @return void
	 */
	private static function register_events_cpt(): void {
		$labels = array(
			'name'               => 'Events',
			'singular_name'      => 'Event',
			'add_new'            => 'Add Event',
			'all_items'          => 'All Events',
			'add_new_item'       => 'Add Event',
			'edit_item'          => 'Edit Event',
			'new_item'           => 'New Event',
			'view_item'          => 'View Event',
			'search_items'       => 'Search Events',
			'not_found'          => 'No Events found',
			'not_found_in_trash' => 'No Events found in trash',
			'parent_item_colon'  => 'Parent Event',
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'events' ),
			'capability_type'     => 'page',
			'hierarchical'        => true,
			'show_in_rest'        => true,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-calendar-alt',
			'exclude_from_search' => false,
		);

		register_post_type( 'events-cpt', $args );
	}

	/**
	 * Register News CPT.
	 *
	 * @return void
	 */
	private static function register_news_cpt(): void {
		$labels = array(
			'name'               => 'News',
			'singular_name'      => 'News',
			'add_new'            => 'Add News',
			'all_items'          => 'All News',
			'add_new_item'       => 'Add News',
			'edit_item'          => 'Edit News',
			'new_item'           => 'New News',
			'view_item'          => 'View News',
			'search_items'       => 'Search News',
			'not_found'          => 'No News found',
			'not_found_in_trash' => 'No News found in trash',
			'parent_item_colon'  => 'Parent News',
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'news' ),
			'capability_type'     => 'page',
			'hierarchical'        => true,
			'show_in_rest'        => true,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-media-document',
			'exclude_from_search' => false,
		);

		register_post_type( 'news-cpt', $args );
	}

	/**
	 * Register Podcasts CPT.
	 *
	 * @return void
	 */
	private static function register_podcasts_cpt(): void {
		$labels = array(
			'name'               => 'Podcasts',
			'singular_name'      => 'Podcast',
			'add_new'            => 'Add Podcast',
			'all_items'          => 'All Podcasts',
			'add_new_item'       => 'Add Podcast',
			'edit_item'          => 'Edit Podcast',
			'new_item'           => 'New Podcast',
			'view_item'          => 'View Podcast',
			'search_items'       => 'Search Podcasts',
			'not_found'          => 'No Podcasts found',
			'not_found_in_trash' => 'No Podcasts found in trash',
			'parent_item_colon'  => 'Parent Podcast',
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => true,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'show_in_rest'        => true,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-microphone',
			'exclude_from_search' => false,
		);

		register_post_type( 'podcasts-cpt', $args );
	}

	/**
	 * Register Webinars CPT.
	 *
	 * @return void
	 */
	private static function register_webinars_cpt(): void {
		$labels = array(
			'name'               => 'Webinars',
			'singular_name'      => 'Webinar',
			'add_new'            => 'Add Webinar',
			'all_items'          => 'All Webinars',
			'add_new_item'       => 'Add Webinar',
			'edit_item'          => 'Edit Webinar',
			'new_item'           => 'New Webinar',
			'view_item'          => 'View Webinar',
			'search_items'       => 'Search Webinars',
			'not_found'          => 'No Webinars found',
			'not_found_in_trash' => 'No Webinars found in trash',
			'parent_item_colon'  => 'Parent Webinar',
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'webinars' ),
			'capability_type'     => 'page',
			'hierarchical'        => true,
			'show_in_rest'        => true,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-embed-video',
			'exclude_from_search' => false,
		);

		register_post_type( 'webinars-cpt', $args );
	}

	/**
	 * Register Resources CPT.
	 *
	 * @return void
	 */
	private static function register_resources_cpt(): void {
		$labels = array(
			'name'               => 'Resources',
			'singular_name'      => 'Resource',
			'add_new'            => 'Add Resource',
			'all_items'          => 'All Resources',
			'add_new_item'       => 'Add Resource',
			'edit_item'          => 'Edit Resource',
			'new_item'           => 'New Resource',
			'view_item'          => 'View Resource',
			'search_items'       => 'Search Resources',
			'not_found'          => 'No Resources found',
			'not_found_in_trash' => 'No Resources found in trash',
			'parent_item_colon'  => 'Parent Resource',
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'resources' ),
			'capability_type'     => 'page',
			'hierarchical'        => true,
			'show_in_rest'        => true,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-networking',
			'exclude_from_search' => false,
		);

		register_post_type( 'resource', $args );
	}

	/**
	 * Register Case Studies CPT.
	 *
	 * @return void
	 */
	private static function register_case_studies_cpt(): void {
		$labels = array(
			'name'               => 'Our Work',
			'singular_name'      => 'Case Study',
			'add_new'            => 'Add Case Study',
			'all_items'          => 'All Case Studies',
			'add_new_item'       => 'Add Case Study',
			'edit_item'          => 'Edit Case Study',
			'new_item'           => 'New Case Study',
			'view_item'          => 'View Case Study',
			'search_items'       => 'Search Case Studies',
			'not_found'          => 'No Case Studies found',
			'not_found_in_trash' => 'No Case Studies found in trash',
			'parent_item_colon'  => 'Parent Case Study',
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'rewrite'             => array(
				'slug'       => 'our-work',
				'with_front' => false,
			),
			'capability_type'     => 'page',
			'hierarchical'        => true,
			'show_in_rest'        => true,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-portfolio',
			'exclude_from_search' => false,
		);

		register_post_type( 'case-study-cpt', $args );
	}

	/**
	 * Register Training Course CPT.
	 *
	 * @return void
	 */
	private static function register_training_course_cpt(): void {
		$labels = array(
			'name'               => 'Courses',
			'singular_name'      => 'Course',
			'add_new'            => 'Add Course',
			'all_items'          => 'All Courses',
			'add_new_item'       => 'Add Course',
			'edit_item'          => 'Edit Course',
			'new_item'           => 'New Course',
			'view_item'          => 'View Course',
			'search_items'       => 'Search Courses',
			'not_found'          => 'No Courses found',
			'not_found_in_trash' => 'No Courses found in trash',
			'parent_item_colon'  => 'Parent Course',
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'training-courses' ),
			'capability_type'     => 'page',
			'hierarchical'        => true,
			'show_in_rest'        => true,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-money',
			'exclude_from_search' => false,
		);

		register_post_type( 'training-course', $args );
	}

	/**
	 * Register ACAB (Leadership) CPT.
	 *
	 * @return void
	 */
	private static function register_acab_cpt(): void {
		$labels = array(
			'name'               => 'Leadership',
			'singular_name'      => 'Leadership',
			'add_new'            => 'Add new',
			'all_items'          => 'All Leadership',
			'add_new_item'       => 'Add Leadership',
			'edit_item'          => 'Edit Leadership',
			'new_item'           => 'New Leadership',
			'view_item'          => 'View Leadership',
			'search_items'       => 'Search Leadership',
			'not_found'          => 'No Leadership found',
			'not_found_in_trash' => 'No Leadership found in trash',
			'parent_item_colon'  => 'Parent Leadership',
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'rewrite'             => array(
				'slug'       => 'customer-advisory-board',
				'with_front' => false,
			),
			'capability_type'     => 'page',
			'hierarchical'        => true,
			'show_in_rest'        => true,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-admin-users',
			'exclude_from_search' => false,
		);

		register_post_type( 'acab-cpt', $args );
	}

	/**
	 * Register Solutions taxonomy.
	 *
	 * @return void
	 */
	private static function register_solutions_taxonomy(): void {
		$labels = array(
			'name'              => 'Solutions Category',
			'singular_name'     => 'Solutions Category',
			'show_admin_column' => true,
		);

		register_taxonomy(
			'solutions-category',
			'solutions-cpt',
			array(
				'hierarchical'      => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'labels'            => $labels,
			)
		);
	}

	/**
	 * Register Events taxonomy.
	 *
	 * @return void
	 */
	private static function register_events_taxonomy(): void {
		$labels = array(
			'name'              => 'Event type',
			'singular_name'     => 'Event type',
			'show_admin_column' => true,
		);

		register_taxonomy(
			'event-type',
			'events-cpt',
			array(
				'hierarchical'      => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'labels'            => $labels,
			)
		);
	}

	/**
	 * Register News taxonomy.
	 *
	 * @return void
	 */
	private static function register_news_taxonomy(): void {
		$labels = array(
			'name'              => 'News Category',
			'singular_name'     => 'News Category',
			'show_admin_column' => true,
		);

		register_taxonomy(
			'news-category',
			'news-cpt',
			array(
				'hierarchical'      => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'labels'            => $labels,
			)
		);
	}

	/**
	 * Register Podcasts taxonomy.
	 *
	 * @return void
	 */
	private static function register_podcasts_taxonomy(): void {
		$labels = array(
			'name'              => 'Podcasts Host',
			'singular_name'     => 'Podcasts Host',
			'show_admin_column' => true,
		);

		register_taxonomy(
			'podcasts-host',
			'podcasts-cpt',
			array(
				'hierarchical'      => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'labels'            => $labels,
			)
		);
	}

	/**
	 * Register Resources taxonomy.
	 *
	 * @return void
	 */
	private static function register_resources_taxonomy(): void {
		$labels = array(
			'name'              => 'Resource type',
			'singular_name'     => 'Resource type',
			'show_admin_column' => true,
		);

		register_taxonomy(
			'resource-type',
			'resource',
			array(
				'hierarchical'      => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'labels'            => $labels,
			)
		);
	}

	/**
	 * Register Case Studies taxonomy.
	 *
	 * @return void
	 */
	private static function register_case_studies_taxonomy(): void {
		$labels = array(
			'name'              => 'Category',
			'singular_name'     => 'Case Studies Category',
			'show_admin_column' => true,
			'add_new_item'      => 'Add New Case Studies Category',
		);

		register_taxonomy(
			'case-study-category',
			'case-study-cpt',
			array(
				'hierarchical'      => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'labels'            => $labels,
			)
		);
	}

	/**
	 * Register Training Course taxonomies.
	 *
	 * @return void
	 */
	private static function register_training_course_taxonomies(): void {
		$taxonomies = array( 'modality', 'leadership-level', 'course-type' );

		foreach ( $taxonomies as $taxonomy ) {
			$label = ucfirst( str_replace( '-', ' ', $taxonomy ) );

			register_taxonomy(
				$taxonomy,
				'training-course',
				array(
					'hierarchical'      => true,
					'show_admin_column' => true,
					'show_in_rest'      => true,
					'labels'            => array(
						'name'              => $label,
						'singular_name'     => $label,
						'show_admin_column' => true,
					),
				)
			);
		}
	}

	/**
	 * Register ACAB taxonomy.
	 *
	 * @return void
	 */
	private static function register_acab_taxonomy(): void {
		$labels = array(
			'name'              => 'Leadership category',
			'singular_name'     => 'Leadership category',
			'show_admin_column' => true,
			'add_new_item'      => 'Add New Leadership category',
		);

		register_taxonomy(
			'acab-leadership-category',
			'acab-cpt',
			array(
				'hierarchical'      => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'labels'            => $labels,
			)
		);
	}

	/**
	 * Register Industry taxonomy (global).
	 *
	 * @return void
	 */
	private static function register_industry_taxonomy(): void {
		$labels = array(
			'name'              => _x( 'Industry', 'taxonomy general name', 'gp-strategies' ),
			'singular_name'     => _x( 'Industry', 'taxonomy singular name', 'gp-strategies' ),
			'search_items'      => __( 'Search Industries', 'gp-strategies' ),
			'all_items'         => __( 'All Industries', 'gp-strategies' ),
			'parent_item'       => __( 'Parent Industry', 'gp-strategies' ),
			'parent_item_colon' => __( 'Parent Industry:', 'gp-strategies' ),
			'edit_item'         => __( 'Edit Industry', 'gp-strategies' ),
			'update_item'       => __( 'Update Industry', 'gp-strategies' ),
			'add_new_item'      => __( 'Add New Industry', 'gp-strategies' ),
			'new_item_name'     => __( 'New Industry Name', 'gp-strategies' ),
			'menu_name'         => __( 'Industries', 'gp-strategies' ),
		);

		$post_types = array(
			'post',
			'resource',
			'podcasts-cpt',
			'events-cpt',
			'solutions-cpt',
			'news-cpt',
			'case-study-cpt',
			'webinars-cpt',
		);

		register_taxonomy(
			'industry',
			$post_types,
			array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array(
					'slug'       => 'industry',
					'with_front' => false,
				),
			)
		);
	}

	/**
	 * Register Topic taxonomy (global).
	 *
	 * @return void
	 */
	private static function register_topic_taxonomy(): void {
		$labels = array(
			'name'              => _x( 'Topic', 'taxonomy general name', 'gp-strategies' ),
			'singular_name'     => _x( 'Topic', 'taxonomy singular name', 'gp-strategies' ),
			'search_items'      => __( 'Search topics', 'gp-strategies' ),
			'all_items'         => __( 'All Topics', 'gp-strategies' ),
			'parent_item'       => __( 'Parent Topic', 'gp-strategies' ),
			'parent_item_colon' => __( 'Parent Topic:', 'gp-strategies' ),
			'edit_item'         => __( 'Edit Topic', 'gp-strategies' ),
			'update_item'       => __( 'Update Topic', 'gp-strategies' ),
			'add_new_item'      => __( 'Add New Topic', 'gp-strategies' ),
			'new_item_name'     => __( 'New Topic Name', 'gp-strategies' ),
			'menu_name'         => __( 'Topic', 'gp-strategies' ),
		);

		$post_types = array(
			'post',
			'resource',
			'training-course',
			'podcasts-cpt',
			'events-cpt',
			'webinars-cpt',
		);

		register_taxonomy(
			'topic',
			$post_types,
			array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array(
					'slug'       => 'topic',
					'with_front' => false,
				),
			)
		);
	}
}

// Initialize Custom Post Types.
GP_Custom_Post_Types::init();