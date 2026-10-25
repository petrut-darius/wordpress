<?php
function universityPostTypes() {
    //Event post type
    register_post_type("event", [
        "public" => true,
        "labels" => [
            "name" => "Events",
            "add_new_item" => "Add new event",
            "edit_item" => "Edit event",
            "all_items" => "All events",
            "singular_name" => "Event",
        ],
        "menu_icon" => "dashicons-sticky",
        "has_archive" => true,
        "rewrite" => [
            "slug" => "events",
        ],
        "supports" => ["title", "editor", "excerpt"],
        "show_in_rest" => true,//modern block create or edit view
    ]);

    //Program post type
    register_post_type("program", [
        "public" => true,
        "labels" => [
            "name" => "Programs",
            "add_new_item" => "Add new program",
            "edit_item" => "Edit program",
            "all_items" => "All programs",
            "singular_name" => "Program",
        ],
        "menu_icon" => "dashicons-awards",
        "has_archive" => true,
        "rewrite" => [
            "slug" => "programs",
        ],
        "supports" => ["title", "editor"],
        "show_in_rest" => true,//modern block create or edit view
    ]);

    //Professor post type
    register_post_type("professor", [
        "public" => true,
        "labels" => [
            "name" => "Professors",
            "add_new_item" => "Add new professor",
            "edit_item" => "Edit professor",
            "all_items" => "All professors",
            "singular_name" => "Professor",
        ],
        "menu_icon" => "dashicons-welcome-learn-more",
        "supports" => ["title", "editor", "thumbnail"],
        "show_in_rest" => true,//modern block create or edit view
    ]);
}

add_action("init", "universityPostTypes");