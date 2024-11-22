<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- title -->
    <title> Search </title>

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
        <!-- heading and search content -->
        <div class="d-flex flex-row flex-wrap gap-2 justify-content-between mb-4">
            <h3 class="fw-bold text-secondary"> SEARCH DATA </h3>

            <form action="" id="search-form" class="d-flex flex-row gap-2">
                <input type="text" name="search-content" id="search-content" class="form-control fit-height" placeholder="search here...">
                <!-- <button type="submit" class="btn btn-primary"> <i class="fa fa-search"></i> </button> -->
                <button type="button" class="btn btn-danger mb-3 d-none" id="reset-btn"> Reset </button>
            </form>
        </div>

        <!-- results -->
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
        const searchForm = document.getElementById('search-form');
        const searchContent = document.getElementById('search-content');
        const personTableBody = document.getElementById('person-table-body');
        var searchContentVal = "";

        const resetBtn = document.getElementById('reset-btn');

        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            submitForm();
        });

        function submitForm() {
            resetBtn.classList.remove('d-none');

            searchContentVal = searchContent.value;

            const xhr = new XMLHttpRequest();

            var params = `searchContent=${searchContentVal}`;

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    personTableBody.innerHTML = this.response;
                }
            }

            xhr.open("POST", "/php_template/app/search.php", true);

            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.send(params);
        }

        // fetch all data
        function fetchAllData() {
            const xhr = new XMLHttpRequest();

            var params = "searchContent=";

            xhr.open("POST", "/php_template/app/search.php", true);

            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    personTableBody.innerHTML = this.response;
                }
            }

            xhr.onerror = function() {
                console.log("An error occurred!");
            }

            xhr.send(params);
        }

        resetBtn.addEventListener('click', function() {
            resetBtn.classList.add('d-none');
            searchForm.reset();
            fetchAllData();
        });

        fetchAllData();
    </script>
</body>

</html>