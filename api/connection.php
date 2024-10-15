<?php
include_once(dirname(__FILE__) . "/utils/database.php");
include_once(dirname(__FILE__). "/utils/secrets.php");

$db = new Database;

$password = $_POST["password"];

if($password != ADMIN_PASSWORD) {
    echo json_encode(array("error"=> "invalid admin password"));
    exit();
} else {
    session_start();
    $_SESSION["admin"] = "true";
    exit();
}