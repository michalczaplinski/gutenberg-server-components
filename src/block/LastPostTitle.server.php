<?php
namespace ServerComponents;

// import ReloadButton from "./ReloadButton.client";

function LastPostTitle( $props ) {

	// Query Arguments
	$lastupdated_args = array(
	'orderby' => 'modified',
	'order' => 'DESC',
	'post_status' => 'any',
	);

	$lastupdated = new WP_Query( $lastupdated_args );
	$lastupdated->the_post();
	$title = get_the_title( $lastupdated->post->ID );

	return <<<HTML
		<div>
			<br />
			<div>The title of most recently updated post is:</div>
			<div>
				<b>{$title}</b>
			</div>
			<ReloadButton />
		</div>
	HTML;
}
