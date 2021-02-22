<span class="posted-on">Published <time class="entry-date published updated" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php the_date(); ?></time>
</span>
<span class="byline">By
	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
		<?php the_author(); ?>
	</a>
</span>
