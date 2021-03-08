<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>> 
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wet' ); ?></a>

	<?php get_template_part( 'template-parts/header/site-header' ); ?>

	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<?php
			$default_url    = '/wp-content/themes/wedepohl-engineering/dist/img/digital-ball.jpg';
			$background_url = get_theme_mod( 'background_image', $default_url );
			if ( '' === $background_url ) {
				$background_url = $default_url;
			}
			$default_url        = '/wp-content/themes/wedepohl-engineering/dist/img/digital-ball-1200.jpg';
			$background_url1200 = get_theme_mod( 'background_image1200', $default_url );
			if ( '' === $background_url1200 ) {
				$background_url1200 = $default_url;
			}
			$default_url       = '/wp-content/themes/wedepohl-engineering/dist/img/digital-ball-992.jpg';
			$background_url992 = get_theme_mod( 'background_image992', $default_url );
			if ( '' === $background_url992 ) {
				$background_url992 = $default_url;
			}
			$default_url       = '/wp-content/themes/wedepohl-engineering/dist/img/digital-ball-768.jpg';
			$background_url768 = get_theme_mod( 'background_image768', $default_url );
			if ( '' === $background_url768 ) {
				$background_url768 = $default_url;
			}
			$default_url       = '/wp-content/themes/wedepohl-engineering/dist/img/digital-ball-600.jpg';
			$background_url600 = get_theme_mod( 'background_image600', $default_url );
			if ( '' === $background_url600 ) {
				$background_url600 = $default_url;
			}
			?>
			<main id="main" class="site-main" role="main" data-url="<?php echo esc_url( $background_url ); ?>" data-url1200="<?php echo esc_url( $background_url1200 ); ?>" data-url992="<?php echo esc_url( $background_url992 ); ?>" data-url768="<?php echo esc_url( $background_url768 ); ?>" data-url600="<?php echo esc_url( $background_url600 ); ?>">
