## React Server Components in Gutenberg

This is an experiment to see how using React Server Components (RSC) in Gutenberg
might look like.

A typical WordPress site does not have the ability to run node
on the server so the server components have to be written in PHP rather than in
JS.

In this repo, our block is written as a combination of client
(`*.client.js`) and server (`*.server.php`) components. Those would then be
**compiled** to an RSC format by a future compiler (that does not exist yet).
Currently, the compilation is done "by hand" meaning that I've imagined what the
input might look like and shoved the output into the
`gutenberg-server-components.php` file.

### Usage

1. Set the `publicPath` in the `webpack.config.js` to the absolute path of the
   `build` directory.

   I'm using [Local](https://localwp.com/), so my path is:
   `http://gutenbergservercomponents.local/wp-content/plugins/gutenberg-server-components/build/`

2. Symlink the repo in your `wp-content/plugins` directory. Or if you've
   already cloned it inside of your plugins directory, you can skip this step.

3. ```
    npm install && npm start
   ```

4. Activate the plugin, open the editor and create a new post and add the "Gutenberg Server Components" block.
