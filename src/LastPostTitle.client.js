import React from "react";

import { useRefresh } from "./Cache.client";

const LastPostTitle = ({ title }) => {
	const refresh = useRefresh();
	return (
		<div>
			<div>The title of most recently updated post is:</div>
			<div>
				<b>{title}</b>
			</div>
			<button onClick={() => refresh()}> Reload </button>
		</div>
	);
};

export default LastPostTitle;
