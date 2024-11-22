<?php

$id = $_POST['id'] ?? 0;
$response = false;

if ($_POST['id'] != 0) {
    require_once __DIR__ . '/../classes/person.php';

    $personObj  = new Person();

    $response = $personObj->deletePerson($id);
}

echo $response;
