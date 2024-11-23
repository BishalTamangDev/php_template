<?php

function download($filepath, $filename)
{
    $fullpath = "$filepath$filename";
    
    if (file_exists($fullpath)) {
        header("Content-Disposition: attachment; filename=".urlencode($fullpath));

        // Output the file
        // readfile($fullpath);

        return true;
    }

    return false;
}
