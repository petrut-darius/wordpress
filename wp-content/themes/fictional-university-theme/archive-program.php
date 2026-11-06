<?php
get_header();

pageBanner([
    "title" => "All programs",
    "subtitle" => "See our programs",
]);
?>

<div class="max-w-[960px] mx-auto relative w-full mt-8">
    <ul class="pt-[1rem] pb-[1rem] px-0">
    <?php
        while(have_posts()) {
          the_post();
    ?>
        <li class="list-none text-2xl my-2"><a class="text-black hover:text-gray-500" href="<?php the_permalink() ?>"><?= the_title(); ?></a></li>

    <?php
        }
    ?>
    </ul>
    <?php

        echo paginate_links();
    ?>
  <hr class="section-break">

  <p>Looking for a recap of past events? <a class="no-underline text-black hover:text-gray-500" href="<?= site_url("/past-events") ?>">Check our past events archive</a></p>
</div>

<?php
get_footer();
?>