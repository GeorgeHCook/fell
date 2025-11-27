<?php
/**
 * About page template
 *
 * Template Name: About Page
 *
 * @package FellStudio
 */

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        $intro_heading = function_exists('get_field') ? get_field('about_intro_heading') : __('About Fell Studio', 'fell-studio');
        $intro_body = function_exists('get_field') ? get_field('about_intro_body') : '';
        $team_members = function_exists('get_field') ? get_field('about_team_members') : array();
        $values = function_exists('get_field') ? get_field('about_values') : array();
        ?>

        <div id="content" class="flex-grow">
            <main id="main" class="py-16 space-y-24">
                <section class="container grid gap-12 lg:grid-cols-2 items-start">
                    <div class="space-y-6">
                        <p class="text-sm uppercase tracking-[0.4em] text-green-700"><?php esc_html_e('Story', 'fell-studio'); ?></p>
                        <h1 class="text-5xl font-semibold text-green-950 leading-tight">
                            <?php echo esc_html($intro_heading ?: get_the_title()); ?>
                        </h1>
                        <?php if ($intro_body) : ?>
                            <div class="prose prose-lg text-gray-700">
                                <?php echo wp_kses_post($intro_body); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="prose prose-lg text-gray-800">
                        <?php the_content(); ?>
                    </div>
                </section>

                <section class="bg-gray-50 py-16">
                    <div class="container space-y-10">
                        <header class="text-center space-y-3">
                            <p class="text-sm uppercase tracking-[0.4em] text-green-700"><?php esc_html_e('Values', 'fell-studio'); ?></p>
                            <h2 class="text-3xl font-semibold text-green-950"><?php esc_html_e('How we work', 'fell-studio'); ?></h2>
                        </header>
                        <div class="grid gap-10 md:grid-cols-3">
                            <?php if ($values) : ?>
                                <?php foreach ($values as $value) : ?>
                                    <article class="bg-white rounded-3xl p-8 shadow-sm ring-1 ring-gray-100 space-y-4">
                                        <h3 class="text-xl font-semibold text-green-950"><?php echo esc_html($value['title'] ?? ''); ?></h3>
                                        <p class="text-gray-600 text-base">
                                            <?php echo esc_html($value['description'] ?? ''); ?>
                                        </p>
                                    </article>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p class="text-gray-600 md:col-span-3">
                                    <?php esc_html_e('Define your studio values in ACF to display them here.', 'fell-studio'); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

                <section class="container space-y-12">
                    <header class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <p class="text-sm uppercase tracking-[0.4em] text-green-700"><?php esc_html_e('Team', 'fell-studio'); ?></p>
                            <h2 class="text-3xl font-semibold text-green-950 mt-2"><?php esc_html_e('Core collaborators', 'fell-studio'); ?></h2>
                        </div>
                        <p class="text-gray-600 max-w-2xl">
                            <?php esc_html_e('Use the “About Team Members” repeater in ACF to add bios and roles.', 'fell-studio'); ?>
                        </p>
                    </header>

                    <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
                        <?php if (!empty($team_members)) : ?>
                            <?php foreach ($team_members as $member) : ?>
                                <article class="space-y-4">
                                    <div class="aspect-square overflow-hidden rounded-[2rem] bg-gray-100">
                                        <?php
                                        if (!empty($member['photo'])) :
                                            echo wp_get_attachment_image($member['photo']['ID'], 'large', false, array('class' => 'w-full h-full object-cover'));
                                        else :
                                            ?>
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                                                <?php esc_html_e('Team photo', 'fell-studio'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-semibold text-green-950">
                                            <?php echo esc_html($member['name'] ?? __('Name', 'fell-studio')); ?>
                                        </h3>
                                        <p class="text-sm uppercase tracking-[0.3em] text-green-700">
                                            <?php echo esc_html($member['role'] ?? __('Role', 'fell-studio')); ?>
                                        </p>
                                        <?php if (!empty($member['bio'])) : ?>
                                            <p class="text-gray-600 mt-3"><?php echo esc_html($member['bio']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="text-gray-600 md:col-span-2 lg:col-span-3">
                                <?php esc_html_e('Add team members via the About page ACF group to populate this grid.', 'fell-studio'); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </section>
            </main>
        </div>

        <?php
    endwhile;
endif;

get_footer();

