<?php
/*
Plugin Name: WordPress Accelerate
Description: Speed Optimizations for WordPress websites.
Version: x.x.x
Author: Daniel Mejta
Author URI: https://www.mejta.net/
*/

defined( 'ABSPATH' ) || exit;

class WPAccelerate {
  public function __construct() {
    $this->defer_scripts();
    $this->lazyload();
  }

  public function defer_scripts() {
    add_filter('script_loader_tag', function ($tag, $handle) {
      if (!is_user_logged_in() && preg_match('/\sdefer(=["\']defer["\'])?\s/', $tag) !== 1 && $handle !== 'jquery') {
        return str_replace(' src', ' defer src', $tag);
      }

      return $tag;
    }, 10, 2);
  }

  public function lazyload() {
    add_action('wp_enqueue_scripts', function () {
      if (is_user_logged_in()) {
        return;
      }
      
      $folder = plugin_dir_path(__FILE__);

      foreach(glob($folder . '*.js') as $file) {
        $filename = str_replace($folder, '', $file);
        if (preg_match('/(\S+)\.[[:alnum:]]+\.min\.js/', $file, $handle) === 1) {
          $handle = 'wp-accelerate-' . (isset($handle[1]) ? str_replace($folder . 'build/', '', $handle[1]) : 'script');
          wp_enqueue_script($handle, plugins_url($filename, __FILE__), [], null, true);  
        }
      };
    }, 1);

    add_action('init', function () {
      if (!is_user_logged_in()) {
        ob_start(function ($content) {
          if (preg_match_all('/<img[^>]+>/xm', $content, $images)) {
            foreach ($images[0] as $image) {
              preg_match('/width=["\']?(\d+)["\']?/', $image, $width);
              preg_match('/height=["\']?(\d+)["\']?/', $image, $height);
              $width = isset($width[1]) ? $width[1] : 1;
              $height = isset($height[1]) ? $height[1] : 1;
              $placeholder = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 ' . $width . ' ' . $height . '" width="' . $width . '" height="' . $height . '"></svg>');
              $replacement = $image;
              $replacement = preg_replace('/(<img[^>]+)(src=)/xm', '$1src="' . $placeholder . '" data-$2', $replacement);
              $replacement = preg_replace('/(<img[^>]+)(srcset=)/xm', '$1data-$2', $replacement);
              $replacement = '<noscript>' . str_replace('<img', '<img data-lazyload-fallback', $image) . '</noscript>' . $replacement;
              $content = str_replace($image, $replacement, $content);
            }
          };

          $content = preg_replace('/(<iframe[^>]+) (src)/xm', '$1 data-$2', $content);

          return $content;
        });
      }
    });
  }
}

new WPAccelerate();
