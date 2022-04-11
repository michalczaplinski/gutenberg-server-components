<?php
use function ServerComponents\LastPostTitle as LastPostTitle;

function Root( $props ) {

	$author = $props->author;

	return <<<HTML
		<div>
			{LastPostTitle($author)}
		</div>
	HTML;
}
