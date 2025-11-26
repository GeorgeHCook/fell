<?php

/**
 * Vite Integration for WordPress
 *
 * Handles loading Vite assets in development and production modes
 *
 * @package PlantEx
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if Vite dev server is running
 *
 * @return bool
 */
function plant_ex_is_vite_development()
{
    // Check if manifest.json exists - if not, assume dev mode
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';

    // If manifest exists, we're in production mode
    if (file_exists($manifest_path)) {
        return false;
    }

    // Check if Vite dev server is running on port 5173
    $vite_server = @file_get_contents('http://localhost:5173');
    return $vite_server !== false;
}

/**
 * Get the Vite asset URL
 *
 * @param string $entry The entry point file (e.g., 'main.js')
 * @return string|false The asset URL or false if not found
 */
function plant_ex_get_vite_asset($entry)
{
    if (plant_ex_is_vite_development()) {
        // Development mode - return Vite dev server URL
        return 'http://localhost:5173/src/' . $entry;
    }

    // Production mode - read from manifest
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';

    if (!file_exists($manifest_path)) {
        return false;
    }

    $manifest = json_decode(file_get_contents($manifest_path), true);

    if (!isset($manifest['src/' . $entry])) {
        return false;
    }

    $file = $manifest['src/' . $entry]['file'];
    return get_template_directory_uri() . '/dist/' . $file;
}

/**
 * Enqueue Vite assets
 */
function plant_ex_enqueue_vite_assets()
{
    $is_dev = plant_ex_is_vite_development();

    if ($is_dev) {
        // Development mode - Directly output Vite scripts in footer
        add_action('wp_footer', function () {
            ?>
            <script type="module" src="http://localhost:5173/@vite/client"></script>
            <script type="module" src="http://localhost:5173/src/main.js"></script>
            <?php
        }, 1);
    } else {
        // Production mode - Load built assets
        $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';

        if (!file_exists($manifest_path)) {
            return;
        }

        $manifest = json_decode(file_get_contents($manifest_path), true);

        if (isset($manifest['src/main.js'])) {
            $main_js = $manifest['src/main.js'];

            // Enqueue CSS if it exists
            if (isset($main_js['css'])) {
                foreach ($main_js['css'] as $css_file) {
                    wp_enqueue_style(
                        'plant-ex-style',
                        get_template_directory_uri() . '/dist/' . $css_file,
                        array(),
                        null
                    );
                }
            }

            // Enqueue main JS
            wp_enqueue_script(
                'plant-ex-main',
                get_template_directory_uri() . '/dist/' . $main_js['file'],
                array(),
                null,
                true
            );

            // Add module type attribute
            add_filter('script_loader_tag', function ($tag, $handle) {
                if ($handle === 'plant-ex-main') {
                    $tag = str_replace('<script ', '<script type="module" ', $tag);
                }
                return $tag;
            }, 10, 2);
        }
    }
}
