<?php
header('Content-Type: application/json');

include_once(dirname(__FILE__) . "/utils/database.php");

$db = new Database;

$orders = $db -> select("SELECT recytech_orders.*, recytech_OS.name as OS from recytech_orders INNER JOIN recytech_OS ON recytech_orders.OS_ID = recytech_OS.ID");

echo json_encode(array_values($orders));