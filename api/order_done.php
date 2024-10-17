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
$done = $db->select("SELECT done FROM recytech_orders WHERE ID = ?", [$id]);

if ($done !== false) {
    $newDoneStatus = !$done[0]['done'];
    $db->query("UPDATE recytech_orders SET done = ? WHERE ID = ?", [$newDoneStatus, $id]);

    if($newDoneStatus == 0){
        $db->query(
            "UPDATE recytech_products 
             SET quantity = quantity + 1 
             WHERE ID = (SELECT product_ID FROM recytech_order_products WHERE order_ID = ?)",
            [$id]
        );    
    }else{
        $db->query(
            "UPDATE recytech_products 
             SET quantity = quantity - 1
             WHERE ID = (SELECT product_ID FROM recytech_order_products WHERE order_ID = ?)",
            [$id]
        );    
    }

    header("Location: ../orders");
    exit();
} else {
    echo "Order not found.";
}
?>