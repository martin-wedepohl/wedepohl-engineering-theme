<?php get_header(); ?>

<h1><?php if ( is_category() ) { single_cat_title(); } elseif ( is_tag() ) { single_tag_title(); } ?></h1>

<ul>

<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>

	<li>

		<header class="entry-header aligncenter">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		</header>

		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div>

		<footer class="entry-footer default-max-width">

			<div class="posted-by">
				<?php get_template_part( 'template-parts/components/components', 'posted' ); ?>
			</div>

			<div class="post-taxonomies">
				<p class="post-categories">Categories: <?php echo get_the_category_list( ' | ' ); ?></p>
				<?php echo get_the_tag_list( sprintf( '<p class="post-tags">%s: ', __( 'Tagged in', 'wet' ) ), ' | ', '</p>' ); ?>
			</div>

			<?php get_template_part( 'template-parts/components/components', 'edit' ); ?>

		</footer>

	</li>

	<?php endwhile;
endif; ?>

</ul>

<?php get_footer(); ?>