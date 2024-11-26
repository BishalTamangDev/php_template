<?php

function download($filepath, $filename)
{
    $fullpath = "$filepath$filename";

    if (file_exists($fullpath)) {
        // header("Content-Type:application/octet-stream");
        // header("Content-Type:Transfer-Encoding:utf-8");
        header("Content-Disposition:attachment; filename=\"" . urlencode(basename($fullpath)) . "\"");

        // Output the file
        // readfile($fullpath);

        return true;
    }

    return false;
}
