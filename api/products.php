<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include_once(dirname(__FILE__) . "/utils/database.php");

$db = new Database;

$products = $db -> select("SELECT * from recytech_products");

echo json_encode(array_values($products));