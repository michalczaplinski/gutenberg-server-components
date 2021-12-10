import { Suspense } from "@wordpress/element";
import Block from "./block";

// hydrate is not exposed in @wordpress/element
import { hydrate } from "react-dom";

window.addEventListener("DOMContentLoaded", () => {
	const element = document.querySelector("#hydrate-block");
	if (element) {
		const props = { ...element.dataset };

		hydrate(
			<Suspense fallback={<div className="wp-block-placeholder" />}>
				<Block {...props} />
			</Suspense>,
			element
		);
	}
});
