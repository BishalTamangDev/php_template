<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['CONTENT_LENGTH'] > 41943040) {
        // 40 MB 
        echo "File size exceeds the limit of 40 MB.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileName = $_FILES['image']['name'];
            $fileTmpName = $_FILES['image']['tmp_name'];

            // file validity check
            $valid = fileValidityCheck($_FILES['image']);

            if ($valid === true) {
                // extension extraction
                $fileTempExtension = explode('.', $fileName);

                $fileExtension = strtolower(end($fileTempExtension));

                $newFileName = uniqid('', true) . "." . $fileExtension;

                require_once __DIR__ . '/../functions/compress_image.php';

                if (compressImage($fileTmpName, "../uploads/images/$newFileName", 10)) {
                    // if (move_uploaded_file($fileTmpName, "../uploads/images/$newFileName")) {
                    require_once __DIR__ . '/../classes/gallery.php';

                    $galleryObj = new Gallery();

                    $galleryObj->setFilename($newFileName);

                    $valid = $galleryObj->upload();

                    if ($valid !== true) {
                        unlink("../uploads/images/$newFileName");
                    }
                } else {
                    $valid = "Error occurred in uploading file.";
                }
            }
            echo $valid;
        } else {
            echo "No file uploaded or there was an error.";
        }
    }
} else {
    echo "Invalid request.";
}


function fileValidityCheck($formFile)
{
    $valid = false;
    $fileName = $formFile['name'];
    $fileSize = $formFile['size'];
    $fileError = $formFile['error'];

    // error check
    if ($fileError) {
        $valid = "An error occured!";
    } else {
        // size
        if ($fileSize >= 41943040) { // 40 MB
            $valid = "Select an image less than or equal to 41943040 bytes";
        } else {
            // extension extraction
            $fileTempExtension = explode('.', $fileName);
            $fileExtension = strtolower(end($fileTempExtension));
            $allowedExtension = ['jpg', 'jpeg', 'png', 'webp', 'jpg'];

            $valid = in_array($fileExtension, $allowedExtension) ? true : "Invalid file format.";
        }
    }

    return $valid;
}
