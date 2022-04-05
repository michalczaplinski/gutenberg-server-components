import { registerBlockType } from "@wordpress/blocks";

import Edit from "./edit";
import save from "./save";

registerBlockType("michal/gutenberg-server-components", {
	edit: Edit,
	save,
	title: "Gutenberg Server Components",
});
