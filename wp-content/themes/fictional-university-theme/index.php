<?php
get_header();

pageBanner([
  "title" => "Welcome to our blog!",
  "subtitle" => "Keep up with our latest news",
])
?>

<div class="max-w-[960px] mx-auto relative w-full mt-8">
  <?php 
    while(have_posts()) {
      the_post();
  ?>
      <div class="pb-14 border-b border-gray-200">
        <h2 class="text-4xl font-medium"><a class="no-underline text-black hover:!underline transition-all" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

        <div class="inline-block bg-gray-500 text-white pt-[10px] pb-[10px] pl-[15px] pr-[15px] rounded mb-8">
          <p class="text-black">Posted by <strong class="[&>a]:text-black hover:[&>a]:text-white [&>a]:transition-all"><?php the_author_posts_link(); ?></strong> on <?php the_time("F d H:m Y"); ?> in <strong class="[&>a]:text-black hover:[&>a]:text-white [&>a]:transition-all"><?= get_the_category_list(", "); ?></strong></p>
        </div>

        <div class="generic-content">
          <?php the_excerpt(); ?>
          <p><a href="<?php the_permalink(); ?>" class="inline-block cursor-pointer rounded overflow-hidden no-underline py-3 px-6 text-white bg-black hover:text-black hover:bg-white transition-all">Continue reading &raquo;</a></p>
        </div>
      </div>
  <?php
    }

    echo paginate_links();
  ?>
</div>

<?php
get_footer();
?>