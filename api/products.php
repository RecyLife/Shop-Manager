<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include_once(dirname(__FILE__) . "/utils/database.php");

$db = new Database;

$products = $db -> select("
SELECT 
    recytech_products.ID as ID, 
    recytech_products.title as title, 
    recytech_products.quantity as quantity,
    recytech_products.price as price,
    recytech_categories.title as category,
    recytech_places.name as place
from ((recytech_products
INNER JOIN recytech_categories 
    ON recytech_products.category_ID = recytech_categories.ID)
INNER JOIN recytech_places
    ON recytech_products.place_ID = recytech_places.ID)");

echo json_encode(array_values($products));