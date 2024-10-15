<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

if(!isset($_SESSION["admin"])) {
    echo json_encode(array("error" => "you are not logged in as admin"));
    exit();
}


include_once(dirname(__FILE__) . "/utils/database.php");

$db = new Database;

if(!isset(($_GET["id"]))) {
    exit();
}

$id = $db -> escapeStrings($_GET["id"]);

$db -> query("DELETE from recytech_products WHERE ID = ?", [$id]);
$db -> query("DELETE from recytech_images WHERE product_ID = ?", [$id]);
$db -> query("DELETE from recytech_specifications WHERE product_ID = ?", [$id]);

header("location: ../");