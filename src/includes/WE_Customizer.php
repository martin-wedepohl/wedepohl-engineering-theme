<?php
/**
 * Wedepohl Engineering Customizer
 *
 * PHP Version 7
 *
 * @category WET
 * @package  WE_Customizer
 * @author   Martin Wedepohl <martin@wedepohlengineering.com>
 * @license  GPL3 or later
 */

namespace WET\Includes;

require_once __DIR__ . '/../vendor/autoload.php';

defined( 'ABSPATH' ) || die( '' );

if ( ! class_exists( 'WE_Customizer' ) ) {

	/**
	 * Customizer Class for Spyglass HiTek/Wedepohl Engineering Theme.
	 *
	 * @package   WE_Customizer
	 * @author    Martin Wedepohl <martin@wedepohlengineering.com>
	 * @copyright 2021 Wedepohl Engineering
	 */
	class WE_Customizer {

		/**
		 * Class Constructor
		 */
		public function __construct() {
			\add_action( 'customize_preview_init', array( $this, 'enqueue' ) );
			\add_action( 'customize_register', array( $this, 'customizer_settings' ) );
			\add_action( 'wp_head', array( $this, 'customizer_css' ) );
		}

		/**
		 * Enqueue the customizer script
		 */
		public function enqueue() {
			wp_enqueue_script(
				'wet_customizer',
				get_template_directory_uri() . '/dist/js/customizer.min.js',
				array( 'customize-preview' ),
				filemtime( get_stylesheet_directory() . '/dist/js/customizer.min.js' ),
				true
			);
		}		

		/**
		 * Initialize the customizer settings
		 */
		public function customizer_settings( $wp_customize ) {

			// Add a default panel for all the settings.
			$wp_customize->add_panel(
				'wet-panel',
				array(
					'title'       => __( 'Theme Options', 'wet' ),
					'description' => __( 'Wedepohl Engineering Theme Options.', 'wet' ),
				)	
			);	

			// Add Buttons Customizer
			$this->add_button_setting( $wp_customize, 1 );
			$this->add_button_setting( $wp_customize, 2 );
			$this->add_button_setting( $wp_customize, 3 );
			$this->add_button_section( $wp_customize, 'wet-panel', 1 );
			$this->add_button_section( $wp_customize, 'wet-panel', 2 );
			$this->add_button_section( $wp_customize, 'wet-panel', 3 );
			$pages       = get_pages();
			$pages_array = array( '' => 'Select a Page' );
			foreach( $pages as $page ) {
				$pages_array[ $page->post_name ] = $page->post_title;
			}
			$this->add_button_control( $wp_customize, $pages_array, 1 );
			$this->add_button_control( $wp_customize, $pages_array, 2 );
			$this->add_button_control( $wp_customize, $pages_array, 3 );
			
			// Add Color Customizer
			$wp_customize->add_setting(
				'background_color',
				array(
					'default'   => '#43C6E4',
					'transport' => 'postMessage',
				)	
			);	
				
			$wp_customize->add_section(
				'wet-colors',
				array(
					'title'    => 'Colors',
					'priority' => 30,
					'panel'    => 'wet-panel',
				)		
			);

			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'background_color',
					array(
						'label'    => 'Background Color',
						'section'  => 'wet-colors',
						'settings' => 'background_color',
					)
				)
			);

			// Add Image Customizer
			$this->add_image_setting( $wp_customize, '' );
			$this->add_image_setting( $wp_customize, '1200' );
			$this->add_image_setting( $wp_customize, '992' );
			$this->add_image_setting( $wp_customize, '768' );
			$this->add_image_setting( $wp_customize, '600' );
			$wp_customize->add_section(
				'wet-images',
				array(
					'title'    => 'Images',
					'priority' => 40,
					'panel'    => 'wet-panel',
				)
			);
			$this->add_image_control( $wp_customize, 'wet-images', '',     __( 'Background Image (1920 pixel width', 'wet' ) );
			$this->add_image_control( $wp_customize, 'wet-images', '1200', __( 'Background Image (1200 pixel width', 'wet' ) );
			$this->add_image_control( $wp_customize, 'wet-images', '992',  __( 'Background Image (992 pixel width', 'wet' ) );
			$this->add_image_control( $wp_customize, 'wet-images', '768',  __( 'Background Image (768 pixel width', 'wet' ) );
			$this->add_image_control( $wp_customize, 'wet-images', '600',  __( 'Background Image (600 pixel width', 'wet' ) );

			// Selective refresh for blog name and blog description.
			$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		}

		/**
		 * Set the CSS for the custom properties
		 */
		public function customizer_css() {
			?>
<style type="text/css">
	body { background: #<?php echo esc_attr( get_theme_mod( 'background_color', '#43C6E4' ) ); ?>; }
</style>
			<?php
		}

		public function add_button_section( $wp_customize, $panel, $button ) {

			$wp_customize->add_section(
				"wet-button{$button}",
				array(
					'title'    => "Front Page Button {$button}",
					'priority' => $button,
					'panel'    => $panel,
				)
			);

		}

		public function add_button_setting( $wp_customize, $button ) {

			$wp_customize->add_setting(
				"button_display_{$button}",
				array(
					'default'   => true,
					'transport' => 'refresh',
				)
			);

			$wp_customize->add_setting(
				"button_text_{$button}",
				array(
					'default'   => 'Resume',
					'transport' => 'refresh',
				)
			);

			$wp_customize->add_setting(
				"button_page_{$button}",
				array(
					'default'   => 'resume',
					'transport' => 'refresh',
				)
			);

			$wp_customize->add_setting(
				"button_fore_{$button}",
				array(
					'default'   => '#fff',
					'transport' => 'refresh',
				)
			);

			$wp_customize->add_setting(
				"button_back_{$button}",
				array(
					'default'   => '#f00',
					'transport' => 'refresh',
				)
			);

		}

		public function add_button_control( $wp_customize, $pages, $button ) {

			$wp_customize->add_control(
				"button_display_{$button}",
				array(
					'label'    => "Display Button {$button}",
					'section'  => "wet-button{$button}",
					'settings' => "button_display_{$button}",
					'type'     => 'radio',
					'choices'  => array(
						'show' => 'Show Button',
						'hide' => 'Hide Button',
					),
				)
			);

			$wp_customize->add_control(
				"button_text_{$button}",
				array(
					'label'   => "Button {$button} Text",
					'section' => "wet-button{$button}",
					'type'    => 'text',
				)
			);

			$wp_customize->add_control(
				new \WP_Customize_Control(
					$wp_customize,
					"button_page_{$button}",
					array(
						'label'   => "Button {$button} Page",
						'section' => "wet-button{$button}",
						'type'    => 'select',
						'choices' => $pages,
					)
				)
			);

			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					"button_back_{$button}",
					array(
						'label'    => 'Background Color',
						'section'  => "wet-button{$button}",
						'settings' => "button_back_{$button}",
					)
				)
			);

			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					"button_fore_{$button}",
					array(
						'label'    => 'Foreground Color',
						'section'  => "wet-button{$button}",
						'settings' => "button_fore_{$button}",
					)
				)
			);

		}

		public function add_image_setting( $wp_customize, $image ) {

			$wp_customize->add_setting(
				"background_image{$image}",
				array(
					'default'   => '',
					'transport' => 'refresh',
				)
			);

		}

		public function add_image_control( $wp_customize, $section, $image, $label ) {

			$wp_customize->add_control(
				new \WP_Customize_Image_Control(
					$wp_customize,
					"background_image{$image}",
					array(
						'label'    => $label,
						'section'  => $section,
						'settings' => "background_image{$image}",
					)
				)
			);

		}

		public function build_button( $num, $page, $background, $color, $text ) {
			if ( 'show' === get_theme_mod( "button_display_{$num}", 'show' ) ) {
				$id  = esc_attr( "button-$num" );
				$url = esc_url( get_site_url() . '/' . get_theme_mod( "button_page_{$num}", $page ) . '/' );
				$bg  = esc_attr( get_theme_mod( "button_back_{$num}", $background ) );
				$clr = esc_attr( get_theme_mod( "button_fore_{$num}", $color ) );
				$txt = esc_attr( get_theme_mod( "button_text_{$num}", $txt ) );
				return "<a id='{$id}' href='{$url}' class='buttons front-page-button' style='background-color:{$bg}; color:{$clr};'>${txt}</a>";
			}
			return '';
		}

		/**
		 * Callback function for the selective refresh.
		 */
		public function show_main_buttons() {
			echo $this->build_button( 1, 'resume', '#f00', '#fff', 'Resume' );
			echo $this->build_button( 2, 'contact-us', '#f00', '#fff', 'Contact Us' );
			echo $this->build_button( 3, 'projects', '#f00', '#fff', 'Projects' );
		}
	}
}
