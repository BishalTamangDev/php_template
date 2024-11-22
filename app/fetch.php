<?php

$id = $_GET['id'] ?? 0;

require_once __DIR__ . '/../classes/person.php';
$personObj = new Person();

$data = [
    "response" => 0,
    "id" => $id,
    "name" => "",
    "weight" => "",
    "appetite" => "",
];

if ($id != 0) {
    $response = $personObj->fetch($id);

    $data = [
        "response" => $response,
        "id" => $personObj->getId(),
        "name" => $personObj->getName(),
        "gender" => $personObj->getGender(),
        "date_of_birth" => $personObj->getDateOfBirth(),
        "height" => $personObj->getHeight(),
        "is_frank" => $personObj->getIsFrank(),
        "mobile_brand" => $personObj->getMobileBrand(),
        "description" => $personObj->getDescription(),
    ];
}

echo json_encode($data);
