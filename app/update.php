<?php

$id = $_POST['id'] ?? 0;

$response = false;

if ($id != 0) {
    require_once __DIR__ . '/../classes/person.php';

    $personObj = new Person();

    $personObj->set($id, $_POST['name'], $_POST['gender'], $_POST['date-of-birth'], $_POST['height'], $_POST['is-frank'], $_POST['mobile-brand'], $_POST['description']);

    if ($personObj->isValid()) {
        $response = $personObj->update($id);
    }
}

echo $response;
