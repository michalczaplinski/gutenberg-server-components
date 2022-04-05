<?php

function load_frontend() {
	$script_path       = 'build/frontend.js';
	$script_url = plugins_url( $script_path, __FILE__ );
	wp_enqueue_script( 'script', $script_url );
}

function render_block_gutenberg_server_components($attributes = [], $content = '') {
	if ( ! is_admin() ) {
		load_frontend();
	}

	// Query Arguments
	$lastupdated_args = array(
	'orderby' => 'modified',
	'order' => 'DESC',
	'post_status' => 'any',
	);

	$lastupdated = new WP_Query( $lastupdated_args );
	$lastupdated->the_post();
	$title = get_the_title( $lastupdated->post->ID );

	$return_val = <<<HTML
		<div id=hydrate-block >
			<div>
					<br />
					<div>The title of most recently updated post is:</div>
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

	// Query Arguments
	$lastupdated_args = array(
	'orderby' => 'modified',
	'order' => 'DESC',
	'post_status' => 'any',
	);

	$lastupdated = new WP_Query( $lastupdated_args );
	$lastupdated->the_post();
	$title = get_the_title( $lastupdated->post->ID );

	$M1 = <<<STR
	M1:{"id":"./src/block/ReloadButton.client.js","chunks":["src_block_ReloadButton_client_js"],"name":""}
	STR;

	$J0 = <<<STR
	J0:["$","div",null,{"children":[
		["$","br",null,{}],
		["$","div",null,{"children":
			"The title of most recently updated post is:"
		}],
		["$","div",null,{"children":
			["$","b",null,{"children": "$title"}]
		}],
		["$","@1",null,{}]
	]}]
	STR;
	
	$J0 = preg_replace("/\n+/", "", $J0);
	$data = $M1 . chr(0x0A) . $J0 . chr(0x0A);

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
