<?php

namespace EveryFlavourBeans\Classes;

use EveryFlavourBeans\Classes\CustomPost;

class Theme
{
  private string $blockPath;
  public CustomPost $customPost;

  public function __construct()
  {
    $this->customPost = new CustomPost();

    add_action('after_setup_theme', [$this, 'crb_load']);

    $this->addThemeSupport('title-tag')
      ->addThemeSupport('automatic-feed-links')
      ->addThemeSupport('post-thumbnails')
      ->addThemeSupport('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
      ]);
    $this->loadTextdomain('efb', get_template_directory() . '/languages');
    $this->registerNavMenu('Header', esc_html__('Header', 'efb'));
  }
  private function afterSetup($function): void
  {
    add_action('after_setup_theme', function () use ($function) {
      $function();
    });
  }
  /**
   * @param string $feature
   * @param mixed $args
   */
  public function addThemeSupport($feature, $args = null): self
  {
    $this->afterSetup(function () use ($feature, $args) {
      if ($args) {
        add_theme_support($feature, $args);
      } else {
        add_theme_support($feature);
      }
    });
    return $this;
  }

  /**
   * @param string $name
   * @param int $width
   * @param int $height
   * @param bool|array $crop
   */
  public function addImageSize($name, $width = 0, $height = 0, $crop = false): self
  {
    $this->afterSetup(function () use ($name, $width, $height, $crop) {
      add_image_size($name, $width, $height, $crop);
    });
    return $this;
  }

  /**
   * @param string $name
   */
  public function removeImageSize($name): self
  {
    $this->afterSetup(function () use ($name) {
      remove_image_size($name);
    });
    return $this;
  }

  /**
   * @param string $location
   * @param string $description
   */
  public function registerNavMenu($location, $description): self
  {
    $this->afterSetup(function () use ($location, $description) {
      register_nav_menus(array($location => $description));
    });
    return $this;
  }

  /**
   * @param string $domain
   * @param string $path
   * @param string $locale
   */
  public function loadTextdomain($domain, $path, $locale = null): self
  {
    $this->afterSetup(function () use ($domain, $path, $locale) {
      load_textdomain($domain, $path, $locale);
    });
    return $this;
  }
  function crb_load()
  {
    \Carbon_Fields\Carbon_Fields::boot();
  }

  /**
   * @param string $path
   */
  function setBlockPath($path): void
  {
    $this->blockPath = $path;
    foreach (glob($this->blockPath . '/*.php') as $blockfile) {
      require_once $blockfile;
    }
  }
}