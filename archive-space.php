<?php
/**
 * Spaces archive template
 *
 * @package FellStudio
 */

get_header();

$archive_intro = function_exists('get_field') ? get_field('space_archive_intro', 'option') : '';
?>

<div id="content" class="flex-grow">
    <main id="main" class="py-16 space-y-16">
        <section class="container text-center space-y-4">
            <p class="text-sm uppercase tracking-[0.4em] text-green-700"><?php esc_html_e('Spaces', 'fell-studio'); ?></p>
            <h1 class="text-5xl font-semibold text-green-950"><?php post_type_archive_title(); ?></h1>
            <?php if ($archive_intro) : ?>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto"><?php echo esc_html($archive_intro); ?></p>
            <?php elseif (get_the_archive_description()) : ?>
                <div class="text-gray-600 max-w-3xl mx-auto">
                    <?php echo wp_kses_post(get_the_archive_description()); ?>
                </div>
            <?php endif; ?>
        </section>

        <section class="container">
            <?php if (have_posts()) : ?>
                <div class="grid gap-10 md:grid-cols-2">
                    <?php while (have_posts()) : the_post(); ?>
                        <article <?php post_class('bg-gray-50 rounded-[2.5rem] p-10 space-y-5 ring-1 ring-gray-100'); ?>>
                            <header class="space-y-2">
                                <?php the_title('<h2 class="text-3xl font-semibold text-green-950"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
                                <?php if (function_exists('get_field') && get_field('space_location')) : ?>
                                    <p class="text-sm uppercase tracking-[0.3em] text-green-700">
                                        <?php echo esc_html(get_field('space_location')); ?>
                                    </p>
                                <?php endif; ?>
                            </header>

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="overflow-hidden rounded-3xl">
                                    <?php the_post_thumbnail('large', array('class' => 'w-full h-72 object-cover')); ?>
                                </div>
                            <?php endif; ?>

                            <p class="text-gray-600">
                                <?php echo wp_kses_post(get_the_excerpt()); ?>
                            </p>

                            <a class="inline-flex items-center gap-2 font-medium text-green-900" href="<?php the_permalink(); ?>">
                                <?php esc_html_e('View details', 'fell-studio'); ?>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="max-w-3xl mx-auto mt-12 px-5 md:px-0">
                    <?php the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('Previous', 'fell-studio'),
                        'next_text' => __('Next', 'fell-studio'),
                    )); ?>
                </div>
            <?php else : ?>
                <p class="text-center text-gray-600">
                    <?php esc_html_e('No spaces published yet. Add one from the dashboard.', 'fell-studio'); ?>
                </p>
            <?php endif; ?>
        </section>
    </main>
</div>

<?php
get_footer();

