<?php get_header(); ?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>

		<article id="post-<?php echo esc_attr( $post->ID ); ?>" class="post-<?php echo esc_attr( $post->ID ); ?> <?php echo esc_attr( $post->post_type ); ?> type-<?php echo esc_attr( $post->post_type ); ?> status-<?php echo esc_attr( $post->post_status ); ?> hentry entry">

			<header class="entry-header aligncenter">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php get_template_part( 'template-parts/components/components', 'thumbnail' ); ?>
			</header>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<footer class="entry-footer default-max-width">

				<div class="posted-by">
					<?php get_template_part( 'template-parts/components/components', 'posted' ); ?>
				</div>

				<div class="post-taxonomies">
					<p>Categories: <?php echo get_the_category_list( ', ' ); ?></p>
					<?php echo get_the_tag_list( sprintf( '<p>%s: ', __( 'Tagged in', 'wet' ) ), ', ', '</p>' ); ?>
				</div>

				<?php get_template_part( 'template-parts/components/components', 'edit' ); ?>

			</footer>

		</article>

	<?php endwhile;
endif; ?>

<?php get_footer(); ?>
