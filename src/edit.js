import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";

export default function Edit() {
	return (
		<p {...useBlockProps()}>
			{__(
				"Gutenberg Server Components – hello from the editor!",
				"gutenberg-server-components"
			)}
		</p>
	);
}
