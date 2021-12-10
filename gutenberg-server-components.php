<?php
/**
 * Plugin Name:       Gutenberg Server Components
 * Description:       Example block written with ESNext standard and JSX support – build step required.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gutenberg-server-components
 *
 * @package           create-block
 */


function load_frontend() {
	$script_path       = 'build/frontend.js';
	$script_asset_path = 'build/frontend.asset.php';
	$script_asset      = require( $script_asset_path );
	$script_url = plugins_url( $script_path, __FILE__ );
	wp_enqueue_script( 'script', $script_url, $script_asset['dependencies'], $script_asset['version'] );
}


function render_block_gutenberg_server_components($attributes = [], $content = '') {
	if ( ! is_admin() ) {
		load_frontend();
	}

	$escaped_data_attributes = [];

	foreach ( $attributes as $key => $value ) {
		if ( is_bool( $value ) ) {
			$value = $value ? 'true' : 'false';
		}

		if ( ! is_scalar( $value ) ) {
			$value = wp_json_encode( $value );
		}

		$escaped_data_attributes[] = 'data-' . esc_attr( strtolower( preg_replace( '/(?<!\ )[A-Z]/', '-$0', $key ) ) ) . '="' . esc_attr($value) . '"';
	}
	
	$return_val = '<div id="hydrate-block"' . implode( ' ', $escaped_data_attributes ) . '>' . trim( $content ) . '</div>' ;
		
	return $return_val;
}


function create_block_gutenberg_server_components_block_init() {
	register_block_type( __DIR__, array(
		'render_callback' => 'render_block_gutenberg_server_components'
	) );
}

add_action( 'init', 'create_block_gutenberg_server_components_block_init' );

