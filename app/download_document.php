<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);

        require_once __DIR__ . '/../classes/document.php';
        
        $documentObj = new Document();
        
        $exists = $documentObj->fetch($id);
        
        if(!$exists) {
            echo "File not found!";
        } else {
            require_once __DIR__ . '/../functions/download.php';

            $filename = $documentObj->getName();

            $filepath = "../uploads/documents/";

            $download = download($filepath, $filename);

            echo $download ? true : "File couldn't be downloaded.";
        }
    } else {
        echo "An error occurred!";
    }
} else {
    echo "An error occurred!";
}

exit;