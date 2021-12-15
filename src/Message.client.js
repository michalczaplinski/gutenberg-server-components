import React from "react";

const Message = ({ value }) => (
	<div>
		This is a client component rendered inside of a server component: Hello,{" "}
		{value}!
	</div>
);

export default Message;
