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
            <td> <?= ucfirst($datum['gender']) ?> </td>
            <td> <?= $datum['date_of_birth'] ?> </td>
            <td> <?= $datum['height'] ?> </td>
            <td> <?= $datum['is_frank'] ? "Yes" : "No" ?> </td>
            <td> <?= ucwords($datum['mobile_brand']) ?> </td>
            <td> <?= ucfirst($datum['description']) ?> </td>
        </tr>
    <?php
    }
    ?>
<?php
}
