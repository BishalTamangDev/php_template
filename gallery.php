<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- title -->
    <title> Gallery </title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- bootstrap css :: cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="/php_template/css/style.css">

    <style>
        .image-div {
            position: relative;
            width: 200px;
            aspect-ratio: 1;
        }

        .image-div img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* delete operation */
        .delete-div {
            right: 0;
            position: absolute;
        }
    </style>
</head>

<body>
    <!-- header -->
    <?php include 'sections/header.php'; ?>

    <!-- main content -->
    <main class="main container mb-5">
        <div class="d-flex flex-row justify-content-between heading mb-4">
            <h3 class="fw-bold text-secondary"> GALLERY </h3>
            <a href="/php_template/upload-image" class="btn btn-primary"><i class="fa fa-add"></i> ADD NEW</a>
        </div>

        <div class="mt-4 image-container d-flex flex-row flex-wrap gap-4" id="gallery-container">
            <p class="text-secondary"> Loading gallery... </p>
            <div class="d-flex flex-column gap-2 image-div d-none">
                <img src="/php_template/assets/images/user_1.jpg" alt="" loading="lazy">
                <div class="bg-light delete-div px-3 py-2 pointer border">
                    <i class="fa fa-trash text-secondary"></i>
                </div>
            </div>
        </div>
    </main>

    <!-- bootstrap js :: cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        function fetchGallery() {
            const xhr = new XMLHttpRequest();

            xhr.open("GET", "app/fetch_gallery.php", true);

            xhr.onload = function() {
                if (xhr.status == 200) {
                    var response = this.response;
                    document.getElementById('gallery-container').innerHTML = this.response;

                    // add event
                    var items = document.querySelectorAll('.image-delete-div');

                    items.forEach((item) => {
                        item.addEventListener('click', function() {
                            const dataId = this.getAttribute('data-id');

                            const xhr = new XMLHttpRequest();

                            xhr.open("POST", "app/delete_image.php", true);

                            let params = `id=${dataId}`;

                            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                            xhr.onload = function () {
                                if(xhr.status == 200) {
                                    var response = xhr.response;

                                    console.log(response);

                                    if(response) {
                                        fetchGallery();
                                    }
                                } else {
                                    console.log("Error occured!");
                                }
                            }

                            xhr.send(params);
                        });
                    });
                } else {
                    console.log("An error occurred!");
                }
            }

            xhr.onerror = function() {
                confirm.log("An error occurred!");
            }

            xhr.send();
        }

        fetchGallery();
    </script>
</body>

</html>