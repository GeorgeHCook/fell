<?php
/**
 * Custom content registration (CPTs + programmatic pages)
 *
 * @package FellStudio
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Fell Studio custom post types.
 *
 * @return void
 */
function fell_studio_register_post_types()
{
    $supports = array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields');

    register_post_type('object', array(
        'labels' => array(
            'name'               => esc_html__('Objects', 'fell-studio'),
            'singular_name'      => esc_html__('Object', 'fell-studio'),
            'add_new'            => esc_html__('Add New Object', 'fell-studio'),
            'add_new_item'       => esc_html__('Add New Object', 'fell-studio'),
            'edit_item'          => esc_html__('Edit Object', 'fell-studio'),
            'new_item'           => esc_html__('New Object', 'fell-studio'),
            'view_item'          => esc_html__('View Object', 'fell-studio'),
            'search_items'       => esc_html__('Search Objects', 'fell-studio'),
            'not_found'          => esc_html__('No objects found', 'fell-studio'),
            'not_found_in_trash' => esc_html__('No objects found in Trash', 'fell-studio'),
            'all_items'          => esc_html__('All Objects', 'fell-studio'),
        ),
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => array('slug' => 'objects'),
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-art',
        'show_in_rest'        => true,
        'supports'            => $supports,
        'show_in_nav_menus'   => true,
        'publicly_queryable'  => true,
    ));

    register_post_type('space', array(
        'labels' => array(
            'name'               => esc_html__('Spaces', 'fell-studio'),
            'singular_name'      => esc_html__('Space', 'fell-studio'),
            'add_new'            => esc_html__('Add New Space', 'fell-studio'),
            'add_new_item'       => esc_html__('Add New Space', 'fell-studio'),
            'edit_item'          => esc_html__('Edit Space', 'fell-studio'),
            'new_item'           => esc_html__('New Space', 'fell-studio'),
            'view_item'          => esc_html__('View Space', 'fell-studio'),
            'search_items'       => esc_html__('Search Spaces', 'fell-studio'),
            'not_found'          => esc_html__('No spaces found', 'fell-studio'),
            'not_found_in_trash' => esc_html__('No spaces found in Trash', 'fell-studio'),
            'all_items'          => esc_html__('All Spaces', 'fell-studio'),
        ),
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => array('slug' => 'spaces'),
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-building',
        'show_in_rest'        => true,
        'supports'            => $supports,
        'show_in_nav_menus'   => true,
        'publicly_queryable'  => true,
    ));
}
add_action('init', 'fell_studio_register_post_types');

/**
 * Ensure the theme's key pages exist.
 *
 * @param bool $force Run even if the seeding flag is set.
 * @return void
 */
function fell_studio_seed_core_pages($force = false)
{
    $already_seeded = (bool) get_option('fell_studio_seeded_pages');
    if (!$force && $already_seeded) {
        return;
    }

    $pages = array(
        'home' => array(
            'title'    => esc_html__('Home', 'fell-studio'),
            'slug'     => 'home',
            'content'  => '',
            'template' => '',
        ),
        'about' => array(
            'title'    => esc_html__('About', 'fell-studio'),
            'slug'     => 'about',
            'content'  => '',
            'template' => 'page-about.php',
        ),
        'contact' => array(
            'title'    => esc_html__('Contact', 'fell-studio'),
            'slug'     => 'contact',
            'content'  => '',
            'template' => 'page-contact.php',
        ),
    );

    $page_ids = array();
    foreach ($pages as $key => $page_args) {
        $page_ids[$key] = fell_studio_ensure_page($page_args);
    }

    if (!empty($page_ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $page_ids['home']);
    }

    if (!$already_seeded) {
        update_option('fell_studio_seeded_pages', time());
    }
}
add_action('init', 'fell_studio_seed_core_pages');

/**
 * Run activation helpers when the theme is switched on.
 *
 * @return void
 */
function fell_studio_after_switch_theme()
{
    fell_studio_register_post_types();
    fell_studio_seed_core_pages(true);
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'fell_studio_after_switch_theme');

/**
 * Create a page if it doesn't already exist.
 *
 * @param array $args Page arguments.
 * @return int|false
 */
function fell_studio_ensure_page($args)
{
    $defaults = array(
        'title'    => '',
        'slug'     => '',
        'content'  => '',
        'status'   => 'publish',
        'template' => '',
    );
    $args = wp_parse_args($args, $defaults);

    if (empty($args['title']) || empty($args['slug'])) {
        return false;
    }

    $existing = fell_studio_locate_page($args['slug']);
    if ($existing instanceof WP_Post) {
        if ('trash' === $existing->post_status) {
            $existing->post_status = 'publish';
            wp_update_post($existing);
        }

        if (!empty($args['template'])) {
            update_post_meta($existing->ID, '_wp_page_template', $args['template']);
        }

        return (int) $existing->ID;
    }

    $postarr = array(
        'post_title'   => $args['title'],
        'post_name'    => $args['slug'],
        'post_content' => $args['content'],
        'post_status'  => $args['status'],
        'post_type'    => 'page',
    );

    $page_id = wp_insert_post(wp_slash($postarr), true);
    if (is_wp_error($page_id)) {
        return false;
    }

    if (!empty($args['template'])) {
        update_post_meta($page_id, '_wp_page_template', $args['template']);
    }

    return (int) $page_id;
}

/**
 * Locate an existing page by slug across any post status.
 *
 * @param string $slug Page slug.
 * @return WP_Post|null
 */
function fell_studio_locate_page($slug)
{
    $page = get_page_by_path($slug);
    if ($page instanceof WP_Post) {
        return $page;
    }

    $pages = get_posts(array(
        'name'             => $slug,
        'post_type'        => 'page',
        'post_status'      => array('publish', 'draft', 'pending', 'future', 'private', 'trash'),
        'numberposts'      => 1,
        'suppress_filters' => true,
    ));

    return !empty($pages) ? $pages[0] : null;
}

