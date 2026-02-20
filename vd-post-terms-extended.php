<?php
/**
 * Plugin Name:       Post Terms Extended
 * Description:       Extends the Post Terms block to allow the removal of links.
 * Version:           0.1.0
 * Requires at least: 6.8
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       vd-dev
 *
 * @package VdDev
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue Editor scripts.
 */
function vd_dev_enqueue_block_editor_assets() {
	$asset_file = include plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

	wp_enqueue_script(
		'vd-dev-editor-scripts',
		plugin_dir_url( __FILE__ ) . 'build/index.js',
		$asset_file['dependencies'],
		$asset_file['version']
	);

	wp_set_script_translations(
		'vd-dev-editor-scripts',
		'vd-dev'
	);
}
add_action( 'enqueue_block_editor_assets', 'vd_dev_enqueue_block_editor_assets' );



/**
 * Adds a custom 'isLink' attribute to all Post Terms blocks.
 *
 * @param array  $args       The block arguments for the registered block type.
 * @param string $block_type The block type name, including namespace.
 * @return array             The modified block arguments.
 */
function vd_dev_add_attribute_to_post_terms_blocks( $args, $block_type ) {

    // Only add the attribute to Post Terms blocks.
    if ( $block_type === 'core/post-terms' ) {
        if ( ! isset( $args['attributes'] ) ) {
            $args['attributes'] = array();
        }

        $args['attributes']['isLink'] = array(
            'type'    => 'boolean',
            'default' => true,
        );
    }

    return $args;
}
add_filter( 'register_block_type_args', 'vd_dev_add_attribute_to_post_terms_blocks', 10, 2 );

function vd_dev_add_is_link_attribute_to_post_terms_block( $block_content, $block ) {

    $is_link = $block['attrs']['isLink'] ?? true;

    if ( ! $is_link ) {
        // Strip opening <a ...> tags and closing </a> tags, keeping inner content.
        $block_content = preg_replace( '/<a\b[^>]*>(.*?)<\/a>/is', '$1', $block_content );
    }

    return $block_content;
}
add_filter( 'render_block_core/post-terms', 'vd_dev_add_is_link_attribute_to_post_terms_block', 10, 2 );