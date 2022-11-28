<?php

namespace EveryFlavourBeans\Classes\CustomType;

class CustomPost
{


  /**
   * @param string $name
   * @param array $args|string
   */
  public function register($name, $args = []): void
  {
    add_action('init', function () use ($name, $args) {
      register_post_type($name, $args);
    });
  }
}