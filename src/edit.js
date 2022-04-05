import { __ } from "@wordpress/i18n";
import ServerSideRender from "@wordpress/server-side-render";

export default function Edit() {
	return (
		<ServerSideRender
			block="michal/gutenberg-server-components"
			attributes={{
				showPostCounts: true,
				displayAsDropdown: false,
			}}
		/>
	);
}
