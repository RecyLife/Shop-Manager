<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once(dirname(__FILE__) . "/utils/database.php");

session_start();
if(!isset($_SESSION["admin"])) {
    echo json_encode(array("error" => "you are not logged in as admin"));
    exit();
}

$db = new Database;
$id = $db->escapeStrings($_GET["id"]);

$db -> query("UPDATE recytech_orders SET done = NOT (SELECT done from recytech_orders WHERE ID = ?) WHERE ID = ?", [$id, $id]);

header("location: ../orders");