<div class="flex items-start gap-4 mb-5">
    <a class="no-underline flex flex-col items-center justify-center w-[80px] h-[80px] shrink-0 rounded-full leading-tight" href="<?php the_permalink(); ?>">
        <span class="block text-3xl font-bold text-black uppercase"><?php
                                            $eventDate = new DateTime(get_field("event_date"));
                                            echo $eventDate->format("M");
                                            ?>
        </span>
        <span class="block text-2xl font-bold text-black"><?php echo $eventDate->format("d"); ?></span>
    </a>
    
    <div class="block">
        <h5 class="m-0"><a class="no-underline text-black text-xl font-bold hover:text-white hover:bg-black hover:px-2 hover:py-1 hover:rounded transition-all" href="<?php the_permalink(); ?>"><?= the_title(); ?></a></h5>
        <p class="m-0 text-gray-600"><?= has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 18); ?><a href="<?php the_permalink(); ?>" class="text-gray-400 no-underline">&nbsp;Learn more</a></p>
    </div>
</div>