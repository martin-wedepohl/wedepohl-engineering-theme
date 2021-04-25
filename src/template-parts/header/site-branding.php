<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

$blog_info    = get_bloginfo( 'name' );
$description  = get_bloginfo( 'description', 'display' );
$show_title   = ( true === get_theme_mod( 'display_title_and_tagline', true ) );
$header_class = $show_title ? 'site-title' : 'screen-reader-text';
$is_home_page = is_front_page() || is_home();

?>

<div class="site-branding">

	<div class="site-logo">
	<?php
	if ( ! $is_home_page ) {
		echo '<a href="' . esc_url( home_url( '/' ) ) . '">';
	}
	$img_file = get_stylesheet_directory() . '/dist/img/favicon.svg';
	if ( file_exists( $img_file ) ) {
		echo file_get_contents( $img_file );		 // phpcs:ignore WordPress.Security.EscapeOutput
	}
	if ( ! $is_home_page ) {
		echo '</a>';
	}
	?>
	</div> <!-- .site-logo -->

	<div class="site-name">
		<?php if ( $blog_info ) : ?>
			<?php if ( $is_home_page ) : ?>
				<h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html( $blog_info ); ?></h1>
			<?php else : ?>
				<p class="<?php echo esc_attr( $header_class ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $blog_info ); ?></a></p>
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( $description && get_theme_mod( 'display_title_and_tagline', true ) === true ) : ?>
			<p class="site-description">
				<?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</p>
		<?php endif; ?>
	</div> <!-- .site-name -->

</div><!-- .site-branding -->
