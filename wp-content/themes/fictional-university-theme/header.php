<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="">
      <div class="flex items-center justify-evenly bg-black">
        <div>
          <h1 class="">
            <a class="text-white no-underline" href="<?= site_url(); ?>"><strong>PDC</strong> SHOP</a>
          </h1>
          <a href="<?php echo esc_url(site_url('/search')); ?>" class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
          <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        </div>
        <nav class="">
          <!--<?php wp_nav_menu(["theme_location" => "headerMenuLocation"]); ?>-->
          <ul class="flex justify-center items-center gap-6 m-0 p-0">
            <li <?php echo (is_page("about-us") || wp_get_post_parent_id(0)) ? 'class="list-none bg-white px-2 py-1 [&>a]:!text-black rounded-sm"' : 'class="list-none bg-black hover:bg-white [&>a]:text-white hover:[&>a]:text-black transition-all hover:px-2 py-1 rounded-sm"'; ?>><a class="no-underline" href="<?= site_url("/about-us"); ?>">About Us</a></li>
            <li <?php echo (get_post_type() === "program") ? 'class="list-none bg-white px-2 py-1 [&>a]:!text-black rounded-sm"' : 'class="list-none bg-black hover:bg-white [&>a]:text-white hover:[&>a]:text-black transition-all hover:px-2 py-1 rounded-sm"'; ?>><a class="no-underline" href="<?= get_post_type_archive_link("program"); ?>">Programs</a></li>
            <li <?php echo (get_post_type() === "event" || is_page("past-events")) ? 'class="list-none bg-white px-2 py-1 [&>a]:!text-black rounded-sm"' : 'class="list-none bg-black hover:bg-white [&>a]:text-white hover:[&>a]:text-black transition-all hover:px-2 py-1 rounded-sm"'; ?>><a class="no-underline" href="<?= site_url("/events"); ?>">Events</a></li>
            <li <?php echo (get_post_type() === "campus" ) ? 'class="list-none bg-white px-2 py-1 [&>a]:!text-black rounded-sm"' : 'class="list-none bg-black hover:bg-white [&>a]:text-white hover:[&>a]:text-black transition-all hover:px-2 py-1 rounded-sm"'; ?>><a class="no-underline" href="<?= get_post_type_archive_link("campus"); ?>">Campuses</a></li>
            <li <?php echo (get_post_type() === "post") ?  'class="list-none bg-white px-2 py-1 [&>a]:!text-black rounded-sm"' : 'class="list-none bg-black hover:bg-white [&>a]:text-white hover:[&>a]:text-black transition-all hover:px-2 py-1 rounded-sm"'; ?>><a class="no-underline" href="<?= site_url("/blog"); ?>">Blog</a></li>
          </ul>
        </nav>

        <div class="flex justify-center items-center gap-6 m-0 p-0">
          <?php 
            if(is_user_logged_in()) {
          ?>
            <a href="<?php echo esc_url(site_url("/my-notes")); ?>" class="no-underline text-white hover:text-white hover:bg-black hover:px-2 hover:py-1 hover:border hover:border-white hover:rounded-sm hover:cursor-pointer transition-all">My Notes</a>
            <a href="<?php echo esc_url(wp_logout_url()); ?></a>" class="no-underline text-white hover:text-white hover:bg-black hover:px-2 hover:py-1 hover:border hover:border-white hover:rounded-sm hover:cursor-pointer transition-all">Log Out</a>
          <?php
            }else{
          ?>
            <a href="<?php echo wp_login_url(); ?>" class="no-underline text-white hover:text-white hover:bg-black hover:px-2 hover:py-1 hover:border hover:border-white hover:rounded-sm hover:cursor-pointer transition-all">Login</a>
            <a href="<?php echo wp_registration_url(); ?>" class="no-underline text-white hover:text-white hover:bg-black hover:px-2 hover:py-1 hover:border hover:border-white hover:rounded-sm hover:cursor-pointer transition-all">Sign Up</a>
          <?php
            }
          ?>
          <a href="<?php echo esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
        </div>
      </div>
    </header>