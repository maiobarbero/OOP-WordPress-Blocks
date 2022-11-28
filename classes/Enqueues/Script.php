<?php

namespace EveryFlavourBeans\Classes\Enqueues;

class Script
{
  public function __construct()
  {
    add_action('comment_form_before', [$this, 'comment']);
  }

  private function enqueue($function): void
  {
    add_action('wp_enqueue_scripts', function () use ($function) {
      $function();
    });
  }
  private function comment()
  {
    if (
      get_option('thread_comments')
    ) {
      wp_enqueue_script('comment-reply');
    }
  }

  /**
   * @param string $name
   * @param string $src
   * @param string|array $deps
   * @param string|bool|null $ver
   * @param bool $in_footer
   */
  public function addScript($name, $src = '', $deps = [], $ver = false, $in_footer = false): self
  {
    $this->enqueue(function () use ($name, $src, $deps, $ver, $in_footer) {
      wp_enqueue_script($name, $src, $deps, $ver, $in_footer);
    });
    return $this;
  }

  /**
   * @param string $name
   * @param string $src
   * @param string|array $deps
   * @param string|bool|null $ver
   * @param string $media
   */
  public function addStyle($name, $src = '', $deps = [], $ver = false, $media = 'all'): self
  {
    $this->enqueue(function () use ($name, $src, $deps, $ver, $media) {
      wp_enqueue_style($name, $src, $deps, $ver, $media);
    });
    return $this;
  }
}