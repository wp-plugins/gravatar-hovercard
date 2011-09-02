<?php
/*
Plugin Name: Gravatar Hovercards
Plugin URI: http://www.itsabhik.com/wp-plugins/gravatar-hovercards-wordpress-plugin.html
Description: Gravatar Hovercards plugin shows the commentator's profile information from their Gravatar profile when someone hover the cursor on that commentator's gravatar in a WordPress blog.
Version: 1.5
Author: Abhik
Author URI: http://www.itsabhik.com
License: GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/
?>
<?php
define( 'GROFILES__CACHE_BUSTER', 'w' );

function grofiles_attach_cards() {
	global $blog_id;
	
	if ( 'disabled' == get_option( 'gravatar_disable_hovercards' ) )
		return;

	wp_enqueue_script( 'hovercards', ( is_ssl() ? 'https://secure' : 'http://s' ) . '.gravatar.com/js/gprofiles.js?' . GROFILES__CACHE_BUSTER, array( 'jquery' ) );
	wp_enqueue_script( 'wpgroho', plugins_url( 'wpgroho.js', __FILE__ ), array( 'hovercards' ) );
	if ( is_user_logged_in() ) {
		$cu = wp_get_current_user();
		$my_hash = md5( $cu->user_email );
	} else if ( !empty( $_COOKIE['comment_author_email_' . COOKIEHASH] ) ) {
		$my_hash = md5( $_COOKIE['comment_author_email_' . COOKIEHASH] );
	} else {
		$my_hash = '';
	}
	wp_localize_script( 'wpgroho', 'WPGroHo', compact( 'my_hash' ) );
	wp_print_scripts( 'wpgroho' );
}
add_action( 'wp_footer',  'grofiles_attach_cards' );
?>