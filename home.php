<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- title -->
    <title> PHP Template </title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- bootstrap css :: cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="/php_template/css/style.css">
</head>

<body>
    <!-- header -->
    <?php require 'sections/header.php'; ?>

    <main class="main container">
        <h3 class="mb-4 fw-bold text-secondary"> ALL PERSONS </h3>
        <div class="table-container">
            <table class="table person-table border">
                <thead>
                    <tr>
                        <th scope="col"> ID </th>
                        <th scope="col"> Name </th>
                        <th scope="col"> Gender </th>
                        <th scope="col"> Date&nbsp;of&nbsp;Birth </th>
                        <th scope="col"> Height&nbsp;[ft] </th>
                        <th scope="col"> Is&nbsp;Frank </th>
                        <th scope="col"> Mobile&nbsp;Brand </th>
                        <th scope="col"> Description </th>
                        <th scope="col"> Operation </th>
                    </tr>
                </thead>

                <tbody id="person-table-body">
                    <tr class="d-none">
                        <th scope="row"> 1 </th>
                        <td> David </td>
                        <td> Male </td>
                        <td> 2000-02-06 </td>
                        <td> 6.1 </td>
                        <td> True </td>
                        <td> Apple </td>
                        <td> Tall and helpful </td>
                        <td>
                            <div class="d-flex flex-row gap-2 operations">
                                <a href="">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="" class="text-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="6" class="text-secondary small"> Loading data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- bootstrap js :: cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        var items = "";
        const tableBody = document.getElementById('person-table-body');

        function fetchAllDataMethod1() {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                switch (this.readyState) {
                    case 0:
                        console.log("Ready State :: Request not initialized");
                        break;
                    case 1:
                        console.log("Ready State :: server connection established");
                        break;
                    case 2:
                        console.log("Ready State :: request received");
                        break;
                    case 3:
                        console.log("Ready State :: processing request");
                        break;
                    case 4:
                        console.log("Ready State :: done");
                        if (this.status == 200) {
                            var data = this.response;
                            console.log("Status :: ok");
                            tableBody.innerHTML = data;
                            setOperation();
                        } else if (this.status == 403) {
                            console.log("Status :: Forbidden");
                        } else {
                            console.log("Status :: Page not found");
                        }
                        break;
                }
            }

            xhr.open("GET", "app/fetch_all_data.php", true);

            xhr.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");

            xhr.send();
        }

        function fetchAllDataMethod2() {
            const xhr = new XMLHttpRequest();

            xhr.open("GET", "/php_template/app/fetch_all_data.php", true);

            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onprogress = function() {
                console.log("fetching data...");
            }

            xhr.onload = function() {
                if (this.status == 200) {
                    console.log("Data fetched");
                    const data = this.response;
                    tableBody.innerHTML = data;

                    setOperation();
                } else if (this.status == 403) {
                    console.log("status :: forbidden");
                } else {
                    console.log("status :: page not found");
                }
            }

            xhr.onerror = function() {
                console.log("An error occurred");
            }

            xhr.ontimeout = function() {
                console.log("page took long time to fetch data");
            }

            xhr.send();
        }

        // fetchAllDataMethod1();
        fetchAllDataMethod2();

        // delete data
        function setOperation() {
            items = document.querySelectorAll('.data-delete-icon');

            // add a click event listerner to each item
            items.forEach(item => {
                item.addEventListener('click', function() {
                    const dataId = this.getAttribute('data-id');

                    const deleteXhr = new XMLHttpRequest();

                    const param = `id=${dataId}`;

                    deleteXhr.open("POST", "/php_template/app/delete.php", true);

                    deleteXhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                    deleteXhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            fetchAllDataMethod2();
                        }
                    }

                    deleteXhr.send(param);
                });
            });
        }
    </script>

</body>

</html>