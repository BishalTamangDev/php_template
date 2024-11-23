<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- title -->
    <title>Document</title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- bootstrap css :: cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="/php_template/css/style.css">
</head>

<body>
    <!-- header -->
    <?php include 'sections/header.php'; ?>

    <!-- main -->
    <main class="main container">
        <!-- heading -->
        <div class="d-flex flex-row flex-wrap gap-2 justify-content-between mb-4 header">
            <h3 class="fw-bold text-secondary"> DOCUMENTS </h3>
            <a href="/php_template/document/add" class="btn btn-primary fit-content"> <i class="fa fa-add"></i> ADD NEW </a>
        </div>

        <!-- article -->
        <article class="article">
            <table class="table">
                <thead>
                    <tr>
                        <th> SN </th>
                        <th> ID </th>
                        <th> Filename </th>
                        <th> Operation </th>
                    </tr>
                </thead>

                <tbody id="table-body">
                    <tr>
                        <td> 1. </td>
                        <td> 1123 </td>
                        <td> abh1b123hb.pdf </td>
                        <td>
                            <div class="d-flex flex-row gap-2">
                                <i class="fa fa-download"></i>
                                <i class="fa fa-trash text-danger"></i>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </article>
    </main>

    <!-- script -->
    <script>
        const xhr = new XMLHttpRequest();

        function fetchAllDocuments() {
            xhr.open("GET", "/php_template/app/fetch_all_documents.php", true);

            xhr.onload = () => {
                if (xhr.status == 200) {
                    document.getElementById('table-body').innerHTML = xhr.response;
                    setOperation();
                } else {
                    document.getElementById('table-body').innerHTML = xhr.response;
                    console.log("An error occured in fetching documents.");
                }
            }

            xhr.send();
        }

        fetchAllDocuments();

        // operation
        function setOperation() {
            deleteItems = document.querySelectorAll('.delete-icon');
            downloadItems = document.querySelectorAll('.download-icon');

            // delete
            deleteItems.forEach(item => {
                item.addEventListener('click', function() {
                    const id = item.getAttribute("data-id");

                    xhr.open("POST", '/php_template/app/delete_document.php', true);

                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                    const param = `id=${id}`;

                    xhr.onload = () => {
                        if (xhr.status == 200) {
                            if (xhr.response) {
                                alert("Document deleted successfully!");
                                fetchAllDocuments();
                            } else {
                                alert("Document couldn't be deleted!");
                            }
                        } else {
                            console.log("An error occured");
                        }
                    }

                    xhr.send(param);
                });
            });

            // download
            downloadItems.forEach(item => {
                item.addEventListener('click', function() {
                    console.clear();
                    
                    const id = this.getAttribute("data-id");

                    xhr.open("POST", "/php_template/app/download_document.php", true);

                    const param = `id=${id}`;

                    xhr.setRequestHeader('Content-type', "application/x-www-form-urlencoded");

                    xhr.onload = () => {
                        if (xhr.status == 200) {
                            console.log(xhr.response);
                        } else {
                            console.log(xhr.response);
                        }
                    }
                    
                    xhr.send(param);
                });
            });
        }
    </script>
</body>

</html>