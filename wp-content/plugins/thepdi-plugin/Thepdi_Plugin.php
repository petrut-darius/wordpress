<?php
/*
    Plugin Name: thepdi_plugin
    Description: First plugin
    Version: 1.0
    Author: Petrut Darius
    //Author URI:
    Text Domain: thepdi_plugin_domain
    Domain Path: /languages
*/

class Thepdi_Plugin
{
    public function __construct()
    {
        add_action("admin_menu", [$this, "adminPage"]);
        add_action("admin_init", [$this, "settings"]);
        add_filter("the_content", [$this, "ifWrap"]);
        add_action("init_action", [$this, "languages"]);
    }

    function languages() {
        load_plugin_textdomain("thepdi_plugin_domain", false, dirname(plugin_basename(__FILE__)) . "/languages");
    }

    function createHTML($content) {
        $html = "<h3>" . esc_html(get_option("thepdi_plugin_headline", "Post Statistics")) .  "</h3><p>";

        if(get_option("thepdi_plugin_word_count", "1") || get_option("thepdi_plugin_read_time", "1")) {
            $wordCount = str_word_count(strip_tags($content));

            if(get_option("thepdi_plugin_word_count", "1")) {
                $html .= __("This post has", "thepdi_plugin_domain") . " " . $wordCount . " " . __("words.", "thepdi_plugin_domain") . "<br>";
            }

            if(get_option("thepdi_plugin_read_time", "1")) {
                $html .= "This post will take about " . round($wordCount/255) . " minute(s).<br>";
            }
        }

        if(get_option("thepdi_plugin_character_count", "1")) {
            $html .= "This post has " . strlen(strip_tags($content)) . " characters.<br>";
        }

        if(get_option("thepdi_plugin_location", "0") == "0") {
            return $html . esc_attr($content);
        }
        return esc_attr($content). $html;
    }

    function ifWrap($content) {
        if(is_main_query() && is_single() && (get_option("thepdi_plugin_word_count", "1") || get_option("thepdi_plugin_character_count", "1") || get_option("thepdi_plugin_read_time", "1"))) {
            return $this->createHTML($content);
        }

        return $content;
    }

    function locationHTML() {?>
        <select name="thepdi_plugin_location">
            <option value="1" <?php selected(get_option("thepdi_plugin_location"), "1"); ?>>End of post</option>
            <option value="0" <?php selected(get_option("thepdi_plugin_location"), "0"); ?>>Begining of post</option>
        </select>
    <?php
    }

    function headlineHTML() {?>
        <input type="text" name="thepdi_plugin_headline" value="<?php echo esc_attr(get_option("thepdi_plugin_headline")); ?>">
    <?php
    }

    function checkboxHTML($arguments) {?>
        <input type="checkbox" name="<?php echo $arguments["theName"] ?>" value="1" <?php checked(get_option($arguments["theName"], "1")); ?>>
    <?php
    }

    function sanitizeLocation($input) {
        if($input !== "0" AND $input !== "1") {
            add_settings_error("thepdi_plugin_location", "thepdi_plugin_location_error", "Display Location must be either begining or end");
            return get_option("thepdi_plugin_location");
        }

        return $input;
    }

    function settings() {
        add_settings_section("thepdi_plugin_first_section", "First Section", "", "thepdi_plugin_settings_page");

        // Location field
        add_settings_field("thepdi_plugin_location", "Display Location", [$this, "locationHTML"], "thepdi_plugin_settings_page", "thepdi_plugin_first_section");
        register_setting( "thepdi_plugin", "thepdi_plugin_location", [
            "sanitize_callback" => [$this, "sanitizeLocation"],
            "default" => "0",
        ]);

        // Headline field
        add_settings_field("thepdi_plugin_headline", "Headline Text", [$this, "headlineHTML"], "thepdi_plugin_settings_page", "thepdi_plugin_first_section");
        register_setting( "thepdi_plugin", "thepdi_plugin_headline", [
            "sanitize_callback" => "sanitize_text_field",
            "default" => "Post Statistics",
        ]);

        // Word Count field
        add_settings_field("thepdi_plugin_word_count", "Word Count", [$this, "checkboxHTML", ], "thepdi_plugin_settings_page", "thepdi_plugin_first_section", [
            "theName" => "thepdi_plugin_word_count",
        ]);
        register_setting( "thepdi_plugin", "thepdi_plugin_word_count", [
            "sanitize_callback" => "sanitize_text_field",
            "default" => "1",
        ]);


        // Character Count field
        add_settings_field("thepdi_plugin_character_count", "Character Count", [$this, "checkboxHTML", ], "thepdi_plugin_settings_page", "thepdi_plugin_first_section", [
            "theName" => "thepdi_plugin_character_count",
        ]);
        register_setting( "thepdi_plugin", "thepdi_plugin_character_count", [
            "sanitize_callback" => "sanitize_text_field",
            "default" => "1",
        ]);


        // Read Time field
        add_settings_field("thepdi_plugin_read_time", "Read Time", [$this, "checkboxHTML", ], "thepdi_plugin_settings_page", "thepdi_plugin_first_section", [
            "theName" => "thepdi_plugin_read_time",
        ]);
        register_setting( "thepdi_plugin", "thepdi_plugin_read_time", [
            "sanitize_callback" => "sanitize_text_field",
            "default" => "1",
        ]);
    }

    function ourHTML() { ?>
        <section class="wrap">
            <h1>Word Count Settings</h1>

            <form action="options.php" method="POST">
                <?php
                    settings_fields("thepdi_plugin");
                    do_settings_sections("thepdi_plugin_settings_page"); 
                    submit_button();
                ?>
            </form>
        </section>
    <?php
    }

    function adminPage() {
        add_options_page("Word Count Settings", __("thepdi_plugin", "thepdi_plugin_domain"), "manage_options", "thepdi_plugin_settings_page", [$this, "ourHTML"]);
    }
}

$thepdiPlugin = new Thepdi_Plugin();