<?php
pageBanner();
?>

<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p>
      <a class="metabox__blog-home-link" href="<?= site_url('/blog') ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> <span class="metabox__main"><?= "Posted by " . get_the_author_posts_link() . " on " . get_the_time('n.j.y') . " in " . get_the_category_list(', ') ?></span>
    </p>
  </div>

  <div class="generic-content">
    <?php the_content() ?>
  </div>
</div>