<?php

$id = $_POST['id'] ?? 0;

$response = false;

if ($id != 0) {
    require_once __DIR__ . '/../classes/person.php';

    $personObj = new Person();

    $personObj->setName($id);
    $personObj->setName($_POST['name'] ?? "");
    $personObj->setWeight($_POST['weight'] ?? "");
    $personObj->setAppetite($_POST['appetite'] ?? 0);

    if ($personObj->isValid()) {
        $response = $personObj->update($id);
    }
}

echo $response;
