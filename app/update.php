<?php

require_once __DIR__ . '/../functions/generate_csrf_token.php';

$response = false;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['token'])) {
        if ($_POST['token'] == generateCsrfToken()) {
            // update
            require_once __DIR__ . '/../classes/person.php';

            $personObj = new Person();

            $personObj->set($_POST['id'], $_POST['name'], $_POST['gender'], $_POST['date-of-birth'], $_POST['height'], $_POST['is-frank'], $_POST['mobile-brand'], $_POST['description']);

            if ($personObj->isValid()) {
                $response = $personObj->update($_POST['id']);
            }
        } else {
            $response = "An error occurred!";
        }
    } else {
        $response = "An error occurred!";
    }
}

echo $response;
