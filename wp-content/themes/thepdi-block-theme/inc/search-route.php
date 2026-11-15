<?php

function universitySearchResults($data) {
    $mainQuery = new WP_Query([
        "post_type" => ["post", "page", "professor", "program", "event", "campus"],
        "s" => sanitize_text_field($data["term"]),
    ]);

    $results = [
        "generalInfo" => [],
        "professors" => [],
        "programs" => [],
        "events" => [],
        "campuses" => [],
    ];

    while($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if(get_post_type() === "post" || get_post_type() === "page") {
            array_push($results["generalInfo"], [
                "ID" => get_the_ID(),
                "post_title" => get_the_title(),
                "post_permalink" => get_the_permalink(),
                "post_type" => get_post_type(),
                "author_name" => get_the_author(),
            ]);
        }elseif(get_post_type() === "professor") {
            array_push($results["professors"], [
                "ID" => get_the_ID(),
                "post_title" => get_the_title(),
                "post_permalink" => get_the_permalink(),
                "post_type" => get_post_type(),
                "post_image" => get_the_post_thumbnail_url(0, "professorLandscape"),
            ]);
        }elseif(get_post_type() === "program") {
            $relatedCampuses = get_field("related_campus");

            if($relatedCampuses) {
                foreach($relatedCampuses as $campus) {
                    array_push($results["campuses"], [
                        "post_title" => get_the_title($campus),
                        "post_permalink" => get_the_permalink($campus),
                        "post_type" => get_post_type($campus),
                    ]);
                }
            }

            array_push($results["programs"], [
                "ID" => get_the_ID(),
                "post_title" => get_the_title(),
                "post_permalink" => get_the_permalink(),
                "post_type" => get_post_type(),
            ]);
        }elseif(get_post_type() === "event") {
            $eventDate = new DateTime(get_field("event_date"));
            
            $description = null;
            if(has_excerpt()) {
                $description = get_the_excerpt();
            }else{
                $description = wp_trim_words(get_the_content(), 18);
            }

            array_push($results["events"], [
                "ID" => get_the_ID(),
                "post_title" => get_the_title(),
                "post_permalink" => get_the_permalink(),
                "post_type" => get_post_type(),
                "month" => $eventDate->format("M"),
                "day" => $eventDate->format("d"),
                "description" => $description,
            ]);
        }elseif(get_post_type() === "campus") {
            array_push($results["campuses"], [
                "ID" => get_the_ID(),
                "post_title" => get_the_title(),
                "post_permalink" => get_the_permalink(),
                "post_type" => get_post_type(),
            ]);
        }

    }

    $programsMetaQuery = ["relation" => "OR"];

    foreach($results["programs"] as $program) {
        array_push($programsMetaQuery, [
                "key" => "related_programs",
                "compare" => "LIKE",
                "value" => '"' . $program["ID"] . '"',
        ]);

    }

    if($results["programs"]) {
        $programRelationshipQuery = new WP_Query([
            "post_type" => ["professor", "event"],
            "meta_query" => $programsMetaQuery
        ]);

        while($programRelationshipQuery->have_posts()) {
            $programRelationshipQuery->the_post();
            if(get_post_type() === "professor") {
                array_push($results["professors"], [
                    "ID" => get_the_ID(),
                    "post_title" => get_the_title(),
                    "post_permalink" => get_the_permalink(),
                    "post_type" => get_post_type(),
                    "post_image" => get_the_post_thumbnail_url(0, "professorLandscape"),
                ]);
            }

            if(get_post_type() === "event") {
                $eventDate = new DateTime(get_field("event_date"));
                
                $description = null;
                if(has_excerpt()) {
                    $description = get_the_excerpt();
                }else{
                    $description = wp_trim_words(get_the_content(), 18);
                }

                array_push($results["events"], [
                    "ID" => get_the_ID(),
                    "post_title" => get_the_title(),
                    "post_permalink" => get_the_permalink(),
                    "post_type" => get_post_type(),
                    "month" => $eventDate->format("M"),
                    "day" => $eventDate->format("d"),
                    "description" => $description,
                ]);
            }
        }

        $results["professors"] = array_values(array_unique($results['professors'], SORT_REGULAR));
        $results["events"] = array_values(array_unique($results['events'], SORT_REGULAR));    
    }

    return $results;
}

function universityRegisterSearch() {
    register_rest_route("university/v1", "search", [
        "methods" => WP_REST_Server::READABLE,
        "callback" => "universitySearchResults",
    ]);
}

add_action("rest_api_init", "universityRegisterSearch");