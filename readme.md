# WordPress Accelerate

This very simple plugin makes WordPress website more performant with following techniques:

- Lazyload for images and iframes
- Adding defer attribute to script tag

## Installation

1. Install the plugin from [the official plugin directory](https://wordpress.org/plugins/wp-accelerate/).
1. Activate the plugin.
1. Profit

## Contribution

Feel free to improve the plugin and open pull request.

## Development

You need to have node.js and yarn installed.

1. Clone repository `git clone git@github.com:mejta/wp-accelerate.git`.
1. Install dependencies with `yarn`
1. Start development process with `yarn start --output /some/wp/installation/wp-content/plugins/wp-accelerate` command. It will start a build in watch mode and after every change copies files to folder of your choice - e.g. plugin folder in existing installation. Output parameter must be an absolute path to the folder with plugin.

## Usage

1. Activate the plugin
1. To disable lazyload use filter `wp_accelerate_lazyload`

```php
add_filter('wp_accelerate_lazyload', function($do_lazyload) {
  if (is_cart() || is_checkout() || is_account_page() || is_wc_endpoint_url() || is_ajax()) return false;
  return $do_lazyload;
});
```

## Changelog

### version 1.2

- Added support for lazyloading of `<picture>`, `<video>` and `<audio>` elements

### version 1.1

- Filter `wp_accelerate_lazyload` added

### version 1.0

- Initial version

## Credits

This plugin was created after training by [Martin Michálek](https://www.vzhurudolu.cz/lektori/martin-michalek) and his course [Optimization of Load speed](https://www.vzhurudolu.cz/kurzy/rychlost-nacitani).
