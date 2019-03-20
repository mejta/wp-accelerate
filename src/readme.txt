=== WordPress Accelerate ===
Contributors: mejta
Donate link: https://www.mejta.net/
Tags: optimization, lazyloading
Requires at least: 4.1
Tested up to: 5.1
Requires PHP: 5.6
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This no-config plugin makes WordPress website more performant with deferring JavaScripts and lazy-loading of images and iframes. The plugin run optimizations only if no user is logged in.

== Description ==

This straightforward plugin makes WordPress website more performant with the following techniques:

- Lazyload for images and iframes
- Adding defer attribute to script tags

## Contribution

Feel free to improve the plugin and open pull request in the [Github repository](https://github.com/mejta/wp-accelerate).

## Development

You need to have node.js and yarn installed.

1. Clone repository `git clone git@github.com:mejta/wp-accelerate.git`.
1. Run `yarn` and `yarn start` command.
1. To build run `yarn build` command.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wp-accelerate` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.
1. Profit!

== Changelog ==

= 1.0 =
* Initial release
