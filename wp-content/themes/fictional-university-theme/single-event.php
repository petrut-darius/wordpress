<?php
    get_header();

    while(have_posts()) {
        the_post();
        
        pageBanner();
?>

<div class="max-w-[960px] mx-auto relative w-full">
    <div class="mb-8 inline-flex items-center overflow-hidden rounded text-sm">
        <div class="absolute">
            <a href='<?php echo get_post_type_archive_link("event"); ?>' class="no-underline text-white bg-black px-4 py-2 rounded-l ">
                <i class="fa fa-home" aria-hidden="true"></i>&nbsp;Events home
            </a>
            <span class="px-4 py-2 rounded-r font-medium bg-gray-500">
                Posted by <?php echo get_the_author(); ?>
            </span>
        </div>
    </div>

    <div class="block">
        <?php the_content();?>
    </div>
    
    <?php
        $relatedPrograms = get_field("related_programs");

        if($relatedPrograms) {
    ?>
        <hr class="section-break">
        <h2 class="headline headline--medium">Related program(s)</h2>
        <ul class="pt-[1rem] pb-[1rem] px-0">
    <?php
            foreach($relatedPrograms as $relatedProgram) {
                ?>
                    <li class="list-none text-2xl my-2"><a class="text-black hover:text-gray-500" href="<?= get_the_permalink($relatedProgram) ?>"><?= get_the_title($relatedProgram); ?></a></li>
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
