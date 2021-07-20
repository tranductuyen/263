<?php
/**
 * Template Name: Redirect Short Link
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
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
$url = $row['url'];

header("Location: $url");

die();
