import React from "react";
import { useRefresh } from "../framework/Cache.client";

const ReloadButton = () => {
	const refresh = useRefresh();
	return <button onClick={() => refresh()}>Reload</button>;
};

export default ReloadButton;
