<?php

  get_header();

  while(have_posts()) {
    the_post(); 

    pageBanner([
              "title" => get_the_title() ? get_the_title() : "Hello there this is the title",
              "subtitle" => "Hi this is the subtitle",
              "photo" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrnqTSUK-dLCnZ6O92YfZ1eZKJ1HTWXeXcS17zTngnuQ&s=10",
            ]);

?>
    <div class="max-w-[960px] mx-auto relative w-full">
    
    <?php
      $theParent = wp_get_post_parent_id(get_the_ID());
      if ($theParent) { ?>
        <div class="mb-8 inline-flex items-center overflow-hidden rounded text-sm">
            <div class="absolute">
                <a href='<?php echo get_permalink($theParent); ?>' class="no-underline text-white bg-black px-4 py-2 rounded-l ">
                    <i class="fa fa-home" aria-hidden="true"></i>&nbsp;About us
                </a>
                <span class="px-4 py-2 rounded-r font-medium bg-gray-500"><?php the_title(); ?></span>
            </div>
        </div>
      <?php }
    ?>
    
    <?php 
    $testArray = get_pages(['child_of' => get_the_ID()]);

    if ($theParent or $testArray) { ?>
    <div class="page-links">
      <h2 class="m-0 text-center pt-[20px] pb-[20px] bg-black"><a class="no-underline text-white" href="<?= get_permalink($theParent); ?>"><?= get_the_title($theParent); ?></a></h2>
      <ul class="min-list">
        <?php
          if ($theParent) {
            $findChildrenOf = $theParent;
          } else {
            $findChildrenOf = get_the_ID();
          }

          wp_list_pages(["walker" => new Wp_About_Us_Walker(), 'title_li' => NULL, 'child_of' => $findChildrenOf, 'sort_column' => 'menu_order']);
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