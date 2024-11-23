<?php

$id = $_POST['id'] ?? 0;

if($id == 0) {
    echo "An error occured!";
} else {
    require_once __DIR__ . '/../classes/document.php';

    $documentObj = new Document();

    $deleted = $documentObj->delete($id);

    if($deleted) {
        // delete file
        $deleted = unlink("../uploads/documents/{$documentObj->getName()}");
    }

    echo $deleted;
}

exit;