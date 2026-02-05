<?php

/**
 * Functions which enable support for legacy pages / layouts from old theme
 *
 * @package Gp_Strategies
 */

/**
 * Legacy-enabled post types.
 * Add post types here as legacy support is extended.
 */
define( 'GP_LEGACY_POST_TYPES', array( 'case-study-cpt' ) );

/**
 * Check if a post has legacy mode enabled.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 * @return bool True if legacy mode is enabled.
 */
function gp_is_legacy_enabled( ?int $post_id = null ): bool
{
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    if ( ! $post_id ) {
        return false;
    }

    $post_type = get_post_type( $post_id );

    if ( ! in_array( $post_type, GP_LEGACY_POST_TYPES, true ) ) {
        return false;
    }

    $is_legacy = get_field( 'gp-cpt-is_legacy', $post_id );

    // ACF default only applies to new posts created via UI.
    // Existing posts without a saved value return null.
    // Default to true (legacy enabled) for backwards compatibility.
    if ( null === $is_legacy ) {
        return true;
    }

    return (bool)$is_legacy;
}

/**
 * Register legacy front-end styles.
 * Styles are registered but not enqueued - templates enqueue as needed.
 *
 * Usage in templates:
 *   wp_enqueue_style( 'legacy.main' );
 *
 * @return void
 */
function gp_register_legacy_styles(): void
{
    $css_file = '/assets/css/legacy/main.min.css';
    $css_path = get_template_directory() . $css_file;

    if ( file_exists( $css_path ) ) {
        wp_register_style(
            'legacy.main',
            get_template_directory_uri() . $css_file,
            array(),
            filemtime( $css_path )
        );
    }
}

add_action( 'wp_enqueue_scripts', 'gp_register_legacy_styles' );

/**
 * Add 'is-legacy' class to body tag for legacy-enabled posts.
 *
 * @param array $classes Existing body classes.
 * @return array Modified body classes.
 */
function gp_legacy_body_class( array $classes ): array
{
    if ( gp_is_legacy_enabled() ) {
        $classes[] = 'is-legacy';
    }

    return $classes;
}

add_filter( 'body_class', 'gp_legacy_body_class' );

/**
 * Enqueue legacy admin styles in the block editor.
 * Only loads when editing a legacy-enabled post.
 *
 * @return void
 */
function gp_enqueue_legacy_admin_styles(): void
{
    $screen = get_current_screen();

    if ( ! $screen || 'post' !== $screen->base ) {
        return;
    }

    if ( ! in_array( $screen->post_type, GP_LEGACY_POST_TYPES, true ) ) {
        return;
    }

    $post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;

    // For new posts (no ID), load by default since ACF default is enabled.
    // For existing posts, check the field value.
    if ( ! $post_id || gp_is_legacy_enabled( $post_id ) ) {
        $css_file = '/assets/css/legacy/admin.min.css';
        $css_path = get_template_directory() . $css_file;

        if ( file_exists( $css_path ) ) {
            wp_enqueue_style(
                'legacy.admin',
                get_template_directory_uri() . $css_file,
                array(),
                filemtime( $css_path )
            );
        }
    }
}

add_action( 'enqueue_block_editor_assets', 'gp_enqueue_legacy_admin_styles' );


function create_slug( $string )
{
    $string   = strip_tags( $string );
    $headerId = strtolower( preg_replace( array( '/\s+/', '/[^\w-]+/' ), array( '-', '' ), $string ) );

    return $headerId;
}

function generate_table_of_contents( $id )
{
    $content = get_post( $id )->post_content;
    preg_match_all( '/<h([1-6])>(.*?)<\/h\1>/', $content, $matches, PREG_SET_ORDER ); // Pre-WP syntax update matching (mostly old, unedited case studies).
    if ( ! $matches ) {
        preg_match_all( '/<h([1-6]) class="wp-block-heading">(.*?)<\/h\1>/', $content, $matches, PREG_SET_ORDER ); // Post-WP syntax update (should cover new, recently edited case studies).
    }

    $table_of_contents = '';

    if ( $matches ) {
        $table_of_contents .= '<div class="table-of-contents">';
    }

    $last_level = 1;

    foreach ($matches as $match) {
        $level  = intval( $match[1] );
        $header = $match[2];

        $slug_id = create_slug( $header );

        if ( $level > $last_level ) {
            for ($i = $last_level; $i < $level; $i++) {
                $table_of_contents .= '<ul class="table-of-contents__list list_level_' . $i . '">';
            }
        } elseif ( $level < $last_level ) {
            for ($i = $level; $i < $last_level; $i++) {
                $table_of_contents .= '</ul>';
            }
        }

        $table_of_contents .= '<li><a href="#' . $slug_id . '">' . strip_tags( $header ) . '</a></li>';
        $last_level        = $level;
    }
    for ($i = $last_level; $i > 1; $i--) {
        $table_of_contents .= '</ul>';
    }
    if ( $matches ) {
        $table_of_contents .= '</div>';
    }
    return $table_of_contents;
}

/**
 * WordPress Breadcrumbs
 */
function gp_breadcrumbs()
{

    $separator = '<svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 4L0 8L0 0L6 4Z" fill="currentColor"/></svg>';

    $breadcrumbs_class = 'gp-breadcrumbs';
    $home_title        = esc_html__( 'Home', 'gpstrategies-2023' );

    // Add here you custom post taxonomies
    $gp_custom_taxonomy = 'sample_put_here';

    global $post, $wp_query;

    // Hide from front page
    if ( ! is_front_page() ) {

        echo '<ul class="' . $breadcrumbs_class . '">';

        // Home
        echo '<li class="item-home"><a class="bread-link not-color bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';

        if ( is_archive() && ! is_tax() && ! is_category() && ! is_tag() ) {

            echo '<li class="item-current item-archive"><span class="bread-current bread-archive">' . post_type_archive_title( '', false ) . '</span></li>';

        } else if ( is_archive() && is_tax() && ! is_category() && ! is_tag() ) {

            // For Custom post type
            if ( isset( $_GET['post-type'] ) ) {
                $post_type = $_GET['post-type'];
            } else {
                $post_type = get_post_type();
            }

            // Custom post type name and link
            $post_type_object  = get_post_type_object( $post_type );
            $post_type_archive = get_post_type_archive_link( $post_type );
            if ( $post_type != 'post' ) {


                if ( $post_type_object->has_archive ) {
                    $archive_url = get_post_type_archive_link( $post_type );
                } else {
                    $archive_url = home_url( $post_type_object->rewrite['slug'] );
                }


                if ( $post_type_object ) {
                    echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat not-color bread-custom-post-type-' . $post_type . '" href="' . $archive_url . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                    echo '<li class="separator"> ' . $separator . ' </li>';
                }


            } else {
                echo '<li class="item-cat item-custom-post-type-post"><a class="bread-cat not-color bread-custom-post-type-' . $post_type . '" href="/blog" title="Blog">Blog</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><span class="bread-current bread-archive">' . $custom_tax_name . '</span></li>';

        } else if ( is_single() ) {

            $post_type = get_post_type();


            if ( $post_type != 'post' ) {

                $post_type_object = get_post_type_object( $post_type );

                if ( $post_type == 'solutions-cpt' ) {

                    $parents = array_reverse( get_post_ancestors( $post->ID ) );

                    if ( $parents ) {
                        foreach ($parents as $parent_id) {
                            $parent_title     = get_the_title( $parent_id );
                            $parent_permalink = get_permalink( $parent_id );
                            echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat not-color bread-custom-post-type-' . $post_type . '" href="' . $parent_permalink . '" title="' . $parent_title . '">' . $parent_title . '</a></li>';
                            echo '<li class="separator"> ' . $separator . ' </li>';
                        }
                    }
                } else {
                    if ( $post_type_object->has_archive ) {
                        $archive_url = get_post_type_archive_link( $post_type );
                    } else {
                        $archive_url = home_url( $post_type_object->rewrite['slug'] );
                    }

                    echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat not-color bread-custom-post-type-' . $post_type . '" href="' . $archive_url . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                    echo '<li class="separator"> ' . $separator . ' </li>';
                }

            } else {

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat not-color bread-custom-post-type-' . $post_type . '" href="' . home_url( 'blog' ) . '" title="blog">Blog</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            // Get post category
            // $category = get_the_category();

            if ( ! empty( $category ) ) {

                // Last category post is in
                $last_category = $category[count( $category ) - 1];

                // Parent any categories and create array
                $get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
                $cat_parents     = explode( ',', $get_cat_parents );

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach ($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">' . $parents . '</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }

            }

            $taxonomy_exists = taxonomy_exists( $gp_custom_taxonomy );
            if ( empty( $last_category ) && ! empty( $gp_custom_taxonomy ) && $taxonomy_exists ) {

                $taxonomy_terms = get_the_terms( $post->ID, $gp_custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link( $taxonomy_terms[0]->term_id, $gp_custom_taxonomy );
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // If the post is in a category
            if ( ! empty( $last_category ) ) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';

                // Post is in a custom taxonomy
            } else if ( ! empty( $cat_id ) ) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat not-color bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';

            }

        } else if ( is_category() ) {
            echo '<li class="item-cat item-custom-post-type-post"><a class="bread-cat not-color bread-custom-post-type-post" href="' . home_url( 'blog' ) . '" title="blog">Blog</a></li>';
            echo '<li class="separator"> ' . $separator . ' </li>';
            // Category page
            echo '<li class="item-current item-cat"><span class="bread-current bread-cat">' . single_cat_title( '', false ) . '</span></li>';

        } else if ( is_page() ) {

            // Standard page
            if ( $post->post_parent ) {

                // Get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents order
                $anc = array_reverse( $anc );

                // Parent pages
                if ( ! isset( $parents ) )
                    $parents = null;
                foreach ($anc as $ancestor) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent not-color bread-parent-' . $ancestor . '" href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }

                // Render parent pages
                echo $parents;

                // Active page
                echo '<li class="item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';

            } else {

                // Just display active page if not parents pages
                echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</span></li>';

            }

        } else if ( is_tag() ) { // Tag page

            // Tag information
            $term_id       = get_query_var( 'tag_id' );
            $taxonomy      = 'post_tag';
            $args          = 'include=' . $term_id;
            $terms         = get_terms( $taxonomy, $args );
            $get_term_id   = $terms[0]->term_id;
            $get_term_slug = $terms[0]->slug;
            $get_term_name = $terms[0]->name;

            // Return tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><span class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</span></li>';

        } elseif ( is_day() ) { // Day archive page

            // Year link
            echo '<li class="item-year item-year-' . get_the_time( 'Y' ) . '"><a class="bread-year not-color bread-year-' . get_the_time( 'Y' ) . '" href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( 'Y' ) . '">' . get_the_time( 'Y' ) . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time( 'Y' ) . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time( 'm' ) . '"><a class="bread-month not-color bread-month-' . get_the_time( 'm' ) . '" href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '" title="' . get_the_time( 'M' ) . '">' . get_the_time( 'M' ) . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time( 'm' ) . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time( 'j' ) . '"><span class="bread-current bread-' . get_the_time( 'j' ) . '"> ' . get_the_time( 'jS' ) . ' ' . get_the_time( 'M' ) . ' Archives</span></li>';

        } else if ( is_month() ) { // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time( 'Y' ) . '"><a class="bread-year not-color bread-year-' . get_the_time( 'Y' ) . '" href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( 'Y' ) . '">' . get_the_time( 'Y' ) . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time( 'Y' ) . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time( 'm' ) . '"><span class="bread-month bread-month-' . get_the_time( 'm' ) . '" title="' . get_the_time( 'M' ) . '">' . get_the_time( 'M' ) . ' Archives</span></li>';

        } else if ( is_year() ) { // Display year archive

            echo '<li class="item-current item-current-' . get_the_time( 'Y' ) . '"><span class="bread-current bread-current-' . get_the_time( 'Y' ) . '" title="' . get_the_time( 'Y' ) . '">' . get_the_time( 'Y' ) . ' Archives</span></li>';

        } else if ( is_author() ) { // Author archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><span class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</span></li>';

        } else if ( get_query_var( 'paged' ) ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var( 'paged' ) . '"><span class="bread-current bread-current-' . get_query_var( 'paged' ) . '" title="Page ' . get_query_var( 'paged' ) . '">' . __( 'Page' ) . ' ' . get_query_var( 'paged' ) . '</span></li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><span class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</span></li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

        echo '</ul>';
    }
}

function legacy_sprite_svg( $spriteName, $svgWidth = '24', $svgHeight = '24' ) {
    $svg      = get_stylesheet_directory_uri() . '/assets/images/legacy/icons2.svg#' . $spriteName;
    $elWidth  = '';
    $elHeight = '';
    if ( isset( $svgWidth ) ) {
        $elWidth = 'width="' . $svgWidth . '"';
    }
    if ( isset( $svgHeight ) ) {
        $elHeight = 'height="' . $svgHeight . '"';
    }

    echo '<svg crossorigin="" class="svg-icon" '.$elWidth.' '.$elHeight.'><use xlink:href="' . $svg . '"></use></svg>'; // phpcs:ignore
}

// Plugin ACF Svg icon field
add_filter( 'acf/fields/svg_icon/file_path', 'tc_acf_svg_icon_file_path' );
function tc_acf_svg_icon_file_path( $file_path ) {
    return get_theme_file_path( '/assets/images/legacy/icons2.svg' );
}
