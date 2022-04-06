<?php
namespace ServerComponents;

import ReloadButton from "./ReloadButton.client";
import AuthorInput from "./AuthorInput.client";

function LastPostTitle( $author ) {

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

	return <<<HTML
		<div>
			<br />
			<div>
				The title of latest post by <AuthorInput author="$author" /> is:
			</div>
			<div>
				<b>{$title}</b>
			</div>
			<ReloadButton />
		</div>
	HTML;
}
