<?php
/**
 * Template Name: Redirect Short Link
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */


//foreach (explode('/', $_SERVER['REQUEST_URI']) as $part) {
//    $elem = $part;
//}
if (isset($_GET['url']) && $_GET['url'] != null) {
    $elem = $_GET['url'];
} else {
    $elm = null;
}

$conn = new mysqli('localhost', 'root', 'password', 'database_263');
if ($conn->connect_error) {
    die("Conn failed");
}
$sql = "SELECT * FROM wp_urls WHERE shorturl='$elem';";

$rs = mysqli_query($conn, $sql);
$getRes = mysqli_fetch_assoc($rs);

$url = $getRes['url'];
header("Location: $url");
$conn->close();
die();
