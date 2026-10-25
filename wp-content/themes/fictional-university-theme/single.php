<?php
    get_header();

    while(have_posts()) {
        the_post(); 

        pageBanner();
?>

<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?= site_url("/blog") ?>"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;Events home</a> <span class="metabox__main"><?= the_title();?></span></p>
    </div>

    <div class="generic-content">
        <?php the_content(); ?>
    </div>
</div>


    <?php
    }
?>


<?php
    get_footer();
?>
