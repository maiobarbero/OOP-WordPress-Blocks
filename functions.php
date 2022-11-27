<?php
require_once get_template_directory() . '/vendor/autoload.php';

use EveryFlavourBeans\Classes\Theme;


$theme = new Theme();
$theme->addImageSize('Cover', 1280, 720);
$theme->customPost->registerPostType('book', [
  'public' => true,
  'label' => 'Book',
  'supports' => array(
    'title',
    'editor',
    'excerpt',
    'custom-fields',
    'thumbnail',
    'page-attributes'
  ),
]);
$theme->customPost->registerTaxonomy('genre', 'book', ['label' => 'Genre']);
$theme->setBlockPath(get_template_directory() . '/templates/blocks');