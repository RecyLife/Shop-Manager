<?php
session_start();
echo json_encode(array("is_connected" => isset($_SESSION["admin"])));