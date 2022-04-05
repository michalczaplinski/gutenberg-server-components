<?php
use function ServerComponents\LastPostTitle as LastPostTitle;

function Root( $props ) {
	return <<<HTML
		<div>
			{LastPostTitle()}
		</div>
	HTML;
}
