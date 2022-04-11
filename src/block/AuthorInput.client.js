import React from "react";
import { useAttributes } from "../framework/frontend";

const AuthorInput = () => {
	const [attributes, setAttributes] = useAttributes();

	return (
		<select
			onChange={(e) => setAttributes({ author: e.target.value })}
			value={attributes.author}
		>
			<option value="admin">admin</option>
			<option value="michal">michal</option>
		</select>
	);
};

export default AuthorInput;
