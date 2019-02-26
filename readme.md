# WordPress Accelerate

This very simple plugin makes WordPress website more performant with following techniques:

- Lazyload for images and iframes
- Adding defer attribute to script tag

## Installation

1. Clone the repository with `git clone git@github.com:mejta/wp-accelerate.git`.
1. Install dependencies and build the plugin with `yarn` and `yarn build`.
1. Upload the plugin files from `dist/trunk` to the `/wp-content/plugins/wp-accelerate` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.

## Contribution

Feel free to improve the plugin and open pull request.

## Development

You need to have node.js and yarn installed.

1. Clone repository `git clone git@github.com:mejta/wp-accelerate.git`.
1. Install dependencies with `yarn`
1. Start development process with `yarn start --output /some/wp/installation/wp-content/plugins/wp-accelerate` command. It will start a build in watch mode and after every change copies files to folder of your choice - e.g. plugin folder in existing installation. Output parameter must be an absolute path to the folder with plugin.

## Credits

This plugin was created after training by [Martin Michálek](https://www.vzhurudolu.cz/lektori/martin-michalek) and his course [Optimization of Load speed](https://www.vzhurudolu.cz/kurzy/rychlost-nacitani).
