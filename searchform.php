<form action="/" method="get">
  <label for="search">Search in <?php echo home_url('/'); ?></label>
  <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" />
  <input type="submit" />
</form>