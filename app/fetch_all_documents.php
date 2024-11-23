<?php

$documents = [];

require_once __DIR__ . '/../classes/document.php';

$documentObj = new Document();

$documents = $documentObj->fetchAll();

// echo json_encode($documents);

if (sizeof($documents) == 0) {
?>
    <tr>
        <td colspan="4" class="text-danger small"> No document found! </td>
    </tr>
    <?php
} else {
    $serial = 1;
    foreach ($documents as $document) {
    ?>
        <tr>
            <td> <?= $serial++ ?> </td>
            <td> <?= $document['id'] ?> </td>
            <td> <?= $document['name'] ?> </td>
            <td>
                <div class="d-flex flex-row gap-2">
                    <i class="fa fa-download download-icon pointer" data-id="<?=$document['id']?>"></i>
                    <i class="fa fa-trash text-danger delete-icon pointer" data-id="<?=$document['id']?>"></i>
                </div>
            </td>
        </tr>
<?php
    }
}
