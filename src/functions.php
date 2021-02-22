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

		const DEBUG_THEME      = true;
		const THEME_VERSION    = '0.1.0';

		public function __construct() {
			\add_theme_support( 'post-thumbnails' );

			\add_action( 'wp_enqueue_scripts', array( $this, 'wet_enqueue_scripts' ) );
			\add_filter( 'wp_title', array( $this, 'wet_filter_title' ), 10, 2 );
			\add_filter( 'excerpt_length', array( $this, 'wet_custom_excerpt_length' ) );
			\add_filter( 'excerpt_more', array( $this, 'wet_except_more' ) );
			\add_action( 'after_setup_theme', array( $this, 'load_navigation' ) );
			\add_action( 'widgets_init', array( $this, 'add_widgets' ) );
	
		}

		public function wet_enqueue_scripts() {
			\wp_enqueue_style(
				'wedeng-style',
				get_template_directory_uri() . '/dist/css/stylesheet.min.css',
				array(),
				WE_Theme::DEBUG_THEME ? filemtime( get_stylesheet_directory() . '/dist/css/stylesheet.min.css' ) : WE_Theme::THEME_VERSION,
				'all'
			);
			\wp_enqueue_script(
				'wedeng-script',
				get_template_directory_uri() . '/dist/js/script.min.js',
				array(),
				WE_Theme::DEBUG_THEME ? filemtime( get_stylesheet_directory() . '/dist/js/script.min.js' ) : WE_Theme::THEME_VERSION,
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
		public function wet_filter_title( string $title, string $sep ) : string {
			global $page, $paged;

			if ( \is_feed() ) {
				return $title;
			}

			// Add the blog name
			$title .= \get_bloginfo( 'name', 'display' );

			// Add the blog description for the home/front page.
			$site_description = \get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) ) {
				$title .= " $sep $site_description";
			}

			// Add a page number if necessary:
			if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
				$title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
			}
			return $title;

		}

		public function wet_custom_excerpt_length() {
			return 20;
		}
		
		public function wet_except_more() {
			return '<a href=' . \get_the_permalink() . '> ... Read More</a>';
		}
		
		public function load_navigation() {
			\register_nav_menus(
				array(
					'sticky_bar' => __( 'Sticky Bar', 'wet' ),
					'footer_bar' => __( 'Footer Bar', 'wet' )
				)
			);
		}
		
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

	}

	new WE_Theme();
	$we_customizer = new Includes\WE_Customizer();

}
