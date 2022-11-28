<?php

namespace EveryFlavourBeans\Classes\Enqueues;

class CleanUp
{
  public function __construct()
  {
    add_action('init', [$this, 'deregister_heartbeat'], 1);

    add_filter('script_loader_src', [$this, 'remove_script_version'], 15, 1);
    add_filter('style_loader_src', [$this, 'remove_script_version'], 15, 1);

    remove_filter('wp_robots', 'wp_robots_max_image_preview_large');

    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'start_post_rel_link', 10);
    remove_action('wp_head', 'parent_post_rel_link', 10);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

    // REMOVE WP EMOJI
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
  }

  public function remove_script_version($src)
  {
    $parts = explode('?ver', $src);
    return $parts[0];
  }
  public function  deregister_heartbeat()
  {
    global $pagenow;

    if ('post.php' != $pagenow && 'post-new.php' != $pagenow)
      wp_deregister_script('heartbeat');
  }
}