<?php

/**
 * Inspiro functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Inspiro
 * @since Inspiro 1.0.0
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (! class_exists('Inspiro_After_Setup_Theme')) {
	/**
	 * Inspiro_After_Setup_Theme initial setup
	 *
	 * @since 1.0.0
	 */
	class Inspiro_After_Setup_Theme
	{
		/**
		 * Instance
		 *
		 * @var $instance
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 1.0.0
		 * @return object
		 */
		public static function get_instance()
		{
			if (! isset(self::$instance)) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct()
		{
			add_action('after_setup_theme', array($this, 'theme_setup'));
			add_action('template_redirect', array($this, 'theme_content_width'), 0);
			add_filter('ocdi/register_plugins', array($this, 'ocdi_register_plugins'));
			add_filter('ocdi/import_files', array($this, 'ocdi_import_files'));
			add_action('ocdi/after_import', array($this, 'ocdi_after_import_setup'));
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since 1.0.0
		 */
		public function theme_setup()
		{
			do_action('inspiro_lite_theme_setup');

			// Add default posts and comments RSS feed links to head.
			add_theme_support('automatic-feed-links');

			/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support('title-tag');

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
			 */
			add_theme_support('post-thumbnails');

			// Remove core block patterns.
			remove_theme_support('core-block-patterns');

			/**
			 * Register image sizes.
			 */
			// phpcs:disable
			// add_image_size( 'inspiro-recent-thumbnail', 345, 192, true );
			// add_image_size( 'inspiro-recent-thumbnail-retina', 690, 384, true );
			// add_image_size( 'inspiro-entry-cover', 1800 );
			// phpcs:enable
			add_image_size('inspiro-loop', 950, 320, true);
			add_image_size('inspiro-loop@2x', 1900, 640, true);

			// Set the default content width.
			$GLOBALS['content_width'] = 950;

			// Register nav menus.
			register_nav_menus(
				array(
					'primary' => __('Main Menu', 'inspiro'),
				)
			);

			/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support(
				'html5',
				array(
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				)
			);

			/*
			 * Enable support for Post Formats.
			 *
			 * See: https://wordpress.org/support/article/post-formats/
			 */
			add_theme_support(
				'post-formats',
				array(
					'aside',
					'image',
					'video',
					'quote',
					'link',
					'gallery',
					'audio',
				)
			);

			// Add theme support for Custom Logo.
			add_theme_support(
				'custom-logo',
				array(
					'height'      => 100,
					'width'       => 400,
					'flex-height' => true,
					'flex-width'  => true,
				)
			);

			// Add theme support for selective refresh for widgets.
			add_theme_support('customize-selective-refresh-widgets');

			/*
			 * This theme styles the visual editor to resemble the theme style,
			 * specifically font, colors, and column width.
			 */
			add_editor_style(
				array(
					'assets/css/editor-style.css',
					Inspiro_Fonts_Manager::get_google_font_url(),
				)
			);

			// Load regular editor styles into the new block-based editor.
			add_theme_support('editor-styles');

			// Load default block styles.
			add_theme_support('wp-block-styles');

			// Add support for full and wide align images.
			add_theme_support('align-wide');

			// Add support for responsive embeds.
			add_theme_support('responsive-embeds');
		}

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @since 1.0.0
		 *
		 * @global int $content_width
		 */
		public function theme_content_width()
		{
			$content_width = $GLOBALS['content_width'];

			// Get layout.
			$blog_layout = inspiro_get_theme_mod('layout_blog_page');

			// Check if layout is full width.
			if ('full' === $blog_layout) {
				if (inspiro_is_frontpage() && ! is_active_sidebar('blog-sidebar')) {
					$content_width = 1200;
				} elseif (is_page()) {
					$content_width = 950;
				}
			}

			// Check if is single post and there is no sidebar.
			if (is_single() && ! is_active_sidebar('blog-sidebar')) {
				$content_width = 950;
			}

			/**
			 * Filters Inspiro content width of the theme.
			 *
			 * @since 1.0.0
			 *
			 * @param int $content_width Content width in pixels.
			 */
			$GLOBALS['content_width'] = apply_filters('inspiro_content_width', $content_width);
		}

		public function ocdi_register_plugins($plugins)
		{
			$theme_plugins = [
				[
					'name'     => 'Instagram Widget by WPZOOM',
					'slug'     => 'instagram-widget-by-wpzoom',
					'required' => false,
				],
				[
					'name'     => 'WPZOOM Forms',
					'slug'     => 'wpzoom-forms',
					'required' => true,
				],
			];

			// Check if user is on the theme recommeneded plugins step and a demo was selected.
			if (
				isset($_GET['step']) &&
				$_GET['step'] === 'import' &&
				isset($_GET['import'])
			) {

				// Adding one additional plugin for the first demo import ('import' number = 0).
				if ($_GET['import'] === '0') {

					$theme_plugins[] =  [
						'name'     => 'WPZOOM Portfolio',
						'slug'     => 'wpzoom-portfolio',
						'required' => true,
					];
				} elseif ($_GET['import'] === '1') {


					$theme_plugins[] =  [
						'name'     => 'Elementor',
						'slug'     => 'elementor',
						'required' => true,
					];
					$theme_plugins[] = [
						'name'     => 'Elementor Addons by WPZOOM',
						'slug'     => 'wpzoom-elementor-addons',
						'required' => true,
					];
					$theme_plugins[] =  [
						'name'     => 'WPZOOM Portfolio',
						'slug'     => 'wpzoom-portfolio',
						'required' => true,
					];
				} elseif ($_GET['import'] === '2') {

					$theme_plugins[] =  [
						'name'     => 'WooCommerce',
						'slug'     => 'woocommerce',
						'required' => true,
					];
				}
			}

			return array_merge($plugins, $theme_plugins);
		}


		public function ocdi_import_files()
		{
			return [
				[
					'import_file_name'           => 'Inspiro Lite - Gutenberg Blocks',
					'import_file_url'            => 'https://www.wpzoom.com/downloads/xml/inspiro-lite-blocks.xml',
					'import_widget_file_url'     => 'https://www.wpzoom.com/downloads/xml/inspiro-lite-widgets.wie',
					'import_customizer_file_url' => 'https://www.wpzoom.com/downloads/xml/inspiro-lite-customizer.dat',
					'import_preview_image_url'   => 'https://www.wpzoom.com/wp-content/uploads/2024/10/inspiro-lite-block.png',
					'preview_url'                => 'https://demo.wpzoom.com/inspiro-lite-blocks/',
				],
				[
					'import_file_name'           => 'Inspiro Lite - Elementor',
					'import_file_url'            => 'https://www.wpzoom.com/downloads/xml/inspiro-lite.xml',
					'import_widget_file_url'     => 'https://www.wpzoom.com/downloads/xml/inspiro-lite-widgets.wie',
					'import_customizer_file_url' => 'https://www.wpzoom.com/downloads/xml/inspiro-lite-customizer.dat',
					'import_preview_image_url'   => 'https://www.wpzoom.com/wp-content/uploads/2021/10/inspiro-lite-elementor-1.png',
					'preview_url'                => 'https://demo.wpzoom.com/inspiro-lite/',
				],
				[
					'import_file_name'           => 'Inspiro Lite - WooCommerce Shop',
					'import_file_url'            => 'https://www.wpzoom.com/downloads/xml/inspiro-lite-woo.xml',
					'import_widget_file_url'     => 'https://www.wpzoom.com/downloads/xml/inspiro-lite-woo-widgets.wie',
					'import_customizer_file_url' => 'https://www.wpzoom.com/downloads/xml/inspiro-lite-woo.dat',
					'import_preview_image_url'   => 'https://www.wpzoom.com/wp-content/uploads/2024/10/inspiro-lite-woo.png',
					'preview_url'                => 'https://demo.wpzoom.com/inspiro-lite-woo/',
				],
			];
		}


		public function ocdi_after_import_setup()
		{
			// Assign menus to their locations.
			$main_menu = get_term_by('name', 'Main', 'nav_menu');

			set_theme_mod(
				'nav_menu_locations',
				[
					'primary' => $main_menu->term_id, // replace 'main-menu' here with the menu location identifier from register_nav_menu() function in your theme.
				]
			);

			// Assign front page and posts page (blog page).
			$front_page_id = inspiro_get_page_by_title('Homepage');
			$blog_page_id  = inspiro_get_page_by_title('Blog');

			update_option('show_on_front', 'page');
			update_option('page_on_front', $front_page_id->ID);
			update_option('page_for_posts', $blog_page_id->ID);
		}
	}
}

Inspiro_After_Setup_Theme::get_instance();
