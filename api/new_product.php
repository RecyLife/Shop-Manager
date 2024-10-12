<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include_once(dirname(__FILE__) . "/utils/database.php");

$db = new Database;


$title = $db->escapeStrings(htmlspecialchars($_POST["title"]));
$price = (float)$db->escapeStrings(htmlspecialchars($_POST["price"]));
if($price < 0) {
    echo json_encode(array("error"=> "error with price value"));
    exit();
}

$category = $db->escapeStrings(htmlspecialchars($_POST["category"]));
$matchCategories = $db->select("SELECT * FROM recytech_categories WHERE ID = ?", [$category]);
if(count($matchCategories) < 1) {
    echo json_encode(array("error"=> "error with category value"));
    exit();
}

$specifications =  json_decode($_POST["specifications"], true);

$db->query("INSERT INTO recytech_products (title, price, category_ID) VALUES (?, ?, ?)", [$title, $price, $category]);
$productID = $db -> getLastInsertedID();


for($i = 0; $i < count($specifications); $i++) {
    if($specTitle!= "" & $specValue != "") {
        $specTitle = $db -> escapeStrings(htmlspecialchars($specifications[$i]["title"]));
        $specValue = $db -> escapeStrings(htmlspecialchars($specifications[$i]["value"]));
    }

    $db -> query("INSERT into recytech_specifications (title, value_, product_ID) VALUES (?, ?, ?)", [$specTitle, $specValue, $productID]);
}

// header("location: ../new_product/");