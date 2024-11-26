<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../functions/generate_csrf_token.php';

$token = generateCsrfToken();

$response = false;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // check token
    if (isset($_POST['token']) && isset($_POST['name']) && isset($_POST['gender']) && isset($_POST['date-of-birth']) && isset($_POST['height']) && isset($_POST['is-frank']) && isset($_POST['mobile-brand']) && isset($_POST['description'])) {
        if ($_POST['token'] == generateCsrfToken()) {
            require_once __DIR__ . '/../classes/person.php';

            $personObj = new Person();

            $personObj->set(0, $_POST['name'], $_POST['gender'], $_POST['date-of-birth'], $_POST['height'], $_POST['is-frank'], $_POST['mobile-brand'], $_POST['description']);

            $response = $personObj->insertPerson();
        } else {
            $response = "An error occurred!";
        }
    } else {
        echo "An error occurred!";
    }
}

echo $response;
