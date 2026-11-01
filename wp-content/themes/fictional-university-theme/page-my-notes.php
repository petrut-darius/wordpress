<?php

  if(!is_user_logged_in()) {
    wp_redirect(esc_url(home_url()));
    exit;
  }

  get_header();

  while(have_posts()) {
    the_post(); 

    pageBanner([
              "title" => get_the_title() ? get_the_title() : "Hello there this is the title",
              "subtitle" => "Hi this is the subtitle",
              "photo" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrnqTSUK-dLCnZ6O92YfZ1eZKJ1HTWXeXcS17zTngnuQ&s=10",
            ]);

?>
    <div class="container container--narrow page-section">
        <div class="create-note">
            <h2 class="headline headline--medium">Create new note</h2>
            <input class="new-note-title" type="text" placeholder="Title...">
            <textarea class="new-note-body" name="" id="" placeholder="Your new note here..."></textarea>
            <button class="submit-note" type="submit">Create note</button>
        </div>


        <ul class="min-list link-list" id="my-notes">
            <?php 
                $userNotes = new WP_Query([
                    "post_type" => "note",
                    "posts_per_page" => -1,
                    "author" => get_current_user_id(),
                ]);

                while($userNotes->have_posts()) {
                    $userNotes->the_post();
            ?>

            <li data-id="<?php the_ID(); ?>" data-state="cancel">
                <input class="note-title-field" readonly value="<?php echo esc_attr(wp_strip_all_tags(get_the_title())); ?>">
                <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
                <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
                <textarea class="note-body-field" readonly><?php echo esc_textarea(wp_strip_all_tags(get_the_content())); ?></textarea>
                <button class="update-note btn btn--blue btn--small" type="submit" aria-hidden="true">Save</button>
            </li>


            <?php
                }
            ?>
        </ul>
    </div>
<?php }

  get_footer();

?>