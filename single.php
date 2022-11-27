<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post();

    get_template_part('/templates/template-single');

    // If comments are open or we have at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()) :
      comments_template();
    endif;
  endwhile;
else : ?>
<p><?php esc_html_e('Sorry, no posts matched your criteria.', 'slug-theme'); ?></p>
<?php endif;
wp_reset_postdata();
?>

<?php get_footer(); ?>