<?
get_header();

the_post(); 
?>
<h2><?php the_title() ?> page not a post.</h2>
<p><?php the_content() ?></p>
<hr>
<?php get_footer() ?>