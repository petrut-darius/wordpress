<?php

  get_header();

  while(have_posts()) {
    the_post(); 

    pageBanner([
              "title" => "Hello there this is the title",
              "subtitle" => "Hi this is the subtitle",
              "photo" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrnqTSUK-dLCnZ6O92YfZ1eZKJ1HTWXeXcS17zTngnuQ&s=10",
            ]);

?>
    <div class="container container--narrow page-section">
    
    <?php
      $theParent = wp_get_post_parent_id(get_the_ID());
      if ($theParent) { ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?= get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?= get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
        </div>
      <?php }
    ?>
    
    <?php 
    $testArray = get_pages(['child_of' => get_the_ID()]);

    if ($theParent or $testArray) { ?>
    <div class="page-links">
      <h2 class="page-links__title"><a href="<?= get_permalink($theParent); ?>"><?= get_the_title($theParent); ?></a></h2>
      <ul class="min-list">
        <?php
          if ($theParent) {
            $findChildrenOf = $theParent;
          } else {
            $findChildrenOf = get_the_ID();
          }

          wp_list_pages(['title_li' => NULL, 'child_of' => $findChildrenOf, 'sort_column' => 'menu_order']);
        ?>
      </ul>
    </div>
    <?php } ?>
    
    <div class="generic-content">
      <?php the_content(); ?>
    </div>
  </div>
<?php }

  get_footer();

?>