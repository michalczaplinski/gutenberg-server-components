## React Server Components in Gutenberg

### Usage

Set your `publicPath` in the `webapack.config.js` to the full path of your WP public directory. I'm using
Local so my path for example would be: `http://blockshydration.local/wp-content/plugins/gutenberg-server-components/build/`

### Notes

- This would need a much more solid integration with bundling to be actually
  usable:
  - You have to import the client components in the `frontend.js` so that they
    are code-split into separate chunks
  - The server-side code needs to know the filenames and paths of your chunks so
    that the server components can load the client components (if there are any)
