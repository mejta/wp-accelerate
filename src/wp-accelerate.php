<?php
/*
Plugin Name: WordPress Accelerate
Description: Speed Optimizations for WordPress websites.
Version: x.x.x
Author: Daniel Mejta
Author URI: https://www.mejta.net/
*/

defined('ABSPATH') || exit;

class WPAccelerate {
  public function __construct() {
    $this->defer_scripts();
    $this->lazyload();
  }

  public function defer_scripts() {
    add_filter('script_loader_tag', function ($tag, $handle) {
      $no_defer = apply_filters('wp_accelerate_no_defer', ['jquery-core', 'jquery-migrate']);

      if ($this->should_accelerate() && apply_filters('wp_accelerate_defer', true) && preg_match('/\sdefer(=["\']defer["\'])?\s/', $tag) !== 1 && !in_array($handle, $no_defer)) {
        return str_replace(' src', ' defer src', $tag);
      }

      return $tag;
    }, 10, 2);
  }

  public function should_accelerate() {
    return (
      !wp_doing_ajax() && 
      !wp_doing_cron() && 
      !wp_is_json_request() && 
      !defined('XMLRPC_REQUEST') && 
      !defined('REST_REQUEST') && 
      !is_admin() &&
      !(class_exists('FLBuilderModel') && FLBuilderModel::is_builder_enabled()) // Beaver Builder compatibility
    );
  }

  public function lazyload() {
    add_action('wp_enqueue_scripts', function () {
      if (!($this->should_accelerate() && apply_filters('wp_accelerate_lazyload', true))) {
        return;
      }
      
      $folder = plugin_dir_path(__FILE__);

      foreach(glob($folder . '*.js') as $file) {
        $filename = str_replace($folder, '', $file);
        if (preg_match('/(lazyload)\.[[:alnum:]]+\.min\.js/', $file, $handle) === 1) {
          $handle = 'wp-accelerate-' . (isset($handle[1]) ? str_replace($folder . 'build/', '', $handle[1]) : 'script');
          wp_enqueue_script($handle, plugins_url($filename, __FILE__), [], null, true);  
        }
      };
    }, 1);

    add_action('init', function () {
      if ($this->should_accelerate() && apply_filters('wp_accelerate_lazyload', true)) {
        ob_start(function ($content) {
          if (!$this->should_accelerate()) return $content;

          $content = preg_replace('/(<iframe[^>]+)(src)/xm', '$1data-$2', $content);
          $content = preg_replace('/(<source[^>]+)(src=)/xm', '$1data-$2', $content);
          $content = preg_replace('/(<source[^>]+)(srcset=)/xm', '$1data-$2', $content);
          $content = preg_replace('/(style="[^"]*)(background-image:\s*url\([^\)]+\)\s*;?\s*)([^"]*")/', 'data-$1$2$3 $1$3', $content);

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

          return apply_filters('wp_accelerate_content', $content);
        });
      }
    });
  }
}

new WPAccelerate();
