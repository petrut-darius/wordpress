<?php

/*
    Plugin Name: The Pdi Are You Paying Attention Quiz
    Description: Give your readers a multiple choice question.
    Version: 1.0
    Author: Petrut Darius
    //Author URI:
*/

if(!defined("ABSPATH")) exit;

class Thepdi_Are_You_Paying_Attention
{
    public function __construct()
    {
        add_action("init", [$this, "adminAssets"]);
    }

    function theHTML($attributes) {
        if(!is_admin()) {
            $asset = include plugin_dir_path(__FILE__) . "build/frontend.asset.php";
            wp_enqueue_script("attentionFrontend", plugin_dir_url(__FILE__) . "build/frontend.js", $asset["dependencies"], $asset["version"], true);
            wp_enqueue_style("attentionFrontendStyle", plugin_dir_url(__FILE__) . "build/frontend.css");
        }

        ob_start();//ce ii intre astea doua aia va fi returnat
        ?>
            <div class="paying-attention-update-me"><pre style="display: none;"><?php echo wp_json_encode($attributes); ?></pre></div> 
        <?php
        return ob_get_clean();
    }

    function adminAssets() {
        $asset = include plugin_dir_path(__FILE__) .  "build/index.asset.php";

        wp_register_style("quizEditCss", plugin_dir_url(__FILE__) . "build/index.css");
        wp_register_script("newBlockType", plugin_dir_url(__FILE__) . "build/index.js", $asset["dependencies"], $asset["version"], true);
        register_block_type("thepdiplugin/are-you-paying-attention", [
            "editor_script" => "newBlockType",
            "render_callback" => [$this, "theHTML"],
            "editor_style" => "quizEditCss",
        ]);
    }
}

$thepdiAreYouPayingAttention = new Thepdi_Are_You_Paying_Attention();