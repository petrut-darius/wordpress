<div class="flex">
  <div class="w-full">
    <div class="m-0">
      <h2 class="">Upcoming Events</h2>
      <?php
        $today = date("Ymd");

        $last2Events = new WP_Query(["post_type" => "event",
                                      "posts_per_page" => 2,
                                      "meta_key" => "event_date",
                                      "orderby" => "meta_value_num",
                                      "order" => "ASC",
                                      "meta_query" => [
                                        [
                                          "key" => "event_date",
                                          "compare" => ">=",
                                          "value" => $today,
                                          "type" => "numeric",
                                        ],
                                      ],
                                    ]);

        while($last2Events->have_posts()) {
          $last2Events->the_post();

          get_template_part("template-parts/content", "event");

          wp_reset_postdata();
        } 
      ?>

      <p class="t-center no-margin"><a href="<?= get_post_type_archive_link("event"); ?>" class="btn btn--blue">View All Events</a></p>
    </div>
  </div>
  <div class="w-full">
    <div class="m-0">
      <h2 class="">From Our Blog</h2>
      <?php
        $last2Posts = new WP_Query(["posts_per_page" => 2]);

        while($last2Posts->have_posts()) {
          $last2Posts->the_post();
          
      ?>
      <div class="event-summary">
        <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
          <span class="event-summary__month"><?php the_time("M"); ?></span>
          <span class="event-summary__day"><?php the_time("d"); ?></span>
        </a>
        <div class="event-summary__content">
          <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?= the_title(); ?></a></h5>
          <p><?= has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 18); ?><a href="<?php the_permalink(); ?>" class="nu gray">&nbsp;Read more</a></p>
        </div>
      </div>
      <?php
        wp_reset_postdata();
        }
      ?>

      <p class="t-center no-margin"><a href="<?= site_url("/blog"); ?>" class="btn btn--yellow">View All Blog Posts</a></p>
    </div>
  </div>
</div>