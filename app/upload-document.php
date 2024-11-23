<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
        require_once __DIR__ . '/../classes/document.php';

        $documentObj = new Document();

        $file = $_FILES['document'];
        $filename = $_FILES['document']['name'];
        $fileTmpName = $_FILES['document']['tmp_name'];
       
        $fileTmpExtension = explode('.', $file['name']);

        $fileExtension = strtolower(end($fileTmpExtension));

        // file validity check
        $valid = validDocument($_FILES['document']);

        $newFileName = uniqid('', true) . "." . $fileExtension;

        if ($valid) {
            $documentObj->setName($newFileName);
            $inserted = $documentObj->upload();

            if($inserted) {
                $uploaded = move_uploaded_file($fileTmpName, "../uploads/documents/$newFileName");
                echo "Document uploaded successfully!";
            } else {
                echo "Error in uploading document.";
            }
        } else {
            echo "Invalid file!";
        }
    } else {
        echo false;
    }
} else {
    echo false;
}

function validDocument($file)
{
    $size = $file['size'];

    $maxFileSize = 41943040;

    if ($size > $maxFileSize) {
        return false;
    }

    $fileTmpExtension = explode('.', $file['name']);

    $fileExtension = strtolower(end($fileTmpExtension));

    if (!in_array($fileExtension, ["pdf"])) {
        return false;
    }

    return true;
}
