<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- title -->
    <title> Upload Document</title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- bootstrap css :: cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="/php_template/css/style.css">

    <style>
        #error-message-div {
            display: none;
        }

        #success-message-div {
            display: none;
        }
    </style>
</head>

<body>
    <!-- header -->
    <?php include 'sections/header.php'; ?>

    <!-- main -->
    <main class="main container">
        <!-- heading -->
        <div class="d-flex flex-row flex-wrap gap-2 justify-content-between mb-4 header">
            <h3 class="fw-bold text-secondary"> UPLOAD DOCUMENT </h3>
            <button class="btn btn-danger fit-content" id="reset-btn"> RESET </>
        </div>

        <!-- article -->
        <article class="article">
            <!-- error message div -->
            <div class="alert alert-danger" role="alert" id="error-message-div">
                An error message appears here...
            </div>

            <!-- success message div -->
            <div class="alert alert-success" role="alert" id="success-message-div">
                Success message appears here...
            </div>

            <!-- form -->
            <form action="" method="POST" class="form" id="document-form" enctype="application/x-www-form-urlencoded">
                <input type="file" name="document" id="document" class="mb-3 form-control" accept="application/pdf">
                <button type="submit" class="btn btn-primary" id="upload-btn"> UPLOAD NOW </button>
            </form>
        </article>
    </main>

    <!-- script section -->
    <script>
        const uploadBtn = document.getElementById('upload-btn');
        const docForm = document.getElementById('document-form');

        const errorDiv = document.getElementById('error-message-div');
        const successDiv = document.getElementById('success-message-div');

        docForm.addEventListener('submit', (e) => {
            console.clear();

            errorDiv.style.display = "none";
            successDiv.style.display = "none";

            e.preventDefault();

            const fileInput = document.getElementById('document');

            // check if file has been attached
            if (fileInput.files.length === 0) {
                errorDiv.innerText = "Please select the document first.";
                errorDiv.style.display = "block";
                return;
            }

            const maxFileSize = 41943040;

            // check for file size
            if (fileInput.files[0].size > maxFileSize) {
                errorDiv.innerText = "Document size is too big.";
                errorDiv.style.display = "block";
                return;
            }

            const formData = new FormData();

            formData.append('document', fileInput.files[0]);

            // ajax
            const xhr = new XMLHttpRequest();

            xhr.open("POST", "/php_template/app/upload-document.php", true);

            xhr.onprogress = () => {
                uploadBtn.innerText = "UPLOADING...";
                console.log("Starting upload task..");
            }

            xhr.onload = () => {
                if (xhr.status == 200) {
                    errorDiv.style.display = "none";
                    successDiv.style.display = "flex";
                    successDiv.innerText = xhr.responseText;
                    docForm.reset();
                } else {
                    errorDiv.style.display = "flex";
                    successDiv.style.display = "none";
                    errorDiv.innerText = xhr.responseText;
                }
                uploadBtn.innerText = "UPLOAD NOW";
            }

            xhr.send(formData);
        });

        // form reset button
        document.getElementById('reset-btn').addEventListener('click', function() {
            docForm.reset();
            errorDiv.style.display = "none";
            successDiv.style.display = "none";
        });
    </script>
</body>

</html>