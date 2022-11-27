<?php

namespace EveryFlavourBeans\Classes;

class CustomPost
{


  /**
   * @param string $name
   * @param array $args|string
   */
  public function registerPostType($name, $args = []): void
  {
    add_action('init', function () use ($name, $args) {
      register_post_type($name, $args);
    });
  }
  /**
   * @param string $name
   * @param array|string $objectType
   * @param array|string $args
   */
  public function registerTaxonomy($name, $objectType, $args = []): void
  {
    add_action('init', function () use ($name, $objectType, $args) {
      register_taxonomy($name, $objectType, $args);
    });
  }
}