
<?php if ( current_user_can( 'edit_post', $post->ID ) ) { ?>
<span class="edit-link">
	<a href="<?php echo esc_url( get_site_url() ); ?>/wp-admin/post.php?post=<?php echo esc_attr( $post->ID ); ?>&action=edit" class="post-edit-link">
		Edit <span class="screen-reader-text">
			<?php the_title(); ?>
		</span>
	</a>
</span>
<?php } ?>