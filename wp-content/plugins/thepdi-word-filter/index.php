<?php

/*
    Plugin Name: thepdi word filter
    Description: changes from bad words to symbols
    Version: 1.0
    Author: Petrut Darius
    //Author URI:
*/

if(!defined("ABSPATH")) exit;

class Thepdi_Word_Filter
{
    public function __construct()
    {
        add_action("admin_menu", [$this, "menu"]);
        add_action("admin_init", [$this, "settings"]);
        if(get_option("thepdi_plugin_words_to_filter")) add_filter("the_content", [$this, "filterLogic"], 1);
    }

    function replacementFieldHTML() {?>
        <input type="text" name="thepdi_plugin_replacement_text" value="<?php echo esc_attr(get_option("thepdi_plugin_replacement_text", "***")); ?>">
        <p class="description">Leave blank to simply remove the filtered words.</p>
    <?php
    }

    function settings() {
        add_settings_section("thepdi_plugin_replacement_text_section", null, "", "thepdi_plugin_word_filter_options");
        register_setting("thepdi_plugin_replacement_fields", "thepdi_plugin_replacement_text");
        add_settings_field("thepdi_plugin_replacement_text", "Filtered Text", [$this, "replacementFieldHTML"], "thepdi_plugin_word_filter_options", "thepdi_plugin_replacement_text_section");    
    }

    function optionsHTML() {?>
        <div class="wrap">
            <h1>Thepdi - Word Filter Options</h1>
            <form action="options.php" method="POST">
                <?php
                    settings_errors("thepdi_plugin_replacement_fields");
                    settings_fields("thepdi_plugin_replacement_fields");
                    do_settings_sections("thepdi_plugin_word_filter_options");

                    submit_button();
                ?>
            </form>
        </div>
    <?php
    }

    function handleForm() {
        if(wp_verify_nonce($_POST["nonce"], "saveFilterWords") && current_user_can("manage_options")) {
            update_option("thepdi_plugin_words_to_filter", sanitize_text_field($_POST["thepdi_plugin_words_to_filter"]));?>

            <div class="updated">
                <p>Your filtered words were saved.</p>            thepdi_plugin_word_to_filte
            </div>
        <?php
        } else {?>
            <div class="error">
                <p>Sorry you do not have permission to perform that action</p>
            </div>
        <?php
        }
    }

    function pageHTML() {?>
        <section class="wrap">
            <h1>Thepdi - Word Filter</h1>

            <?php
                if($_POST["just_submit_it"] === "true") {
                    $this->handleForm();
                }
            ?>
            <form method="POST">
                <input type="hidden" name="just_submit_it" value="true">
                <?php wp_nonce_field("saveFilterWords", "nonce") ?>
                <label for="thepdi_plugin_words_to_filter">Enter a comma-separeted list of words to filter from you site's content</label>
                <div class="word-filter__flesh-container">
                    <textarea name="thepdi_plugin_words_to_filter" id="thepdi_plugin_words_to_filter" placeholder="bad, mean, etc..." class=""><?php echo esc_textarea(get_option("thepdi_plugin_words_to_filter")); ?></textarea>
                </div>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save changes">
            </form>
        </section>
    <?php
    }

    function pageAssets() {
        wp_enqueue_style("filterAdminCss", plugin_dir_url(__FILE__ . "styles.css"));
    }

    function menu() {
        $mainPageHook = add_menu_page("Thepdi - word filter", "Thepdi - word filter", "manage_options", "thepdi_plugin_word_filter", [$this, "pageHTML"], "dashicons-smiley", 99);
        add_submenu_page("thepdi_plugin_word_filter", "Thepdi - word filter", "Words List", "manage_options", "thepdi_plugin_word_filter", [$this, "pageHTML"]);
        add_submenu_page("thepdi_plugin_word_filter", "Thepdi - word filter options", "Options", "manage_options", "thepdi_plugin_word_filter_options", [$this, "optionsHTML"]);
        add_action("load-$mainPageHook", [$this, "pageAssets"]);
    }

    function filterLogic($content) {
        $badWords = explode(",", get_option("thepdi_plugin_words_to_filter"));
        $badWordsTrimmed = array_map("trim", $badWords);

        return str_ireplace($badWordsTrimmed, sanitize_text_field(get_option("thepdi_plugin_replacement_text", "****")), $content);
    }
}

$thepdiWordFilter = new Thepdi_Word_Filter();