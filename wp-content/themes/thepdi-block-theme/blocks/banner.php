<?php

if(!$attributes["imageURL"]) {
    $attributes["imageURL"] = get_theme_file_uri("/images/library-hero.jpg");
}

?>

<div class="bg-black pt-[80px] pb-[40px] relative">
    <div 
        class="absolute inset-0 bg-cover bg-center opacity-80" 
        style="background-image: url('<?php echo $attributes["imageURL"]; ?>')"
    ></div>
    <div class="text-center relative z-10 text-white">
        <?php echo $content; ?>
    </div>
</div>