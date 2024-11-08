<?php

/**
 * Logovo functions and definitions
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Logovo
 * @since   Logovo 1.0.0
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Define Constants
 */
define('LOGOVO_THEME_VERSION', '1.9.7');
define('LOGOVO_THEME_DIR', trailingslashit(get_template_directory()));
define('LOGOVO_THEME_URI', trailingslashit(esc_url(get_template_directory_uri())));
define('LOGOVO_THEME_ASSETS_URI', LOGOVO_THEME_URI . 'dist');

/**
 * Setup helper functions.
 */
require LOGOVO_THEME_DIR . 'inc/common-functions.php';

/**
 * Setup theme media.
 */
require LOGOVO_THEME_DIR . 'inc/theme-media.php';

/**
 * Enqueues scripts and styles
 */
require LOGOVO_THEME_DIR . 'inc/classes/class-inspiro-enqueue-scripts.php';

/**
 * Setup custom wp-admin options pages
 */
require LOGOVO_THEME_DIR . 'inc/classes/class-inspiro-custom-wp-admin-menu.php';

/**
 * Additional features to include custom WP pointer function
 */
require LOGOVO_THEME_DIR . 'inc/classes/class-inspiro-wp-admin-menu-pointer.php';

/**
 * Functions and definitions.
 */
require LOGOVO_THEME_DIR . 'inc/classes/class-inspiro-after-setup-theme.php';

/**
 * Handle SVG icons.
 */
require LOGOVO_THEME_DIR . 'inc/classes/class-inspiro-svg-icons.php';

/**
 * Implement the Custom Header feature.
 */
require LOGOVO_THEME_DIR . 'inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require LOGOVO_THEME_DIR . 'inc/template-tags.php';

/**
 * Additional features to allow styling of the templates.
 */
require LOGOVO_THEME_DIR . 'inc/template-functions.php';

/**
 * Custom Template WC functions
 */
require LOGOVO_THEME_DIR . 'inc/wc-custom-functions.php';



/**
 * Custom template shortcode tags for this theme
 */
// require LOGOVO_THEME_DIR . 'inc/shortcodes.php';

/**
 * Customizer additions.
 */
require LOGOVO_THEME_DIR . 'inc/classes/class-inspiro-font-family-manager.php';
require LOGOVO_THEME_DIR . 'inc/classes/class-inspiro-fonts-manager.php';
require LOGOVO_THEME_DIR . 'inc/customizer-functions.php';
require LOGOVO_THEME_DIR . 'inc/customizer/class-inspiro-customizer-control-base.php';
require LOGOVO_THEME_DIR . 'inc/customizer/class-inspiro-customizer.php';

/**
 * SVG icons functions and filters.
 */
require LOGOVO_THEME_DIR . 'inc/icon-functions.php';

/**
 * Theme admin notices and info page
 */
if (is_admin()) {
	require LOGOVO_THEME_DIR . 'inc/admin-notice.php';
	require LOGOVO_THEME_DIR . 'inc/admin/admin-api.php';

	if (current_user_can('manage_options')) {
		require LOGOVO_THEME_DIR . 'inc/classes/class-inspiro-notices.php';
		require LOGOVO_THEME_DIR . 'inc/classes/class-inspiro-notice-review.php';
	}
}

/**
 * Inline theme css generated dynamically
 */
require LOGOVO_THEME_DIR . 'inc/dynamic-css/body.php';
require LOGOVO_THEME_DIR . 'inc/dynamic-css/logo.php';
require LOGOVO_THEME_DIR . 'inc/dynamic-css/headings.php';
require LOGOVO_THEME_DIR . 'inc/dynamic-css/hero-header-title.php';
require LOGOVO_THEME_DIR . 'inc/dynamic-css/hero-header-desc.php';
require LOGOVO_THEME_DIR . 'inc/dynamic-css/hero-header-button.php';
require LOGOVO_THEME_DIR . 'inc/dynamic-css/main-menu.php';
require LOGOVO_THEME_DIR . 'inc/dynamic-css/mobile-menu.php';
