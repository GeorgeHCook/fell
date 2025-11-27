<?php
/**
 * Main template file
 *
 * @package FellStudio
 */

get_header();
?>

<div id="content" class="flex-grow">
    <main id="main" class="py-8">
        <div class="container">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('mb-8 pb-8 border-b border-gray-200 last:border-b-0'); ?>>
                        <header class="mb-4">
                            <?php if (is_singular()) : ?>
                                <?php the_title('<h1 class="text-4xl font-bold text-green-800 mb-2">', '</h1>'); ?>
                            <?php else : ?>
                                <?php the_title('<h2 class="text-2xl font-bold mb-2"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="text-green-800 hover:text-green-600 transition-colors">', '</a></h2>'); ?>
                            <?php endif; ?>

                            <?php if ('post' === get_post_type()) : ?>
                                <div class="text-gray-600 text-sm">
                                    <?php fell_studio_posted_on(); ?>
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
                <?php endwhile; ?>

                <?php the_posts_navigation(); ?>
            <?php else : ?>
                <section class="text-center py-12">
                    <header class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-800"><?php esc_html_e('Nothing here', 'fell-studio'); ?></h1>
                    </header>
                    <div class="text-gray-600">
                        <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for.', 'fell-studio'); ?></p>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php
get_footer();
