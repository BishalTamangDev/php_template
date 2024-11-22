<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- title -->
    <title> Add Image </title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- bootstrap css :: cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="/php_template/css/style.css">

    <style>
        #error-message-div {
            display: none;
        }
    </style>
</head>

<body>
    <!-- header -->
    <?php include 'sections/header.php'; ?>

    <!-- main -->
    <main class="main container">
        <!-- error message div -->
        <div class="alert alert-danger" role="alert" id="error-message-div">
             An error message appears here...
        </div>

        <form action="" id="gallery-form" enctype="multipart/form-data">
            <input type="file" name="image" id="imageInput" class="form-control mb-3" accept="image/*">
            <button type="submit" class="btn btn-primary"> Add Now </button>
            <button type="button" class="btn btn-outline-danger" id="reset-form-btn"> Reset </button>
        </form>
    </main>

    <!-- script -->
    <script>
        const errorDiv = document.getElementById('error-message-div');

        const galleryForm = document.getElementById('gallery-form');

        const xhr = new XMLHttpRequest();

        galleryForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const fileInput = document.getElementById('imageInput');

            if (fileInput.files.length === 0) {
                errorDiv.innerText = "Select the file first.";
                errorDiv.style.display = "flex";
                return;
            }
            
            const maxFileSize = 41943040; // 40 MB
            
            if (fileInput.files[0].size > maxFileSize) {
                errorDiv.style.display = "flex";
                errorDiv.innerText = "File sized exceed.";
                return;
            }

            const formData = new FormData();

            formData.append('image', fileInput.files[0]);

            xhr.open("POST", "app/add-image.php", true);

            xhr.onload = function() {
                if (this.status == 200) {
                    if (this.response == 1) {
                        errorDiv.style.display = "none";
                        galleryForm.reset();
                        alert("Image uploaded successfully!");
                    } else {
                        errorDiv.style.display = "flex";
                        errorDiv.innerText = this.responseText;
                    }
                } else {
                    console.log("Error: " + xhr.status);
                }
            };

            xhr.onerror = function() {
                console.log("An error occurred!");
            }

            xhr.send(formData);
        });

        // reset form btn
        document.getElementById('reset-form-btn').addEventListener('click', function() {
            galleryForm.reset();
            errorDiv.style.display = "none";
        });
    </script>
</body>

</html>