<?php

function compressImage($source, $destination, $quality)
{
    $info = getimagesize($source);
    $image = "";

    switch ($info['mime']) {
        case 'image/jpeg':
        case 'image/jpg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png';
            $image = imagecreatefrompng($source);
            break;
        case 'image/webp':
            $image = imagecreatefromwebp($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
    }

    imagejpeg($image, $destination, $quality);
    return $destination;
}
