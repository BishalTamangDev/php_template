<?php

require_once __DIR__ . '/../classes/person.php';

$personObj = new Person();

$personList = $personObj->fetchAll();

// echo json_encode($personList);

if (sizeof($personList) == 0) {
?>
    <tr>
        <td colspan="6" class="text-danger small"> Empty! </td>
    </tr>
    <?php
} else {
    $serial = 1;
    foreach ($personList as $person) {
    ?>
        <tr class="">
            <th scope="row"> <?= $serial++ ?> </th>
            <td> <?= ucwords(strtolower($person['name'])) ?> </td>
            <td> <?= ucfirst($person['gender']) ?> </td>
            <td> <?= $person['date_of_birth'] ?> </td>
            <td> <?= $person['height'] ?> </td>
            <td> <?= $person['is_frank'] ? "Yes" : "No" ?> </td>
            <td> <?= ucwords($person['mobile_brand']) ?> </td>
            <td> <?= ucfirst($person['description']) ?> </td>
            <td>
                <div class="d-flex flex-row align-items-center gap-2 operations">
                    <a href="/php_template/data/view/<?=$person['id']?>">
                        <i class="fa-regular fa-eye text-secondary"></i>
                    </a>

                    <a href="/php_template/data/edit/<?=$person['id']?>">
                        <i class="fa fa-edit"></i>
                    </a>

                    <i class="fa fa-trash text-danger pointer data-delete-icon" data-id="<?=$person['id']?>"></i>
                </div>
            </td>
        </tr>
    <?php
    }
    ?>

<?php
}
