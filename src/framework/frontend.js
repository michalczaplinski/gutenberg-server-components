import React, {
	Suspense,
	lazy,
	createContext,
	useContext,
	useState,
} from "react";
import ReactDOM from "react-dom";

import { useServerResponse } from "./Cache.client";

// You have to import all the client components that are used inside of a server
// component so that webpack can code-split them into separate chunks.
lazy(import("../block/ReloadButton.client"));
lazy(import("../block/AuthorInput.client"));

const BlockContext = createContext();
export function useAttributes() {
	return useContext(BlockContext);
}

const App = (props) => {
	const [attributes, setAttributes] = useState(props);

	const response = useServerResponse(attributes);
	return (
		<BlockContext.Provider value={[attributes, setAttributes]}>
			{response.readRoot()}
		</BlockContext.Provider>
	);
};

window.addEventListener("DOMContentLoaded", () => {
	const element = document.querySelector("#hydrate-block");
	const attributes = Object.assign({}, element.dataset);

	if (element) {
		ReactDOM.hydrateRoot(
			element,
			<Suspense fallback={null}>
				<App {...attributes} />
			</Suspense>
		);
	}
});
