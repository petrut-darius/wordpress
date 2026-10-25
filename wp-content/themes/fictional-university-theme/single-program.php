<?php
    get_header();

    while(have_posts()) {
        the_post();

        pageBanner();
?>

<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?= get_post_type_archive_link("program"); ?>"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;All programs</a> <span class="metabox__main"><?= the_title(); ?></span></p>
    </div>

    <div class="generic-content">
        <?php the_content();?>
    </div>

    <?php
        $today = date("Ymd");
        $programProfessors = new WP_Query(["post_type" => "professor",
                                      "posts_per_page" => -1,
                                      "orderby" => "title",
                                      "order" => "ASC",
                                      "meta_query" => [
                                        [
                                            "key" => "related_programs",
                                            "compare" => "LIKE",
                                            "value" => '"' . get_the_ID() . '"',
                                        ]
                                      ],
                                    ]);
    
        if($programProfessors->have_posts()) {
            echo "<hr class='section-break'>";
            echo "<h2 class='headline headline--medium'>" . get_the_title() . " Professors</h2>";

            echo "<ul class='professor-cards'>";

            while($programProfessors->have_posts()) {
                $programProfessors->the_post();
    ?>
                <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink(); ?>">
                        <img class="professor-card__image" src="<?php the_post_thumbnail_url("professorLandscape"); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                        <span class="professor-card__name"><?php the_title(); ?></span>
                    </a>
                </li>
    <?php 
                wp_reset_postdata();
            }
            echo "</ul>";
        }

        $programEvents = new WP_Query(["post_type" => "event",
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
                                        [
                                            "key" => "related_programs",
                                            "compare" => "LIKE",
                                            "value" => '"' . get_the_ID() . '"',
                                        ]
                                      ],
                                    ]);
    
        if($programEvents->have_posts()) {
            echo "<hr class='section-break'>";
            echo "<h2 class='headline headline--medium'>Upcoming " . get_the_title() . " Events</h2>";

            while($programEvents->have_posts()) {
                $programEvents->the_post();
                get_template_part("template-parts/content-event");
                wp_reset_postdata();
            }
        }
    ?>
</div>
    <?php
    }
    get_footer();
?>
