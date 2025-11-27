<?php
/**
 * Single Object template
 *
 * @package FellStudio
 */

get_header();

$details = array(
    'year'        => function_exists('get_field') ? get_field('object_year') : '',
    'medium'      => function_exists('get_field') ? get_field('object_medium') : '',
    'dimensions'  => function_exists('get_field') ? get_field('object_dimensions') : '',
    'availability'=> function_exists('get_field') ? get_field('object_availability') : '',
);
$gallery = function_exists('get_field') ? get_field('object_gallery') : array();
?>

<div id="content" class="flex-grow">
    <main id="main" class="py-16 space-y-16">
        <?php while (have_posts()) : the_post(); ?>
            <section class="container grid gap-12 lg:grid-cols-2 items-start">
                <div class="space-y-6">
                    <p class="text-sm uppercase tracking-[0.4em] text-green-700"><?php esc_html_e('Object', 'fell-studio'); ?></p>
                    <?php the_title('<h1 class="text-5xl font-semibold text-green-950 leading-tight">', '</h1>'); ?>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <?php foreach ($details as $label => $value) : ?>
                            <?php if (!empty($value)) : ?>
                                <div class="border border-gray-200 rounded-2xl p-4">
                                    <p class="text-xs uppercase tracking-[0.3em] text-green-700"><?php echo esc_html(ucwords(str_replace('_', ' ', $label))); ?></p>
                                    <p class="text-lg text-green-950 mt-2"><?php echo esc_html($value); ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="space-y-6">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="overflow-hidden rounded-[2.5rem] shadow-2xl ring-1 ring-green-50">
                            <?php the_post_thumbnail('full', array('class' => 'w-full h-full object-cover')); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($gallery)) : ?>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <?php foreach ($gallery as $image) : ?>
                                <div class="overflow-hidden rounded-3xl">
                                    <?php echo wp_get_attachment_image($image['ID'], 'large', false, array('class' => 'w-full h-56 object-cover')); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="container prose prose-lg max-w-4xl text-gray-800">
                <?php the_content(); ?>
            </section>
        <?php endwhile; ?>
    </main>
</div>

<?php
get_footer();

