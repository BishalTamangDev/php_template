<?php

$response = false;

if (isset($_POST['name']) && isset($_POST['weight']) && isset($_POST['appetite'])) {
    require_once __DIR__ . '/../classes/person.php';

    $personObj = new Person();

    $personObj->setName($_POST['name']);
    $personObj->setWeight($_POST['weight']);
    $personObj->setAppetite($_POST['appetite'] ?? false);

    $response = $personObj->insertPerson();
}

echo $response;