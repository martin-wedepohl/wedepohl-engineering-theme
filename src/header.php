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
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'twentytwentyone' ); ?></a>

	<?php get_template_part( 'template-parts/header/site-header' ); ?>

	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<?php
			$default_url    = '/wp-content/themes/wedepohl-engineering/dist/img/digital-ball.jpg';
			$background_url = get_theme_mod( 'background_image', $default_url );
			if ( '' === $background_url ) {
				$background_url = $default_url;
			}
			?>
			<main id="main" class="site-main" role="main" data-url="<?php echo $background_url; ?>">
