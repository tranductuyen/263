<?php
/**
 * Template Name: Redirect Short Link
 *
 */


if (isset($_GET['url']) && $_GET['url'] != null) {
    $elem = $_GET['url'];
} else {
    $elm = null;
}

global $wpdb;

$table = $wpdb->prefix . 'urls';
$sql = "SELECT * FROM {$table} WHERE `shorturl` = %s";
$row = $wpdb->get_row($wpdb->prepare($sql, $elem), ARRAY_A);

if (count($row) > 0) {
    $url = $row['url'];
    header("Location: $url");
    $data = array(
        'url' => $row['url'],
        'shorturl' => $row['shorturl'],
        'counter' => $row['counter'] + 1,
);
    $update = $wpdb->update(
        $table,
        $data,
        array('id' => $row['id'])
    );


} else {
    header("Location: " . get_bloginfo('url'));
}
die();
