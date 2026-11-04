<?php
    get_header();

    while(have_posts()) {
        the_post(); 

        pageBanner();
?>

<div class="container container--narrow page-section">
    <div class="generic-content">
        <div class="row group">
            <div class="one-third">
                <?php the_post_thumbnail("professorPortrait"); ?>
            </div>
            <div class="two-thirds">
                <?php
                    $likeCount = new WP_Query([
                        "post_type" => "like",
                        "meta_query" => [
                            [
                                "key" => "liked_professor_id",
                                "compare" => "=",
                                "value" => get_the_ID(),
                            ],
                        ],
                    ]);

                    $likedStatus = false;

                    if(is_user_logged_in()) {
                        $userLiked = new WP_Query([
                            "author" => get_current_user_id(),
                            "post_type" => "like",
                            "meta_query" => [
                                [
                                    "key" => "liked_professor_id",
                                    "compare" => "=",
                                    "value" => get_the_ID(),
                                ],
                            ],
                        ]);

                        if($userLiked->found_posts) {
                            $likedStatus = true;
                        }
                    }


                ?>
                <span class="like-box" data-like="<?php echo is_user_logged_in() ? $userLiked->posts[0]->ID : null; ?>" data-professor="<?php the_ID(); ?>" data-exists="<?php echo $likedStatus ? "yes" : "no"; ?>">
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    <span class="like-count"><?php echo $likeCount->found_posts; ?></span>
                </span>

                <?php the_content(); ?>
            </div>
        </div>
    </div>
    
    <?php
        $relatedPrograms = get_field("related_programs");

        if($relatedPrograms) {
    ?>
        <hr class="section-break">
        <h2 class="headline headline--medium">Subject(s) taught</h2>
        <ul class="link-list min-list">
    <?php
            foreach($relatedPrograms as $relatedProgram) {
                ?>
                    <li><a href="<?= get_the_permalink($relatedProgram); ?>"><?= get_the_title($relatedProgram); ?></a></li>
                <?php
            }
        }
    ?>
        </ul>
</div>


    <?php
    }
    get_footer();
?>
