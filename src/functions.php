<?php

namespace WET;

require_once __DIR__ . '/vendor/autoload.php';


defined( 'ABSPATH' ) || die( '' );

if ( ! class_exists( 'WE_Theme' ) ) {

	/**
	 * Theme for the SpyGlass HiTek/Wedepohl Engineering Website.
	 *
	 * @package   WE_Theme
	 * @author    Martin Wedepohl <martin@wedepohlengineering.com>
	 * @copyright 2021 Wedepohl Engineering
	 */
	class WE_Theme {

		const DEBUG_THEME   = true;
		const THEME_VERSION = '0.1.7';

		/**
		 * Class constructor.
		 */
		public function __construct() {
			\add_theme_support( 'post-thumbnails' );
			\add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
			\add_filter( 'wp_title', array( $this, 'filter_title' ), 10, 2 );
			\add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
			\add_filter( 'excerpt_more', array( $this, 'except_more' ) );
			\add_action( 'after_setup_theme', array( $this, 'register_navigation' ) );
			\add_action( 'widgets_init', array( $this, 'add_widgets' ) );
			\add_action( 'wp_head', array( $this, 'add_favicon' ) );
		}

		/**
		 * Enqueue styles and scripts.
		 *
		 * If the DEBUG_THEME flag is set use the modification time on the files as the version
		 * so they will be always reloaded. Otherwise use the version of the theme.
		 */
		public function enqueue() {
			$css = '';
			if ( \is_page( 'resume' ) || \is_page( 'additional-seminars' ) ) {
				$css  = get_template_directory_uri() . '/dist/css/resume.min.css';
				$file = get_stylesheet_directory() . '/dist/css/resume.min.css';
			} elseif ( \is_front_page() ) {
				$css  = get_template_directory_uri() . '/dist/css/home.min.css';
				$file = get_stylesheet_directory() . '/dist/css/home.min.css';
			} else {
				$css  = get_template_directory_uri() . '/dist/css/stylesheet.min.css';
				$file = get_stylesheet_directory() . '/dist/css/stylesheet.min.css';
			}

			if ( '' !== $css ) {
				$filemtime = filemtime( $file );
				\wp_enqueue_style(
					'wedeng-style',
					$css,
					array(),
					self::DEBUG_THEME ? $filemtime : self::THEME_VERSION,
					'all'
				);
			}

			\wp_enqueue_script(
				'wedeng-script',
				get_template_directory_uri() . '/dist/js/script.min.js',
				array(),
				self::DEBUG_THEME ? filemtime( get_stylesheet_directory() . '/dist/js/script.min.js' ) : self::THEME_VERSION,
				true
			);
		}

		/**
		 * Filter the title
		 *
		 * @param string $title Default title text for the current view.
		 * @param string $sep   Optional separator.
		 *
		 * @global $page  The pagination on static front page and single pages
		 * @global $paged The pagination on the homepage, blogpage, archive pages and pages
		 *
		 * @return string The filtered title
		 */
		public function filter_title( string $title, string $sep ) : string {
			global $page, $paged;

			if ( \is_feed() ) {
				return $title;
			}

			// Add the blog name.
			$title .= \get_bloginfo( 'name', 'display' );

			// Add the blog description for the home/front page.
			$site_description = \get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) ) {
				$title .= " $sep $site_description";
			}

			// Add a page number if necessary.
			if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
				$title .= " $sep " . sprintf( __( 'Page %s', 'wet' ), max( $paged, $page ) );
			}
			return $title;

		}

		/**
		 * Return the custom excerpt length for the theme.
		 *
		 * @return  int Number of characters in the excerpt length.
		 */
		public function excerpt_length() : int {
			return 20;
		}

		/**
		 * Handle the read more below the except.
		 *
		 * @return string The Read More string.
		 */
		public function except_more() : string {
			return '<a href=' . \get_the_permalink() . '> ... ' . __( 'Read More', 'wet' ) . '</a>';
		}

		/**
		 * Register the Navigation Menus.
		 *
		 * This theme has 2 a main and a footer.
		 */
		public function register_navigation() {
			\register_nav_menus(
				array(
					'primary' => __( 'Primary Navigation Bar', 'wet' ),
					'footer'  => __( 'Footer Navigation Bar', 'wet' )
				)
			);
		}

		/**
		 * Register the Widgets Sidebar.
		 */
		public function add_widgets() {
			\register_sidebar( 
				array( 
					'name' => __( 'Wed Eng Widgets', 'wet' ),
					'id'   => 'widgetId',
					'before_widget' => '<article class="widget">',
					'after_widget' => '</div>',
					'before_title' => '<h3>',
					'after_title' => '</h3>'
				)
			);
		}

		/**
		 * Add the Favicon
		 */
		public function add_favicon() {
			echo '<link rel="shortcut icon" type="image/x-icon" href="' . get_template_directory_uri() . '/dist/img/favicon.ico" />';
		}
	}

	// Initialize the theme and the customizer.
	new WE_Theme();
	$we_customizer = new includes\WE_Customizer();

}
