<?php get_header(); ?>

<div class="bg-black pt-[80px] pb-[40px]">
  <div class="" style="background-image: url(<?= get_theme_file_uri("images/library-hero.jpg") ?>)"></div>
  <div class="text-center">
    <h1 class="text-6xl m-0 text-white">Welcome!</h1>
    <h2 class="text-4xl m-0 text-white">We think you&rsquo;ll like it here.</h2>
    <h3 class="text-2xl m-0 text-white">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
    <a href="<?= get_post_type_archive_link("program") ?>" class="block mx-auto w-fit no-underline text-2xl py-2 px-4 bg-white rounded text-black hover:text-4xl hover:py-4 hover:px-6 transition-all">Find Your Major</a>
  </div>
</div>

<div class="flex">
  <div class="w-full">
    <div class="m-0">
      <h2>Upcoming Events</h2>
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

<div class="hero-slider">
  <div data-glide-el="track" class="glide__track">
    <div class="glide__slides">
      <div class="hero-slider__slide" style="background-image: url(<?= get_theme_file_uri("images/bus.jpg") ?>)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Transportation</h2>
            <p class="t-center">All students have free unlimited bus fare.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide" style="background-image: url(<?= get_theme_file_uri("images/apples.jpg") ?>">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">An Apple a Day</h2>
            <p class="t-center">Our dentistry program recommends eating apples.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide" style="background-image: url(<?= get_theme_file_uri("images/bread.jpg") ?>)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Food</h2>
            <p class="t-center">Fictional University offers lunch plans for those in need.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
  </div>
</div>

<?php get_footer(); ?>