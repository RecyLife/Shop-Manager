<?php
header('Content-Type: application/json');

include_once(dirname(__FILE__) . "/utils/database.php");

session_start();
if(!isset($_SESSION["admin"])) {
    echo json_encode(array("error" => "you are not logged in as admin"));
    exit();
}

$db = new Database;

$id = $db->escapeStrings($_GET["id"]);

$order = $db -> select("SELECT recytech_orders.*, recytech_OS.name as OS from recytech_orders INNER JOIN recytech_OS ON recytech_orders.OS_ID = recytech_OS.ID WHERE ID = ?", [$id]);
$products = $db -> select("SELECT recytech_products.* from recytech_order_products INNER JOIN recytech_products ON recytech_order_products.product_ID = recytech_products.ID WHERE order_ID = ?", [$id]);

echo json_encode(array_values($order));