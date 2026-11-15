<?php
$about_page = get_page_by_path('about-us');
$is_about   = is_page('about-us') || ($about_page && wp_get_post_parent_id(0) === $about_page->ID);

$li_base     = 'group list-none px-2 py-1 rounded-sm transition-all';
$li_active   = $li_base . ' bg-white';
$li_inactive = $li_base . ' bg-black hover:bg-white';

$a_active    = 'no-underline !text-black';
$a_inactive  = 'no-underline text-white group-hover:text-black';

$auth_btn    = 'no-underline text-white px-2 py-1 border border-transparent rounded-sm cursor-pointer transition-all';
?>

<header>
    <div class="flex items-center justify-evenly bg-black py-3">
        <div class="flex items-center gap-4">
            <h1 class="m-0">
                <a class="text-white no-underline" href="<?php echo esc_url(site_url()); ?>"><strong>PDC</strong> SHOP</a>
            </h1>
            <a href="<?php echo esc_url(site_url('/search')); ?>" class="js-search-trigger site-header__search-trigger text-white">
        <nav>
            <ul class="flex justify-center items-center gap-6 m-0 p-0">
                <li class="<?php echo $is_about ? $li_active : $li_inactive; ?>">
                    <a class="<?php echo $is_about ? $a_active : $a_inactive; ?>" href="<?php echo esc_url(site_url('/about-us')); ?>">About Us</a>
                </li>
                <li class="<?php echo (get_post_type() === 'program') ? $li_active : $li_inactive; ?>">
                    <a class="<?php echo (get_post_type() === 'program') ? $a_active : $a_inactive; ?>" href="<?php echo esc_url(get_post_type_archive_link('program')); ?>">Programs</a>
                </li>
                <li class="<?php echo (get_post_type() === 'event' || is_page('past-events')) ? $li_active : $li_inactive; ?>">
                    <a class="<?php echo (get_post_type() === 'event' || is_page('past-events')) ? $a_active : $a_inactive; ?>" href="<?php echo esc_url(site_url('/events')); ?>">Events</a>
                </li>
                <li class="<?php echo (get_post_type() === 'campus') ? $li_active : $li_inactive; ?>">
                    <a class="<?php echo (get_post_type() === 'campus') ? $a_active : $a_inactive; ?>" href="<?php echo esc_url(get_post_type_archive_link('campus')); ?>">Campuses</a>
                </li>
                <li class="<?php echo (get_post_type() === 'post') ? $li_active : $li_inactive; ?>">
                    <a class="<?php echo (get_post_type() === 'post') ? $a_active : $a_inactive; ?>" href="<?php echo esc_url(site_url('/blog')); ?>">Blog</a>
                </li>
            </ul>
        </nav>

        <div class="flex justify-center items-center gap-4 m-0 p-0">
            <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo esc_url(site_url('/my-notes')); ?>" class="<?php echo $auth_btn; ?> hover:border-white">My Notes</a>
                <a href="<?php echo esc_url(wp_logout_url()); ?>" class="<?php echo $auth_btn; ?> hover:bg-red-500 hover:border-white">Log Out</a>
            <?php else : ?>
                <a href="<?php echo esc_url(wp_login_url()); ?>" class="<?php echo $auth_btn; ?> hover:border-white">Login</a>
                <a href="<?php echo esc_url(wp_registration_url()); ?>" class="<?php echo $auth_btn; ?> hover:border-white">Sign Up</a>
            <?php endif; ?>
            <a href="<?php echo esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger text-white">
                <i class="fa fa-search" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</header>