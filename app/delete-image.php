<?php 

$response = false;

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['id'])) {  
    require_once __DIR__ . '/../classes/gallery.php';
    
    $galleryObj = new Gallery();
    
    $response = $galleryObj->delete($_POST['id']);
}

echo $response;