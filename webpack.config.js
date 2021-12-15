const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require("path");

module.exports = [
	{
		...defaultConfig,
		plugins: [
			...defaultConfig.plugins.filter(
				(plugin) => plugin.constructor.name !== "CleanWebpackPlugin"
			),
		],
	},
	{
		entry: {
			frontend: path.resolve(__dirname, "./src/frontend.js"),
		},
		mode: "development",
		module: {
			rules: [
				{
					test: /\.(js|jsx)$/,
					exclude: /node_modules/,
					use: ["babel-loader"],
				},
			],
		},
		resolve: {
			extensions: ["*", ".js", ".jsx"],
		},
		output: {
			filename: "[name].js",
			chunkFilename: "[name].chunk.js",
			path: path.resolve(__dirname, "./build/"),
			publicPath:
				"http://blockshydration.local/wp-content/plugins/gutenberg-server-components/build/",
		},
	},
];
