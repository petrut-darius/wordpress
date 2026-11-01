<?php

require get_theme_file_path("/inc/search-route.php");

function universityCustomRest() {
    register_rest_field("post", "authorName", [
        "get_callback" => fn() => get_the_author(),
    ]);
}

add_action("rest_api_init", "universityCustomRest");

function pageBanner(array|null $data = null) {
    if(!$data["photo"]) {
        if(get_field("page_banner_background_image")) {
            $data["photo"] = get_field("page_banner_background_image")["sizes"]["pageBanner"];
        } else {
            $data["photo"] = get_theme_file_uri("/images/ocean.jpg");
        }
    }
?>

    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $data["photo"] ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo ($data["title"]) ? $data["title"] : the_title(); ?></h1>
                <div class="page-banner__intro">
                    <p><?php echo ($data["subtitle"]) ? $data["subtitle"] : the_field("page_banner_subtitle"); ?></p>
                </div>
        </div>
    </div>

<?php
}

function universityFiles() {
    wp_enqueue_script("googleMap", "//maps.googleapis.com/maps/api/js?key=" . GOOGLE_APY_KEY , [], "1.0", true);
    wp_enqueue_script("main-university-js", get_theme_file_uri("/build/index.js"), ["jquery", "googleMap"], "1.0", true);
    wp_enqueue_style("university_main_styles", get_theme_file_uri("/build/style-index.css"));
    //wp_enqueue_style("university_extra_styles", get_theme_file_uri("/build/index.css"));
    wp_enqueue_style("font-awesome", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style("custom-google-fonts", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");

    wp_localize_script("main-university-js", "universityData", [
        "root_url" => get_site_url(),
        "nonce" => wp_create_nonce("wp_rest"),
    ]);

}

add_action("wp_enqueue_scripts", "universityFiles");

function universityFeatures() {
    register_nav_menu("headerMenuLocation", "Header Menu Location");
    register_nav_menu("footerMenuLocation1", "Footer Left Menu Location");
    register_nav_menu("footerMenuLocation2", "Footer Right  Menu Location");
    add_theme_support("title-tag");
    add_theme_support("post-thumbnails");
    add_image_size("professorLandscape", 400, 260, true);
    add_image_size("professorPortrait", 480, 650, true);
    add_image_size("pageBanner", 1500, 350, true);
}

add_action("after_setup_theme", "universityFeatures");

function universityAdjustQueries($query) {
    if(!is_admin() && is_post_type_archive("campus") && $query->is_main_query()) {
        $query->set("posts_per_page", -1);
    }

    if(!is_admin() && is_post_type_archive("program") && $query->is_main_query()) {
        $query->set("posts_per_page", -1);
        $query->set("orderby", "title");
        $query->set("order", "ASC");
    }

    if(!is_admin() && is_post_type_archive("event") && $query->is_main_query()) {
        $today = date("Ymd");

        $query->set("meta_key", "event_date");
        $query->set("orderby", "meta_value_num");
        $query->set("order", "ASC");
        $query->set("meta_query", [
                                    [
                                        "key" => "event_date",
                                        "compare" => ">=",
                                        "value" => $today,
                                        "type" => "numeric",
                                    ],
                                ]);
    }
}

add_action("pre_get_posts", "universityAdjustQueries");

function universityMapKey($api) {
    $api["key"] = "AIzaSyBKdR-7QQzb2LWPYL8ynJGmAQO62LbEy0A";
    return $api;
}

add_filter("acf/fields/google_map/api", "universityMapKey");

function redirectSubsToFrontend() {
    $ourCurrentUser = wp_get_current_user();

    if(count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] === "subscriber") {
        wp_redirect(site_url("/"));
        exit;
    }
}

add_action("admin_init", "redirectSubsToFrontend");

function noSubsAdminBar() {
    $ourCurrentUser = wp_get_current_user();

    if(count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] === "subscriber") {
        show_admin_bar(false);
    }
}

add_action("wp_loaded", "noSubsAdminBar");

//Customize Login Screen
function ourHeaderUrl() {
    return esc_url(home_url());
}

add_filter("login_headerurl", "ourHeaderUrl");

function ourLoginCSS() {
    wp_enqueue_style("university_main_styles", get_theme_file_uri("/build/style-index.css"));
    //wp_enqueue_style("university_extra_styles", get_theme_file_uri("/build/index.css"));
    wp_enqueue_style("font-awesome", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style("custom-google-fonts", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
}

add_action("login_enqueue_scripts", "ourLoginCSS");

function ourLoginTitle() {
    return get_bloginfo("name");
}

add_filter("login_headertitle", "ourLoginTitle");
