			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->
	<footer class="site-footer">
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'footer',
				'menu_class'      => 'menu-wrapper',
				'container_class' => 'footer-menu-container',
				'items_wrap'      => '<ul id="footer-menu-list" class="%2$s">%3$s</ul>',
				'fallback_cb'     => false,
			)
		);
		?>
		<span class="copyright">&copy; 1995-<?php echo esc_html( gmdate( 'Y' ) ); ?> Wedepohl Engineering</span>
		<span class="to-top">></span>
	</footer>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>


