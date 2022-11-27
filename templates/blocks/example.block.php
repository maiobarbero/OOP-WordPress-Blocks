<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field\Field;

add_action('carbon_fields_register_fields', 'register_text_block');
function register_text_block()
{
  Block::make(__('Test Block'))
    ->add_fields(array(
      Field::make('text', 'heading', __('Block Heading')),
      Field::make('rich_text', 'content', __('Block Content')),
    ))
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
?>

<div class="block">
  <div class="block__heading">
    <h1><?php echo esc_html($fields['heading']); ?></h1>
  </div><!-- /.block__heading -->


  <div class="block__content">
    <?php echo apply_filters('the_content', $fields['content']); ?>
  </div><!-- /.block__content -->
</div><!-- /.block -->

<?php
    });
}