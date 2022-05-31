<?php
/**
 * Plugin Name:       Gutenberg Server Components
 * Description:       Example block that explores the user of React Server
 * Components in Gutenberg.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Michal Czaplinski
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gutenberg-server-components
 *
 * @package           react-server-components
 */

function load_frontend() {
	$script_path       = 'build/frontend.js';
	$script_url = plugins_url( $script_path, __FILE__ );
	wp_enqueue_script( 'script', $script_url );
}

function render_block_gutenberg_server_components($attributes = []) {
	if ( ! is_admin() ) {
		load_frontend();
	}

	// Query Arguments
	$lastupdated_args = array(
	'orderby' => 'modified',
	'order' => 'DESC',
	'post_status' => 'any',
	'author_name' => $attributes['author'],
	);

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
	$escaped_data_attributes = implode( ' ', $escaped_data_attributes );

	$lastupdated = new WP_Query( $lastupdated_args );
	$lastupdated->the_post();
	$title = get_the_title( $lastupdated->post->ID );

	$return_val = <<<HTML
		<div id=hydrate-block $escaped_data_attributes>
			<div>
				<br />
				<div>
					The title of latest post by {{AuthorInput}} is:
				</div>
				<div>
					<b>$title</b>
				</div>
					{{Reload Button}}
				</div>
			</div>
		HTML;

	return $return_val;
}

function create_block_gutenberg_server_components_block_init() {
	register_block_type( __DIR__, array(
		'render_callback' => 'render_block_gutenberg_server_components'
	) );
}
add_action( 'init', 'create_block_gutenberg_server_components_block_init' );

function gutenberg_server_component_callback( $request ) {

	$props = json_decode(stripcslashes($_GET['props']));
	$author = $props->author;

	// Query Arguments
	$lastupdated_args = array(
	'orderby' => 'modified',
	'order' => 'DESC',
	'post_status' => 'any',
	'author_name' => $author,
	);

	$lastupdated = new WP_Query( $lastupdated_args );
	$lastupdated->the_post();
	$title = get_the_title( $lastupdated->post->ID );

	$M1 = 'M1:{"id":"./src/block/AuthorInput.client.js","chunks":["src_block_AuthorInput_client_js"],"name":""}';
	$M2 = 'M2:{"id":"./src/block/ReloadButton.client.js","chunks":["src_block_ReloadButton_client_js"],"name":""}';
	
	$J0 = <<<STR
	J0:["$","div",null,{"children":[
		["$","br",null,{}],
		["$","div",null,{"children": [
			"The title of latest post by", 
			" ",
			["$","@1",null,{"author": "$author"}],
			" is:"
		]}],
		["$","div",null,{"children":
			["$","b",null,{"children": "$title"}]
		}],
		["$","@2",null,{}]
	]}]
	STR;
	$J0 = preg_replace("/\n+/", "", $J0);

	$data = $M1 . chr(0x0A) . $M2 . chr(0x0A) . $J0 . chr(0x0A);
	header("Content-Type: text/plain");
	header("Status: 200");
	echo $data;

}

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
