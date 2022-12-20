<?php

/**
 * Plugin Name: CIwebGroup-Plugin
 * Plugin URI: https://www.ciwebgroup.com/ciwebgroup-plugin/
 * Description: Extendify the blocks and template features of Elementor. Also can get lots of new template designes for pages and blocks for Elementor.
 * Version: 1.1.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Anupam Mondal
 * Author URI: https://anupammondal.in/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI: https://www.ciwebgroup.com/update-ciwebgroup-plugin/
 * Text Domain: ciwebgroup-plugin
 * Domain Path: /languages
 */



/**
 * Generate a Delete link based on the homepage url.
 *
 * @param string $content   Existing content.
 *
 * @return string|null
 */

function ciwebgroup_styles() {
    wp_enqueue_style( 'movies',  plugin_dir_url( __FILE__ ) . 'public/css/style.css' );
}

function festiv_wish($festiv) {
	// show the wish only in single post page
	if(is_single() && 'post' == get_post_type()) {
		return $festiv = '<div id="' .'wish-text'. '"><h4 class="' .'text-center'. '">Wishies from Santa 🎅 <br />for Upcoming Xmas 🎄</h4></div>';
	}
  
  return $festiv;
}

function wporg_generate_delete_link($content)
{
	// Run only for single post page.
	if (is_single() && in_the_loop() && is_main_query()) {
		// Add query arguments: action, post.
		$url = add_query_arg(
			[
				'action' => 'wporg_frontend_delete',
				'post'   => get_the_ID(),
			],
			home_url()
		);
		return $content . ' <a class="btn-style" href="' . esc_url($url) . '">' . esc_html__('✘ Delete Post', 'wporg') . '</a>';
	}

	return null;
}


/**
 * Request handler
 */
function wporg_delete_post()
{
	if (isset($_GET['action']) && 'wporg_frontend_delete' === $_GET['action']) {

		// Verify we have a post id.
		$post_id = (isset($_GET['post'])) ? ($_GET['post']) : (null);

		// Verify there is a post with such a number.
		$post = get_post((int) $post_id);
		if (empty($post)) {
			return;
		}

		// Delete the post.
		wp_trash_post($post_id);

		// Redirect to admin page.
		$redirect = admin_url('edit.php');
		wp_safe_redirect($redirect);

		// We are done.
		die;
	}
}

add_action( 'wp_enqueue_scripts', 'ciwebgroup_styles' );
// add_filter('the_content', 'wporg_generate_delete_link');
// add_action('init', 'wporg_delete_post');
add_filter('the_content', 'festiv_wish');