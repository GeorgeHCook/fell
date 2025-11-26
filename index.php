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

<div id="page" class="min-h-screen flex flex-col">
    <header id="masthead" class="bg-green-800 text-white">
        <div class="container py-4">
            <div class="mb-4">
                <?php
                if (is_front_page() && is_home()) : ?>
                    <h1 class="text-3xl font-bold"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="hover:text-green-200 transition-colors"><?php bloginfo('name'); ?></a></h1>
                <?php else : ?>
                    <p class="text-3xl font-bold"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="hover:text-green-200 transition-colors"><?php bloginfo('name'); ?></a></p>
                <?php endif; ?>
                
                <?php
                $description = get_bloginfo('description', 'display');
if ($description || is_customize_preview()) : ?>
                    <p class="text-base opacity-90 mt-2"><?php echo $description; ?></p>
                <?php endif; ?>
            </div>
            
            <nav id="site-navigation" class="mt-4">
                <?php
wp_nav_menu(array(
    'theme_location' => 'menu-1',
    'menu_id'        => 'primary-menu',
    'fallback_cb'    => false,
    'menu_class'     => 'flex gap-8 list-none',
));
?>
            </nav>
        </div>
    </header>

    <div id="content" class="flex-grow">
        <main id="main" class="py-8">
            <div class="container">
                <?php
if (have_posts()) :
    while (have_posts()) :
        the_post();
        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('mb-8 pb-8 border-b border-gray-200 last:border-b-0'); ?>>
                            <header class="mb-4">
                                <?php
                if (is_singular()) :
                    the_title('<h1 class="text-4xl font-bold text-green-800 mb-2">', '</h1>');
                else :
                    the_title('<h2 class="text-2xl font-bold mb-2"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="text-green-800 hover:text-green-600 transition-colors">', '</a></h2>');
                endif;
        ?>
                                
                                <?php if ('post' === get_post_type()) : ?>
                                    <div class="text-gray-600 text-sm">
                                        <?php plant_ex_posted_on(); ?>
                                    </div>
                                <?php endif; ?>
                            </header>

                            <div class="prose prose-green max-w-none">
                                <?php
        if (is_singular()) :
            the_content();
        else :
            the_excerpt();
        endif;
        ?>
                            </div>
                        </article>
                        <?php
    endwhile;

the_posts_navigation();
else :
    ?>
                    <section class="text-center py-12">
                        <header class="mb-6">
                            <h1 class="text-3xl font-bold text-gray-800"><?php esc_html_e('Nothing here', 'plant-ex'); ?></h1>
                        </header>
                        <div class="text-gray-600">
                            <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for.', 'plant-ex'); ?></p>
                        </div>
                    </section>
                    <?php
endif;
?>
            </div>
        </main>
    </div>

    <footer id="colophon" class="bg-gray-100 py-8 mt-12">
        <div class="container">
            <div class="text-center text-gray-600">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'plant-ex'); ?></p>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
