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
        "name" => ucwords(strtolower($personObj->getName())),
        "weight" => $personObj->getWeight(),
        "appetite" => $personObj->getAppetite() ? "Hungry" : "Not-hungry",
    ];
}

echo json_encode($data);
