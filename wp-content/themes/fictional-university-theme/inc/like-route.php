<?php

function createLike($data) {
    if(!is_user_logged_in()) {
        return "You aren't logged in!";
    }

    if($data["professorId"] < 1) {
        return "Id should be positive > 0.";
    }

    $professorId = sanitize_text_field($data["professorId"]);

    $userLiked = new WP_Query([
        "author" => get_current_user_id(),
        "post_type" => "like",
        "meta_query" => [
            [
                "key" => "liked_professor_id",
                "compare" => "=",
                "value" => $professorId,
            ],
        ],
    ]);

    if($userLiked->found_posts != 0 || get_post_type($professorId) !== "professor") {
        return "You already liked this professor or not a valid professor.";
    }

    return wp_insert_post([
        "post_type" => "like",
        "post_status" => "publish",
        "post_title" => "Our PHP Create Post Test",
        "post_content" => "Hello World!",
        "meta_input" => [
            "liked_professor_id" => $professorId,
        ]
    ]);
}

function deleteLike($data) {
    if(!is_user_logged_in()) {
        return "You aren't logged in!";
    }

    if($data["likeId"] < 1) {
        return "Id should be positive > 0.";
    }

    $likeId = sanitize_text_field($data["likeId"]);

    if(get_current_user_id() != get_post_field("post_author", $likeId) || get_post_type($likeId) != "like") {
        return "You can't delete that.";
    }
    
    wp_delete_post($likeId, true);
    return "Congrats like deleted.";
}

function universityiLikeRoutes() {
    register_rest_route("university/v1", "like", [
        "methods" => "POST",
        "callback" => "createLike",
    ]);

    register_rest_route("university/v1", "like", [
        "methods" => "DELETE",
        "callback" => "deleteLike",
    ]);
}

add_action("rest_api_init", "universityiLikeRoutes");