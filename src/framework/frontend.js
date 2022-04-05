import React, { Suspense, lazy } from "react";
import ReactDOM from "react-dom";

import { useServerResponse } from "./Cache.client";

// You have to import all the client components that are used inside of a server
// component so that webpack can code-split them into separate chunks.
lazy(import("../block/ReloadButton.client"));

const App = (props) => {
	const response = useServerResponse(props);
	return response.readRoot();
};

window.addEventListener("DOMContentLoaded", () => {
	const element = document.querySelector("#hydrate-block");
	if (element) {
		ReactDOM.hydrateRoot(
			element,
			<Suspense fallback={null}>
				<App />
			</Suspense>
		);
	}
});
