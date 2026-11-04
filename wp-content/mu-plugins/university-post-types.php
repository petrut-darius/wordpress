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
        "capability_type" => "event",
        "map_meta_cap" => true
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
        "supports" => ["title"],
        "show_in_rest" => true,//modern block create or edit view
        "capability_type" => "program",
        "map_meta_cap" => true
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
        "capability_type" => "professor",
        "map_meta_cap" => true
    ]);

    //Campus post type
    register_post_type("campus", [
        "public" => true,
        "labels" => [
            "name" => "Campuses",
            "add_new_item" => "Add new campus",
            "edit_item" => "Edit campus",
            "all_items" => "All campuses",
            "singular_name" => "Campus",
        ],
        "menu_icon" => "dashicons-location-alt",
        "has_archive" => true,
        "rewrite" => [
            "slug" => "campuses",
        ],
        "supports" => ["title", "editor", "excerpt"],
        "show_in_rest" => true,//modern block create or edit view
        "capability_type" => "campus",
        "map_meta_cap" => true
    ]);


    //Note post type
    register_post_type("note", [
        "public" => false,//private & specific to each user account
        "labels" => [
            "name" => "Notes",
            "add_new_item" => "Add new note",
            "edit_item" => "Edit note",
            "all_items" => "All notes",
            "singular_name" => "Note",
        ],
        "menu_icon" => "dashicons-welcome-write-blog",
        "supports" => ["title", "editor"],
        "show_in_rest" => true,//modern block create or edit view
        "show_ui" => true,
        'capability_type' => "note",
        "map_meta_cap" => true,
    ]);

    //Like post type
    register_post_type("like", [
        "public" => false,
        "labels" => [
            "name" => "Likes",
            "add_new_item" => "Add new like",
            "edit_item" => "Edit like",
            "all_items" => "All likes",
            "singular_name" => "like",
        ],
        "menu_icon" => "dashicons-heart",
        "has_archive" => true,
        "rewrite" => [
            "slug" => "likes",
        ],
        "supports" => ["title"],
        "show_ui" => true,
    ]);
}

add_action("init", "universityPostTypes");