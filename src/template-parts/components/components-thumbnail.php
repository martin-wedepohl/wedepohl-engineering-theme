<figure class="post-thumbnail">
	<?php the_post_thumbnail(); ?>
	<figcaption class="wp-caption-text">
		<?php echo esc_html( wp_get_attachment_caption( get_post_thumbnail_id( $post->ID ) ) ); ?>
	</figcaption>
</figure>
