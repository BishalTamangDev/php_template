<?php

$searchContent = $_POST['searchContent'] ?? "";

require_once __DIR__ . '/../classes/person.php';

$personObj = new Person();

$data = $personObj->search($searchContent);

// $jsonData =json_encode($data);
// print_r($jsonData);

if (sizeof($data) == 0) {
?>
    <tr>
        <td colspan="4" class="text-danger">
            No data found!
        </td>
    </tr>
    <?php
} else {
    $serial = 1;
    foreach ($data as $datum) {
    ?>
        <tr>
            <th scope="row"> <?= $serial++ ?> </th>
            <td> <?= ucwords(strtolower($datum['name'])) ?> </td>
            <td> <?= $datum['weight'] ?> </td>
            <td> <?= $datum['appetite'] ? "Hungry" : "Not-hungry" ?> </td>
        </tr>
    <?php
    }
    ?>
<?php
}
