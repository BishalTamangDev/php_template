<?php

require_once __DIR__ . '/../classes/gallery.php';

$galleryObj = new Gallery();

$data = $galleryObj->fetchAll();

// echo json_encode($data);

if (sizeof($data) == 0) {
?>
    <p class="text-secondary"> Gallery is empty! </p>
    <?php
} else {
    foreach ($data as $datum) {
    ?>
        <div class="d-flex flex-column gap-2 image-div">
            <img src="/php_template/uploads/images/<?= $datum['filename'] ?>" alt="<?= $datum['filename'] ?>" loading="lazy">
            <div class="bg-light delete-div px-3 py-2 pointer border image-delete-div" data-id="<?=$datum['id']?>">
                <i class="fa fa-trash text-secondary"></i>
            </div>
        </div>
<?php
    }
}
