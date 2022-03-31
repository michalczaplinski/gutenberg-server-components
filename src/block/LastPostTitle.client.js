import React from "react";

import { useRefresh } from "../framework/Cache.client";

const LastPostTitle = ({ title }) => {
	const refresh = useRefresh();
	return (
		<>
			<br />
			<div>The title of most recently updated post is:</div>
			<div>
				<b>{title}</b>
			</div>
			<button onClick={() => refresh()}> Reload </button>
		</>
	);
};

export default LastPostTitle;
