<?php
/**
 * Single Space template
 *
 * @package FellStudio
 */

get_header();

$location = function_exists('get_field') ? get_field('space_location') : '';
$availability = function_exists('get_field') ? get_field('space_availability') : '';
$cta_label = function_exists('get_field') ? get_field('space_cta_label') : __('Book a visit', 'fell-studio');
$cta_link = function_exists('get_field') ? get_field('space_cta_link') : '';
$gallery = function_exists('get_field') ? get_field('space_gallery') : array();
?>

<div id="content" class="flex-grow">
    <main id="main" class="py-16 space-y-16">
        <?php while (have_posts()) : the_post(); ?>
            <section class="container grid gap-12 lg:grid-cols-2 items-start">
                <div class="space-y-6">
                    <p class="text-sm uppercase tracking-[0.4em] text-green-700"><?php esc_html_e('Space', 'fell-studio'); ?></p>
                    <?php the_title('<h1 class="text-5xl font-semibold text-green-950 leading-tight">', '</h1>'); ?>

                    <div class="space-y-4 text-lg">
                        <?php if ($location) : ?>
                            <p class="flex gap-3">
                                <span class="font-semibold text-green-900"><?php esc_html_e('Location', 'fell-studio'); ?>:</span>
                                <span class="text-gray-700"><?php echo esc_html($location); ?></span>
                            </p>
                        <?php endif; ?>
                        <?php if ($availability) : ?>
                            <p class="flex gap-3">
                                <span class="font-semibold text-green-900"><?php esc_html_e('Availability', 'fell-studio'); ?>:</span>
                                <span class="text-gray-700"><?php echo esc_html($availability); ?></span>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="prose prose-lg text-gray-700">
                        <?php the_content(); ?>
                    </div>

                    <?php if ($cta_link) : ?>
                        <a href="<?php echo esc_url($cta_link); ?>" class="inline-flex items-center gap-2 rounded-full bg-green-800 px-6 py-3 text-white uppercase tracking-wide">
                            <?php echo esc_html($cta_label); ?>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    <?php endif; ?>
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
        <?php endwhile; ?>
    </main>
</div>

<?php
get_footer();

