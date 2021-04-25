<?php
/**
 * Displays breadcrumbs
 *
 * @package WedepohlEngineering
 * @subpackage Wedepohl_Engineering
 */

$is_home_page = is_front_page() || is_home();

if ( ! $is_home_page ) {
	$my_id       = $post->ID;
	$breadcrumbs = get_post_ancestors( $post );
	$breadcrumbs = array_reverse( $breadcrumbs );

	$breadcrumbs_link = '<div class="site-breadcrumb"><a href="' . esc_url( get_home_url() ) . '">Home</a> » ';

	foreach ( $breadcrumbs as $pid ) {
		if ( $my_id === $pid ) {
			$breadcrumbs_link .= '<strong>' . esc_attr( get_the_title( $pid ) ) . '</strong>';
		} else {
			$breadcrumbs_link .= '<a href="' . esc_url( get_permalink( $pid ) ) . '">' . esc_attr( get_the_title( $pid ) ) . '</a> » ';
		}
	}

	$breadcrumbs_link .= '<strong>' . esc_attr( get_the_title() ) . '</strong></div> <!-- .site-breadcrumb -->';
	echo $breadcrumbs_link;
}
