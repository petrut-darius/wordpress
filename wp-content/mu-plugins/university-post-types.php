<?php
function universityPostTypes() {
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
    ]);
}

add_action("init", "universityPostTypes");