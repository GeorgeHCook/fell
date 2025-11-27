<?php
/**
 * Theme header
 *
 * @package FellStudio
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main">
    <?php esc_html_e('Skip to content', 'fell-studio'); ?>
</a>

<div id="page" class="min-h-screen flex flex-col">
    <header id="masthead" class="bg-green-800 text-white">
        <div class="container py-4">
            <div class="mb-4">
                <?php if (is_front_page() && is_home()) : ?>
                    <h1 class="text-3xl font-bold">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="hover:text-green-200 transition-colors">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php else : ?>
                    <p class="text-3xl font-bold">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="hover:text-green-200 transition-colors">
                            <?php bloginfo('name'); ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php
                $description = get_bloginfo('description', 'display');
                if ($description || is_customize_preview()) :
                    ?>
                    <p class="text-base opacity-90 mt-2">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>

            <nav id="site-navigation" class="mt-4">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'menu-1',
                    'menu_id'        => 'primary-menu',
                    'fallback_cb'    => false,
                    'menu_class'     => 'flex flex-wrap gap-6 list-none text-lg',
                ));
                ?>
            </nav>
        </div>
    </header>

