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
	$script_url = plugins_url( $script_path, __FILE__ );
	wp_enqueue_script( 'script', $script_url );
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


// The server component

add_action( 'init', 'create_block_gutenberg_server_components_block_init' );

function gutenberg_server_component_callback( $request ) {

	$props = json_decode(stripcslashes($_GET['props']));

	// Query Arguments
	$lastupdated_args = array(
	'orderby' => 'modified',
	'order' => 'DESC',
	'post_status' => 'any',
	);

	$lastupdated = new WP_Query( $lastupdated_args );
	$lastupdated->the_post();
	$title = get_the_title( $lastupdated->post->ID );

  $data = <<<STR
J0:["$","div",null,{"children":[["$", "@2", null, {"value": "$props->name"}], ["$", "@3", null, {"title": "$title"}]]}]
STR . chr(0x0A);

  $data .= 'M2:{"id":"./src/block/Message.client.js","chunks":["src_block_Message_client_js"],"name":""}' . chr(0x0A);
  $data .= 'M3:{"id":"./src/block/LastPostTitle.client.js","chunks":["src_block_LastPostTitle_client_js"],"name":""}'. chr(0x0A);
	
	header("Content-Type: text/plain");
	header("Status: 200");
	echo $data;

}

// FRAMEWORK

add_action( 'rest_api_init', function () {
  register_rest_route( 'gutenberg-server-components/v1', '/server-component', array(
    'methods' => 'GET',
    'callback' => 'gutenberg_server_component_callback',
		'args' => array(
      'props' => array(
				'validate_callback' => function($param, $request, $key) {
          return is_string( $param );
				}
      ),
    ),
  ));
});
