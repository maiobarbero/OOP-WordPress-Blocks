<?php
require_once get_template_directory() . '/vendor/autoload.php';

use EveryFlavourBeans\Classes\Theme;


$theme = new Theme();

$theme->script->addScript('efb', get_template_directory_uri() . '/dist/js/index.js', false, true);
$theme->script->addStyle('efb', get_template_directory_uri() . '/style.css');

$theme->addImageSize('Cover', 1280, 720);
$theme->customPost->register('book', [
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
$theme->customTaxonomy->register('genre', 'book', ['label' => 'Genre']);
$theme->setBlockPath(get_template_directory() . '/templates/blocks');