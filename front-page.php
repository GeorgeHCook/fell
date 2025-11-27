<?php
/**
 * Front page template
 *
 * @package FellStudio
 */

get_header();

if (have_posts()) {
    the_post();
}

$hero_title = function_exists('get_field') ? get_field('hero_title') : get_the_title();
$hero_subtitle = function_exists('get_field') ? get_field('hero_subtitle') : get_bloginfo('description');
$hero_cta_label = function_exists('get_field') ? get_field('hero_cta_label') : __('View Objects', 'fell-studio');
$hero_cta_url = function_exists('get_field') ? get_field('hero_cta_link') : get_post_type_archive_link('object');
?>

<div id="content" class="flex-grow">
    <main id="main">
        <section class="bg-gray-50 py-24">
            <div class="container grid gap-12 lg:grid-cols-2 items-center">
                <div class="space-y-8">
                    <p class="tracking-[0.5em] uppercase text-sm text-green-800">
                        <?php esc_html_e('Fell Studio', 'fell-studio'); ?>
                    </p>
                    <h1 class="text-4xl lg:text-6xl font-semibold text-green-950 leading-tight">
                        <?php echo esc_html($hero_title ?: get_bloginfo('name')); ?>
                    </h1>
                    <?php if ($hero_subtitle) : ?>
                        <p class="text-xl text-gray-700 max-w-xl">
                            <?php echo esc_html($hero_subtitle); ?>
                        </p>
                    <?php endif; ?>
                    <div class="flex flex-wrap gap-4">
                        <?php if ($hero_cta_url) : ?>
                            <a href="<?php echo esc_url($hero_cta_url); ?>" class="inline-flex items-center gap-2 rounded-full bg-green-800 px-6 py-3 text-white text-sm uppercase tracking-wide">
                                <?php echo esc_html($hero_cta_label); ?>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(get_post_type_archive_link('space')); ?>" class="inline-flex items-center gap-2 text-sm uppercase tracking-wide text-green-900">
                            <?php esc_html_e('Explore Spaces', 'fell-studio'); ?>
                        </a>
                    </div>
                </div>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="overflow-hidden rounded-[2.5rem] shadow-2xl ring-1 ring-green-100">
                        <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover')); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="py-20 border-t border-b border-gray-200 bg-white">
            <div class="container space-y-10">
                <header class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-green-700"><?php esc_html_e('Featured Objects', 'fell-studio'); ?></p>
                        <h2 class="text-3xl font-semibold text-green-950 mt-2"><?php esc_html_e('Selected works in progress', 'fell-studio'); ?></h2>
                    </div>
                    <a href="<?php echo esc_url(get_post_type_archive_link('object')); ?>" class="text-green-900 underline underline-offset-4">
                        <?php esc_html_e('View all objects', 'fell-studio'); ?>
                    </a>
                </header>

                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <?php
                    $objects_query = new WP_Query(array(
                        'post_type'      => 'object',
                        'posts_per_page' => 6,
                        'no_found_rows'  => true,
                    ));

                    if ($objects_query->have_posts()) :
                        while ($objects_query->have_posts()) :
                            $objects_query->the_post();
                            ?>
                            <article <?php post_class('space-y-4'); ?>>
                                <a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-3xl ring-1 ring-gray-100 hover:ring-green-300 transition">
                                    <?php
                                    if (has_post_thumbnail()) :
                                        the_post_thumbnail('large', array('class' => 'w-full h-72 object-cover'));
                                    else :
                                        ?>
                                        <div class="h-72 bg-gray-100 flex items-center justify-center text-gray-500">
                                            <?php esc_html_e('Object preview', 'fell-studio'); ?>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div>
                                    <?php the_title('<h3 class="text-2xl font-semibold text-green-950">', '</h3>'); ?>
                                    <p class="text-gray-600 mt-2">
                                        <?php echo wp_kses_post(get_the_excerpt()); ?>
                                    </p>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        ?>
                        <p class="text-gray-600"><?php esc_html_e('Add your first Object to see it featured here.', 'fell-studio'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gray-900 text-white">
            <div class="container space-y-10">
                <header class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-green-200"><?php esc_html_e('Spaces', 'fell-studio'); ?></p>
                        <h2 class="text-3xl font-semibold mt-2"><?php esc_html_e('Studios, galleries & touchpoints', 'fell-studio'); ?></h2>
                    </div>
                    <a href="<?php echo esc_url(get_post_type_archive_link('space')); ?>" class="text-green-200 underline underline-offset-4">
                        <?php esc_html_e('View all spaces', 'fell-studio'); ?>
                    </a>
                </header>

                <div class="grid gap-10 md:grid-cols-2">
                    <?php
                    $spaces_query = new WP_Query(array(
                        'post_type'      => 'space',
                        'posts_per_page' => 4,
                        'no_found_rows'  => true,
                    ));

                    if ($spaces_query->have_posts()) :
                        while ($spaces_query->have_posts()) :
                            $spaces_query->the_post();
                            ?>
                            <article <?php post_class('bg-white/5 p-8 rounded-[2rem] space-y-4 backdrop-blur'); ?>>
                                <?php the_title('<h3 class="text-2xl font-semibold">', '</h3>'); ?>
                                <div class="text-green-100 space-y-4">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="overflow-hidden rounded-2xl">
                                            <?php the_post_thumbnail('large', array('class' => 'w-full h-56 object-cover')); ?>
                                        </div>
                                    <?php endif; ?>
                                    <p class="text-sm text-green-100/80">
                                        <?php echo wp_kses_post(get_the_excerpt()); ?>
                                    </p>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 font-medium text-green-200">
                                    <?php esc_html_e('View space', 'fell-studio'); ?>
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        ?>
                        <p class="text-green-100"><?php esc_html_e('Add a space to highlight physical locations or installations.', 'fell-studio'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
</div>

<?php
get_footer();

