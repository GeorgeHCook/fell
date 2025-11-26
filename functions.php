<?php

/**
 * Fell Studio Theme Functions
 *
 * @package PlantEx
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Load Vite integration
require_once get_template_directory() . '/inc/vite.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function plant_ex_setup()
{
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for responsive embedded content.
    add_theme_support('responsive-embeds');

    // Add support for editor styles.
    add_theme_support('editor-styles');

    // Add support for custom logo.
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'plant_ex_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function plant_ex_content_width()
{
    $GLOBALS['content_width'] = apply_filters('plant_ex_content_width', 640);
}
add_action('after_setup_theme', 'plant_ex_content_width', 0);

/**
 * Register widget areas.
 */
function plant_ex_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'plant-ex'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'plant-ex'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'plant_ex_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function plant_ex_scripts()
{
    // Load Vite assets (development or production)
    plant_ex_enqueue_vite_assets();

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'plant_ex_scripts');

/**
 * Register navigation menus.
 */
function plant_ex_menus()
{
    register_nav_menus(array(
        'menu-1' => esc_html__('Primary', 'plant-ex'),
    ));
}
add_action('init', 'plant_ex_menus');

/**
 * Custom template tags for this theme.
 */
if (!function_exists('plant_ex_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function plant_ex_posted_on()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x('Posted on %s', 'post date', 'plant-ex'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('plant_ex_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function plant_ex_posted_by()
    {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('by %s', 'post author', 'plant-ex'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;
