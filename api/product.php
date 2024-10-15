<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
include_once(dirname(__FILE__) . "/utils/database.php");

$db = new Database;

if(!isset(($_GET["id"]))) {
    echo json_encode(array("error" => "ID is not specified"));
    exit();
}

$id = $db -> escapeStrings($_GET["id"]);

$product = $db -> select("
SELECT 
    recytech_products.ID as ID, 
    recytech_products.title as title,
    recytech_products.quantity as quantity,
    recytech_products.price as price,
    recytech_categories.title as category,
    recytech_products.category_ID
from recytech_products
INNER JOIN recytech_categories 
    ON recytech_products.category_ID = recytech_categories.ID
WHERE recytech_products.ID = ?", [$id]);

$specifications = $db -> select("SELECT * from recytech_specifications WHERE product_ID = ?", [$id]);


if(count($product) > 0) {
    $product[0]["specifications"] = array_values($specifications);

    echo json_encode($product[0]);
} 