<?php
get_header();

pageBanner([
    "title" => "All programs",
    "subtitle" => "See our programs",
]);
?>

<div class="container container--narrow page-section">
    <ul class="link-list min-list">
    <?php
        while(have_posts()) {
          the_post();
    ?>
        <li><a href="<?php the_permalink() ?>"><?= the_title(); ?></a></li>

    <?php
        }
    ?>
    </ul>
    <?php

        echo paginate_links();
    ?>
  <hr class="section-break">

  <p>Looking for a recap of past events? <a href="<?= site_url("/past-events") ?>">Check our past events archive</a></p>
</div>

<?php
get_footer();
?>