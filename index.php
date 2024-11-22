<?php

$request = $_SERVER['REQUEST_URI'];

$router = str_replace('/php_template', '', $request);

$pathArray = explode('/', $router);

// echo "Request : $request<br/>";
// echo "Router : $router<br/>";
// echo "Path array : ";
// print_r( $pathArray);

$redirected = true;

switch ($pathArray[1]) {
    case '':
    case 'home':
        require 'home.php';
        break;
    case 'data':
        if (isset($pathArray[2])) {
            $task = $pathArray[2];
            if (in_array($task, ["view", "add", "edit", "search"])) {
                if ($task == "add") {
                    require 'data.php';
                } else if ($task == "edit") {
                    if (isset($pathArray[3])) {
                        $id = $pathArray[3];
                        require 'data.php';
                    } else {
                        $redirected = false;
                        header("Location: /php_template/home");
                    }
                } else if ($task == "search") {
                    require 'search.php';
                } else {
                    // view
                    if (isset($pathArray[3]) && $pathArray[3] != "") {
                        $id = $pathArray[3];
                        require 'view.php';
                    } else {
                        $redirected = false;
                    }
                }
            } else {
                $redirected = false;
            }
        } else {
            $redirected = false;
        }
        break;
    case 'gallery':
        require 'gallery.php';
        break;
    case 'add-image':
        require 'add-image.php';
        break;
    case 'external-api':
        require 'external_api.php';
        break;
    default:
        $redirected = false;
}

if (!$redirected) {
    require 'page_not_found.php';
}
