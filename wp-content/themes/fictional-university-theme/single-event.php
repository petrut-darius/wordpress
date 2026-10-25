<?php
    get_header();

    while(have_posts()) {
        the_post();
        
        pageBanner();
?>

<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?= get_post_type_archive_link("event") ?>"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;Events home</a> <span class="metabox__main">Posted by <?php the_author_posts_link(); ?> on <?php the_time("F d H:m Y"); ?> in <?= get_the_category_list(", "); ?></span></p>
    </div>

    <div class="generic-content">
        <?php the_content();?>
    </div>
    
    <?php
        $relatedPrograms = get_field("related_programs");

        if($relatedPrograms) {
    ?>
        <hr class="section-break">
        <h2 class="headline headline--medium">Related program(s)</h2>
        <ul class="link-list min-list">
    <?php
            foreach($relatedPrograms as $relatedProgram) {
                ?>
                    <li><a href="<?= get_the_permalink($relatedProgram) ?>"><?= get_the_title($relatedProgram); ?></a></li>
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
