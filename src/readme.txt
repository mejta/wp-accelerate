=== WordPress Accelerate ===
Contributors: mejta
Donate link: https://www.mejta.net/
Tags: optimization, lazyloading
Requires at least: 4.1
Tested up to: 5.3
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

= 1.2.5 =
* Added filter for content `wp_accelerate_content`

= 1.2.4 =
* Added support for lazyloaded background images with `style="background-image: url(...)"`

= 1.2.3 =
* Added support for wp_accelerate_lazyload, wp_accelerate_defer and wp_accelerate_no_defer filters

= 1.2.0 =
* Added support for lazyloading of `<picture>`, `<video>` and `<audio>` elements

= 1.1.0 =
* Add wp_accelerate_lazyload filter

= 1.0.2 =
* Apply lazy-loading only when on front-end and when not doing ajax, etc.

= 1.0 =
* Initial release
