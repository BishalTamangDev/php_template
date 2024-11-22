<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- title -->
    <title> <?= $task == "add" ? "ADD DATA" : "EDIT DATA" ?> </title>

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
    <?php require 'sections/header.php'; ?>

    <main class="main container">
        <h3 class="mb-4 fw-bold text-secondary"> <?= $task == "add" ? "ADD DATA" : "EDIT DATA" ?> </h3>

        <!-- error message div -->
        <div class="alert alert-danger" role="alert" id="error-message-div">
            An error message appears here...
        </div>

        <div class="alert alert-success" role="alert" id="success-message-div">
            Success message appears here...
        </div>

        <form method="POST" class="d-flex flex-column" id="data-from">
            <label for="name" class="form-label text-secondary px-1"> Name </label>
            <input type="text" name="name" id="name" class="form-control mb-3" placeholder="name" required>

            <label for="weight" class="form-label text-secondary px-1"> Weight </label>
            <input type="number" step="0.01" name="weight" id="weight" class="form-control mb-3" placeholder="weight" required>

            <p class="mb-2 text-secondary px-1"> Appetite </p>
            <div class="d-flex flex-row gap-3 mb-2 px-1">
                <div class="">
                    <input type="radio" name="appetite" value="1" id="appetite-hungry" required>
                    <label for="appetite-hungry" class="form-label text-secondary pointer"> Hungry </label>
                </div>

                <div class="">
                    <input type="radio" name="appetite" value="0" id="appetite-not-hungry">
                    <label for="appetite-not-hungry" class="form-label text-secondary pointer"> Not-Hungry </label>
                </div>
            </div>

            <div class="d-flex flex-row gap-2">
                <?php
                if ($task == "edit") {
                ?>
                    <button type="submit" class="btn btn-primary fit-width" id="update-data-btn"> UPDATE NOW </button>
                <?php
                } else {
                ?>
                    <button type="submit" class="btn btn-primary fit-width" id="add-data-btn"> ADD NOW </button>
                <?php
                }
                ?>
                <a type="button" class="btn btn-outline-danger fit-width" id="form-reset-btn"> RESET </a>
            </div>
        </form>
    </main>

    <!-- bootstrap js :: cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        const errorDiv = document.getElementById('error-message-div');
        const successDiv = document.getElementById('success-message-div');

        const dataForm = document.getElementById('data-from');

        const task = "<?= htmlspecialchars($task) ?>";

        const personId = "<?= htmlspecialchars($id ?? 0) ?>";

        // reset form
        document.getElementById('form-reset-btn').addEventListener('click', function() {
            task == "add" ?
                dataForm.reset() : backupData();

            errorDiv.style.display = "none";
            successDiv.style.display = "none";
        });

        dataForm.addEventListener('submit', function(e) {
            // console.clear();
            e.preventDefault();

            const xhr = new XMLHttpRequest();

            var name = document.getElementById('name').value;
            var weight = document.getElementById('weight').value;

            const radios = document.querySelectorAll('input[name="appetite"]');

            var appetite = null;

            radios.forEach(radio => {
                if (radio.checked) {
                    appetite = radio.value;
                }
            });

            if (task == "add") {
                const addBtn = document.getElementById('add-data-btn');

                const params = `name=${encodeURIComponent(name)}&weight=${weight}&appetite=${appetite}`;

                xhr.open("POST", "/php_template/app/add.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = this.response;

                        if (response) {
                            dataForm.reset();
                            errorDiv.style.display = "none";
                            successDiv.style.display = "flex";
                            successDiv.innerText = "Data added successfully!";
                        } else {
                            errorDiv.style.display = "flex";
                            successDiv.style.display = "none";
                            errorDiv.innerText = "Data couldn't be added!";
                        }
                        addBtn.innerText = "ADD NOW";
                    } else {
                        addBtn.innerText = "ADDING...";
                    }
                }

                xhr.send(params);
            } else {
                const updateBtn = document.getElementById('update-data-btn');

                const params = `id=${personId}&name=${encodeURIComponent(name)}&weight=${weight}&appetite=${appetite}`;

                xhr.open("POST", "/php_template/app/update.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = this.response;

                        console.log(response);

                        if (response) {
                            console.log("Data updated successfully!");
                        } else {
                            console.log("An error occurred!");
                        }
                        updateBtn.innerText = "UPDATE NOW";
                    } else {
                        updateBtn.innerText = "UPDATING...";
                    }
                }

                xhr.send(params);
            }
        });

        // fetch backup data fro editin gpurpose
        function backupData() {
            const xhr = new XMLHttpRequest();
            const params = "?id=<?= $id ?? 0 ?>";

            xhr.open("GET", "/php_template/app/fetch.php" + params, true);

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    console.log(response);

                    if (response['response']) {
                        document.getElementById('name').value = response['name'];
                        document.getElementById('weight').value = response['weight'];
                        if (response['appetite'] == "Hungry") {
                            document.getElementById('appetite-hungry').checked = true;
                        } else {
                            document.getElementById('appetite-not-hungry').checked = true;
                        }
                    }
                }
            }

            xhr.send();
        }

        if (task == "edit") {
            backupData();
        }
    </script>
</body>


</html>