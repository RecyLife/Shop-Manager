<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once(dirname(__FILE__) . "/utils/database.php");
include_once(dirname(__FILE__). "/utils/secrets.php");

$db = new Database;
const ALLOWED_IMAGES_EXT = ["png", "jpg", "jpeg"];
const ALLOWED_IMAGES_MIMES = array("image/jpeg", "image/png");
const MAX_IMAGES_SIZE = 2 * 1000 * 1000; // 2 MB

$password = $_POST["password"];
echo $password;
echo ADMIN_PASSWORD;
if($password != ADMIN_PASSWORD) {
    echo json_encode(array("error"=> "invalid admin password"));
    exit();
}

$title = $db->escapeStrings(htmlspecialchars($_POST["title"]));
$price = (float)$db->escapeStrings(htmlspecialchars($_POST["price"]));
if($price < 0) {
    echo json_encode(array("error"=> "error with price value"));
    exit();
}

$category = $db->escapeStrings(htmlspecialchars($_POST["category"]));
$matchCategories = $db->select("SELECT * FROM recytech_categories WHERE ID = ?", [$category]);
if(count($matchCategories) < 1) {
    echo json_encode(array("error"=> "error with category value"));
    exit();
}

$specifications =  json_decode($_POST["specifications"], true);

$db->query("INSERT INTO recytech_products (title, price, category_ID) VALUES (?, ?, ?)", [$title, $price, $category]);
$productID = $db -> getLastInsertedID();

for($i = 0; $i < count($specifications); $i++) {
    $specTitle = $db -> escapeStrings(htmlspecialchars($specifications[$i]["title"]));
    $specValue = $db -> escapeStrings(htmlspecialchars($specifications[$i]["value"]));
    
    if($specTitle != "" && $specValue != "") {
        $db -> query("INSERT into recytech_specifications (title, value_, product_ID) VALUES (?, ?, ?)", [$specTitle, $specValue, $productID]);
    }
}

foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
    $temp = $_FILES["images"]["tmp_name"][$key];
    $name = $_FILES["images"]["name"][$key];
    $size = $_FILES["images"]["size"][$key];

    if (empty($temp)) {
        break;
    }

    $ext = pathinfo($name, PATHINFO_EXTENSION);
    if (!in_array($ext, ALLOWED_IMAGES_EXT)) {
        echo json_encode(array("error"=> "invalid image format (0)"));
        exit();
    }

    $mime = mime_content_type($temp);
    if(!in_array($mime, ALLOWED_IMAGES_MIMES)) {
        echo "invalid image format (1)";
        echo $mime;
        exit();
    }

    if ($size > MAX_IMAGES_SIZE) {
        echo json_encode(array("error"=> "image size exceeds the maximum limit of 5 MB"));
        exit();
    }

    $imageContent = file_get_contents($temp);

    $db -> query("INSERT into recytech_images (image_, product_ID) VALUES (?, ?)", [$imageContent, $productID]);

}

header("location: ../");