<?php
/**
 * Contact page template
 *
 * Template Name: Contact Page
 *
 * @package FellStudio
 */

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        $contact_intro = function_exists('get_field') ? get_field('contact_intro') : __('We would love to hear about your upcoming projects.', 'fell-studio');
        $contact_email = function_exists('get_field') ? get_field('contact_email') : get_bloginfo('admin_email');
        $contact_phone = function_exists('get_field') ? get_field('contact_phone') : '';
        $contact_address = function_exists('get_field') ? get_field('contact_address') : '';
        $office_hours = function_exists('get_field') ? get_field('contact_hours') : '';
        $form_shortcode = function_exists('get_field') ? get_field('contact_form_shortcode') : '';
        ?>

        <div id="content" class="flex-grow">
            <main id="main" class="py-16">
                <div class="container grid gap-16 lg:grid-cols-2">
                    <section class="space-y-10">
                        <header class="space-y-4">
                            <p class="text-sm uppercase tracking-[0.4em] text-green-700"><?php esc_html_e('Contact', 'fell-studio'); ?></p>
                            <h1 class="text-5xl font-semibold text-green-950"><?php the_title(); ?></h1>
                            <p class="text-lg text-gray-600 max-w-xl"><?php echo esc_html($contact_intro); ?></p>
                        </header>

                        <div class="space-y-6 text-lg">
                            <?php if ($contact_email) : ?>
                                <p class="flex items-center gap-3">
                                    <span class="font-semibold text-green-900"><?php esc_html_e('Email', 'fell-studio'); ?>:</span>
                                    <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="underline decoration-green-300 decoration-2 underline-offset-4">
                                        <?php echo esc_html($contact_email); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            <?php if ($contact_phone) : ?>
                                <p class="flex items-center gap-3">
                                    <span class="font-semibold text-green-900"><?php esc_html_e('Phone', 'fell-studio'); ?>:</span>
                                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $contact_phone)); ?>" class="underline decoration-green-300 decoration-2 underline-offset-4">
                                        <?php echo esc_html($contact_phone); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            <?php if ($contact_address) : ?>
                                <p class="flex gap-3">
                                    <span class="font-semibold text-green-900"><?php esc_html_e('Studio', 'fell-studio'); ?>:</span>
                                    <span class="text-gray-700"><?php echo esc_html($contact_address); ?></span>
                                </p>
                            <?php endif; ?>
                            <?php if ($office_hours) : ?>
                                <p class="flex gap-3">
                                    <span class="font-semibold text-green-900"><?php esc_html_e('Hours', 'fell-studio'); ?>:</span>
                                    <span class="text-gray-700"><?php echo esc_html($office_hours); ?></span>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-4">
                            <h2 class="text-2xl font-semibold text-green-950"><?php esc_html_e('Collaborations & press', 'fell-studio'); ?></h2>
                            <div class="prose text-gray-700">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </section>

                    <section class="bg-gray-50 rounded-[2.5rem] p-10 shadow-inner">
                        <?php if ($form_shortcode) : ?>
                            <?php echo do_shortcode($form_shortcode); ?>
                        <?php elseif (function_exists('acf')) : ?>
                            <p class="text-gray-600">
                                <?php esc_html_e('Add a form shortcode via the Contact page ACF field to render it here.', 'fell-studio'); ?>
                            </p>
                        <?php else : ?>
                            <form class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="contact-name"><?php esc_html_e('Name', 'fell-studio'); ?></label>
                                    <input id="contact-name" type="text" class="w-full rounded-full border border-gray-200 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" placeholder="<?php esc_attr_e('Full name', 'fell-studio'); ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="contact-email"><?php esc_html_e('Email', 'fell-studio'); ?></label>
                                    <input id="contact-email" type="email" class="w-full rounded-full border border-gray-200 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" placeholder="hello@example.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="contact-message"><?php esc_html_e('Message', 'fell-studio'); ?></label>
                                    <textarea id="contact-message" rows="5" class="w-full rounded-3xl border border-gray-200 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                                </div>
                                <button type="submit" class="w-full rounded-full bg-green-800 px-5 py-3 text-white uppercase tracking-wide">
                                    <?php esc_html_e('Send Message', 'fell-studio'); ?>
                                </button>
                            </form>
                        <?php endif; ?>
                    </section>
                </div>
            </main>
        </div>

        <?php
    endwhile;
endif;

get_footer();

