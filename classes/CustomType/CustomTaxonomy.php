<?php

namespace EveryFlavourBeans\Classes\CustomType;

class CustomTaxonomy
{

  /**
   * @param string $name
   * @param array|string $objectType
   * @param array|string $args
   */
  public function register($name, $objectType, $args = []): void
  {
    add_action('init', function () use ($name, $objectType, $args) {
      register_taxonomy($name, $objectType, $args);
    });
  }
}