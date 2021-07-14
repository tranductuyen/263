<?php
/*
Plugin Name: Get Shortlinks
Description: Get the classic "Get shortlink" from WordPress 3.7. Used inhouse and making use of the WordPress Repo updates.
Version:     0.5
Author:      Kostas Vrouvas
Author URI:  http://kosvrouvas.com
License:     GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wpshortlinks
*/

register_activation_hook( __FILE__, 'wp_classic_activation' );

function wp_classic_activation() {
	wp_classic_add_rewrites();
	flush_rewrite_rules();
}

// Add the rewrites
function wp_classic_add_rewrites() {
	add_rewrite_rule( '^p/(\d+)$', 'index.php?short=$matches[1]', 'top' );
}

add_action( 'init', 'wp_classic_add_rewrites' );

function wp_classic_query_vars( $vars ) {
	$vars[] = 'short';
	return $vars;
}

add_filter( 'query_vars', 'wp_classic_query_vars', 10, 1 );

// Redirect the shortlink
function wp_classic_shortlink_redirect() {
	// bail if this isn't a short link
	if( ! get_query_var( 'short' ) ) return;
	global $wp_query;

	$id = absint( get_query_var( 'short' ) );
	if( ! $id )
	{
		$wp_query->is_404 = true;
		return;
	}

	$link = get_permalink( $id );
	if( ! $link )
	{
		$wp_query->is_404 = true;
		return;
	}

	wp_redirect( esc_url( $link ), 301 );
	exit();
}

add_action( 'template_redirect', 'wp_classic_shortlink_redirect' );

// Get the shortlink
function wp_classic_get_shortlink( $link, $id, $context ) {
	if( 'query' == $context && is_singular() )
	{
		$id = get_queried_object_id();
	}
	return home_url( 'p/' . $id );
}

add_filter( 'get_shortlink', 'wp_classic_get_shortlink', 10, 3 );

add_action( 'admin_bar_menu', 'wp_admin_bar_shortlink_menu',90 );
?>