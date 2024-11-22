<?php

$response = false;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['name']) && isset($_POST['gender']) && isset($_POST['date-of-birth']) && isset($_POST['height']) && isset($_POST['is-frank']) && isset($_POST['mobile-brand']) && isset($_POST['description'])) {
        require_once __DIR__ . '/../classes/person.php';

        $personObj = new Person();

        $personObj->set(0, $_POST['name'], $_POST['gender'], $_POST['date-of-birth'], $_POST['height'], $_POST['is-frank'], $_POST['mobile-brand'], $_POST['description']);

        $response = $personObj->insertPerson();
    } else {
        echo "data is missing";
    }
}

echo $response;
