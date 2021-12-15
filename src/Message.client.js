import React from "react";

const Client = ({ value }) => (
	<div>
		This is a client component rendered inside of a server component
		{value}
	</div>
);

export default Client;
