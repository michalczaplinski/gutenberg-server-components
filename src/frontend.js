import React, { Suspense, lazy } from "react";
import ReactDOM from "react-dom";

import { useServerResponse } from "./Cache.client";

// You have to import all the client components that are used inside of a server
// component so that webpack can code-split them into separate chunks.
lazy(import("./Message.client"));
lazy(import("./OtherMessage.client"));

const Message = (props) => {
	const response = useServerResponse(props);
	return response.readRoot();
};

window.addEventListener("DOMContentLoaded", () => {
	const element = document.querySelector("#hydrate-block");
	if (element) {
		const root = ReactDOM.createRoot(element);
		root.render(
			<Suspense fallback={<div className="wp-block-placeholder" />}>
				<>
					<h2>Server Components in Gutenberg</h2>
					<Message name="World" />
				</>
			</Suspense>
		);
	}
});
