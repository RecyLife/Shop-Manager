<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include_once(dirname(__FILE__) . "/utils/database.php");

$db = new Database;


$title = $db->escapeStrings(htmlspecialchars($_POST["title"]));
$quantity = (int)$db->escapeStrings(htmlspecialchars($_POST["quantity"]));
if($quantity < 0) {
    echo json_encode(array("error"=> "error with quantity value"));
    exit();
}
$price = (float)$db->escapeStrings(htmlspecialchars($_POST["price"]));
if($price < 0) {
    echo json_encode(array("error"=> "error with price value"));
    exit();
}

$category = $db->escapeStrings(htmlspecialchars($_POST["category"]));
$matchCategories = $db -> select("SELECT * from recytech_categories WHERE ID = '$category'");
if(count($matchCategories) < 1) {
    echo json_encode(array("error"=> "error with category value"));
    exit();
}

$db -> query("INSERT into recytech_products (title, quantity, price, category_ID) VALUES ('$title', '$quantity', '$price', '$category')");
header("location: ../new_product/");