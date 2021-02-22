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

			// Add sections to the panel.
			$wp_customize->add_section(
				'button',
				array(
					'title'    => 'The Button',
					'priority' => 20,
					'panel'    => 'wet-panel',
				)
			);
		  
			$wp_customize->add_section(
				'wet_colors',
				array(
					'title'    => 'Colors',
					'priority' => 30,
					'panel'    => 'wet-panel',
				)
			);

			$wp_customize->add_section(
				'wet_images',
				array(
					'title'    => 'Images',
					'priority' => 40,
					'panel'    => 'wet-panel',
				)
			);

			// Add settings to the sections.
			$wp_customize->add_setting(
				'button_display',
				array(
					'default'   => true,
					'transport' => 'refresh',
				)
			);

			$wp_customize->add_setting(
				'button_text',
				array(
					'default'   => 'Projects Button',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_setting(
				'background_color',
				array(
					'default'   => '#43C6E4',
					'transport' => 'refresh',
				)
			);

			$wp_customize->add_setting(
				'background_image',
				array(
					'default'   => '',
					'transport' => 'refresh',
				)
			);

			// Add controls to the sections.			
			$wp_customize->add_control(
				'button_display',
				array(
					'label'    => 'Button Display',
					'section'  => 'button',
					'settings' => 'button_display',
					'type'     => 'radio',
					'choices'  => array(
						'show' => 'Show Button',
						'hide' => 'Hide Button',
					),
				)
			);

			$wp_customize->add_control(
				'button_text',
				array(
					'label'   => 'Button Text',
					'section' => 'button',
					'type'    => 'text',
				)
			);

			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					'background_color',
					array(
						'label'    => 'Background Color',
						'section'  => 'wet_colors',
						'settings' => 'background_color',
					)
				)
			);

			// Add selective refresh.
			$wp_customize->selective_refresh->add_partial(
				'button_display',
				array(
					'selector' => '#button-container',
					'render_callback' => 'show_main_button',
				)
			);

			// Add Controls
			$wp_customize->add_control(
				new \WP_Customize_Image_Control(
					$wp_customize,
					'background_image',
					array(
						'label'    => __('Background Image', 'wet'),
						'section'  => 'wet_images',
						'settings' => 'background_image',    
					)
				)
			);


			// Selective refresh for blog name and blog description.
			$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
			
		}

		/**
		 * Set the CSS for the custom properties
		 */
		public function customizer_css() {
			?>
<style type="text/css">
	body { background: #<?php echo get_theme_mod('background_color', '#43C6E4'); ?>; }
</style>
			<?php
		}

		/**
		 * Callback function for the selective refresh.
		 */
		public function show_main_button() {
			if( 'show' === get_theme_mod( 'button_display', 'show' ) ) {
				echo "<a id='projects-button' href='/projects' class='button'>" . get_theme_mod( 'button_text', 'Projects Button' ) . "</a>";
			}
		}
	}
}
