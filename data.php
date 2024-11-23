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

        /* form */
        .form-section {
            width: 100%;
            display: flex;
            flex-direction: row;
            gap: 1rem;
            align-items: centers;
        }

        .title {
            width: 160px;
            padding-top: 0.4rem;
            margin-bottom: 0;
        }

        .data {
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- header -->
    <?php require 'sections/header.php'; ?>

    <main class="main container">
        <div class="d-flex flex-row flex-wrap gap-2 mb-4 justify-content-between">
            <h3 class="fw-bold text-secondary"> <?= $task == "add" ? "ADD DATA" : "EDIT DATA" ?> </h3>
            <a type="button" class="btn btn-outline-danger fit-content" id="form-reset-btn"> RESET </a>
        </div>

        <!-- error message -->
        <div class="alert alert-danger" role="alert" id="error-message-div">
            An error message appears here...
        </div>

        <!-- success message -->
        <div class="alert alert-success" role="alert" id="success-message-div">
            Success message appears here...
        </div>

        <!-- form -->
        <form method="POST" class="w-100 d-flex flex-column gap-3" id="data-from">
            <!-- name -->
            <div class="form-section d-flex flex-column flex-md-row">
                <label for="name" class="title"> Name </label>
                <input type="text" name="name" id="name" class="form-control data" placeholder="full name" required>
            </div>

            <!-- gender -->
            <div class="form-section d-flex flex-column flex-md-row">
                <label for="gender" class="form-label title"> Gender </label>

                <div class="d-flex flex-row gap-3 data">
                    <div class="d-flex flex-row gap-2 border rounded p-2">
                        <input type="radio" name="gender" id="gender-male" value="male" class="form-check-input" required>
                        <label for="gender-male" class="form-check-label"> Male </label>
                    </div>

                    <div class="d-flex flex-row gap-2 border rounded p-2">
                        <input type="radio" name="gender" id="gender-female" value="female" class="form-check-input" required>
                        <label for="gender-female" class="form-check-label"> Female </label>
                    </div>
                </div>
            </div>

            <!-- date of birth -->
            <div class="form-section d-flex flex-column flex-md-row">
                <label for="date-of-birth" class="form-label title"> Date of Birth </label>
                <input type="date" name="date-of-birth" id="date-of-birth" class="form-control fit-height data" required>
            </div>

            <!-- height -->
            <div class="form-section d-flex flex-column flex-md-row">
                <label for="height" class="form-label title"> Height </label>
                <input type="number" step="0.01" name="height" id="height" class="form-control data" placeholder="height in ft" required>
            </div>

            <!-- is frank -->
            <div class="form-section d-flex flex-column flex-md-row">
                <label for="frank" class="form-label title"> Is Frank </label>

                <select name="is-frank" id="is-frank" class="form-select data" required>
                    <option value="" selected hidden> [Yes || No] </option>
                    <option value="1"> Yes </option>
                    <option value="0"> No </option>
                </select>
            </div>

            <!-- mobile brand -->
            <div class="form-section d-flex flex-column flex-md-row">
                <label for="mobile-brand" class="form-label title"> Mobile Brand </label>

                <select name="mobile-brand" class="form-select data" id="mobile-brand" required>
                    <option value="" selected hidden> Mobile Brand </option>
                    <option value="apple"> Apple </option>
                    <option value="samsung"> Samsung </option>
                    <option value="oppo"> Oppo </option>
                    <option value="vivo"> Vivo </option>
                    <option value="redmi"> Redmi </option>
                    <option value="noia"> Nokia </option>
                </select>
            </div>

            <!-- description -->
            <div class="form-section d-flex flex-column flex-md-row">
                <label for="description" class="form-label title"> Description </label>
                <textarea name="description" id="description" class="form-control data" placeholder="description" required></textarea>
            </div>

            <!-- operation -->
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

            // getting values
            // name
            var name = document.getElementById('name').value;

            // gender
            const genderRadio = document.querySelectorAll('input[name="gender"]');

            var gender = null;

            genderRadio.forEach(radio => {
                if (radio.checked) {
                    gender = radio.value;
                }
            });

            // date of birth
            var dateOfBirth = document.getElementById('date-of-birth').value;

            // height
            var height = document.getElementById('height').value;

            // is frank
            var isFrank = document.getElementById('is-frank').value;

            // mobile brand
            var mobileBrand = document.getElementById('mobile-brand').value;

            // description
            var description = document.getElementById('description').value;

            if (task == "add") {
                const addBtn = document.getElementById('add-data-btn');

                const params = `name=${encodeURIComponent(name)}&gender=${gender}&date-of-birth=${dateOfBirth}&height=${height}&is-frank=${isFrank}&mobile-brand=${mobileBrand}&description=${encodeURIComponent(description)}`;

                xhr.open("POST", "/php_template/app/add.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onload = function() {
                    if (this.status == 200) {
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
                    }
                }

                xhr.onprogress = function() {
                    addBtn.innerText = "ADDING...";
                }

                xhr.onerror = function() {
                    errorDiv.style.display = "flex";
                    successDiv.style.display = "none";
                    errorDiv.innerText = "Data couldn't be added!";
                    addBtn.innerText = "ADD NOW";
                }

                xhr.send(params);
            } else if (task == "edit") {
                const updateBtn = document.getElementById('update-data-btn');

                const params = `id=${personId}&name=${encodeURIComponent(name)}&gender=${gender}&date-of-birth=${dateOfBirth}&height=${height}&is-frank=${isFrank}&mobile-brand=${mobileBrand}&description=${encodeURIComponent(description)}`;

                xhr.open("POST", "/php_template/app/update.php", true);
                
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = this.response;

                        console.log(response);

                        if (response) {
                            console.log("Data updated successfully!");
                        } else {
                            console.log("An error occurred! : " + response);
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

                        if (response['gender'] == "male") {
                            document.getElementById('gender-male').checked = true;
                        } else {
                            document.getElementById('gender-female').checked = true;
                        }

                        document.getElementById('date-of-birth').value = response['date_of_birth'];
                        document.getElementById('height').value = response['height'];
                        document.getElementById('description').value = response['description'];

                        document.getElementById('is-frank').value = response['is_frank'];

                        document.getElementById('mobile-brand').value = response['mobile_brand'];

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