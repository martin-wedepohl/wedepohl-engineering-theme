<?php get_header(); ?>

<?php if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>
		<a class="button" href="/resume">Resume</a>
		<a class="button" href="/projects">Projects</a>
		<a class="button" href="/contactus">Contact Us</a>
		<div id="button-container">
			<?php $we_customizer->show_main_button(); ?>
		</div>
	<?php endwhile;
endif; ?>

<?php get_footer(); ?>
