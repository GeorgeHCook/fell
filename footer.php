<?php
/**
 * Theme footer
 *
 * @package FellStudio
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

    <footer id="colophon" class="bg-gray-100 py-8 mt-12">
        <div class="container text-center text-gray-600 space-y-2">
            <p>&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>.</p>
            <p><?php esc_html_e('All rights reserved.', 'fell-studio'); ?></p>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>

