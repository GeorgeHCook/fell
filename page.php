<?php
/**
 * Default page template
 *
 * @package FellStudio
 */

get_header();
?>

<div id="content" class="flex-grow">
    <main id="main" class="py-16">
        <div class="container max-w-4xl">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('space-y-8'); ?>>
                    <header>
                        <?php the_title('<h1 class="text-5xl font-semibold text-green-900 mb-4">', '</h1>'); ?>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="overflow-hidden rounded-3xl shadow-lg">
                                <?php the_post_thumbnail('full', array('class' => 'w-full h-auto object-cover')); ?>
                            </div>
                        <?php endif; ?>
                    </header>

                    <div class="prose prose-lg max-w-none text-gray-800 space-y-6">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </main>
</div>

<?php
get_footer();

