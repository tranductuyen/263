<?php
/*
Plugin Name: Idea pro short link
Plugin URI:
Description: Just another contact form plugin. Simple but flexible.
Author: 263
Author URI:
Text Domain: short link
Domain Path: /languages/
Version: 1.0.0
*/

define('IDEA_PRO_SHORT_VERSION', '1.0.0');
define('IDEA_PRO_MINIMUM_WP_VERSION', '1.0.0');
define('IDEA_PRO_SHORT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('IDEA_PRO_SHORT_PLUGIN_DIR', plugin_dir_path(__FILE__));

session_start();

function idea_pro_short_link_form()
{

    $content = '';
    $content = '<div class="td-pb-row">';

    $content .= '<div class="td-pb-span9"><input oninput="return_submit_short_link()" type="text" id="url" name="url" placeholder="Shorten your link"></div>';

    $content .= '<div class="td-pb-span3"><input type="button" id="idea_pro_short_link_submit" onclick="submit_short_link_form()" name="idea_pro_short_link_submit" value="Shorten"></div>';

    $content .= '</div>';

    $content .= '<p style="color: red" class="errors"></p>';
    $content .= '<div id="here_table">';
    $content .= '</div>';

    return $content;

}

add_shortcode('short_link_form', 'idea_pro_short_link_form');

//add_action('wp_enqueue_scripts', 'my_scripts');

add_action('wp_enqueue_scripts', 'idea_pro_register_scripts');
function idea_pro_register_scripts()
{
    //Css
    wp_enqueue_style('idea_pro_style.css', IDEA_PRO_SHORT_PLUGIN_URL . '/scripts/css/idea_pro_style.css', false, '1.0');

    //Javascript, Thư viện jQuery

    wp_enqueue_script('jquery.min.js_3.5.1', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array(), '3.5.1', true);
    wp_enqueue_script('script.js', IDEA_PRO_SHORT_PLUGIN_URL . '/scripts/js/script.js', array(), '1.0', true);
    wp_localize_script('script.js', 'myAjax', array('ajax_url' => admin_url('admin-ajax.php')));

}


add_action('wp_ajax_short_link', 'shorten');
add_action('wp_ajax_nopriv_short_link', 'shorten');
function shorten()
{
    $json = array();
    $long_url = $_POST['long_url'];
    $short_url = do_short_url($long_url);
    $urls['short_url'] = $short_url;
    $urls['long_url'] = $long_url;

    $json['urls'] = $urls;
//    $json['content'] = $content;
    wp_send_json_success($json);

}

function do_short_url($url)
{
    $return_url = short_url($url);

    return get_home_url() . '/s/?url=' . $return_url;

}

function short_url_db($url)
{
    global $wpdb;
    $table = $wpdb->prefix . 'urls';
    $sql = "SELECT * FROM {$table} WHERE `url` = %s";
    $row = $wpdb->get_row($wpdb->prepare($sql, $url), ARRAY_A);
    if (count($row) > 0) {
        return $row['shorturl'];
    } else {
        $shortUrl = get_random_slug(5);
        //insert data in database
        $data = array(
            'url' => $url,
            'shorturl' => $shortUrl,
        );
        $table = $wpdb->prefix . 'urls';
        $wpdb->insert(
            $table,
            $data
        );
        $data = $wpdb->insert_id;
        return $shortUrl;
    }
}

function get_random_slug($length)
{
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $characterLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $characterLength - 1)];
    }
    return $randomString;
}