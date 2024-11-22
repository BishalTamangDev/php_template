<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- title -->
    <title> View Data </title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- bootstrap css :: cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="/php_template/css/style.css">

    <style>
        .apetite {
            width: 80px;
            aspect-ratio: 1;
            background-color: whitesmoke;
        }
    </style>
</head>

<body>
    <!-- header -->
    <?php include 'sections/header.php'; ?>

    <main class="main container">
        <h1 class="mb-4 fw-bold text-secondary"> Person Detail </h1>

        <div class="person shadow p-3" id="detail-div">
            <div class="d-flex mb-3 rounded-circle apetite">
                <i class="fa fa-user m-auto fs-1 text-secondary"></i>
            </div>

            <div class="px-1">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="text-secondary"> Name </td>
                            <td id="person-name"> Loading... </td>
                        </tr>

                        <tr>
                            <td class="text-secondary"> Gender </td>
                            <td id="person-gender"> Loading... </td>
                        </tr>

                        <tr>
                            <td class="text-secondary"> Date of Birth </td>
                            <td id="person-date-of-birth"> Loading... </td>
                        </tr>

                        <tr>
                            <td class="text-secondary"> Height </td>
                            <td id="person-height"> Loading... </td>
                        </tr>

                        <tr>
                            <td class="text-secondary"> Is Frank </td>
                            <td id="person-is-frank"> Loading... </td>
                        </tr>

                        <tr>
                            <td class="text-secondary"> Mobile Brand </td>
                            <td id="person-mobile-brand"> Loading... </td>
                        </tr>

                        <tr>
                            <td class="text-secondary"> Description </td>
                            <td id="person-description"> Loading... </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- script section -->
    <script>
        const xhr = new XMLHttpRequest();
        const params = "?id=<?= $id ?>";

        xhr.open("GET", "/php_template/app/fetch.php" + params, true);

        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const response = JSON.parse(this.response);
                console.log(response);

                if (response['response']) {
                    document.getElementById('person-name').innerText = response['name'].charAt(0).toUpperCase() + response['name'].slice(1);
                    document.getElementById('person-gender').innerText = response['gender'].charAt(0).toUpperCase() + response['gender'].slice(1);
                    document.getElementById('person-date-of-birth').innerText = response['date_of_birth'];
                    document.getElementById('person-height').innerText = response['height'] + " ft";
                    document.getElementById('person-is-frank').innerText = response['is_frank'];
                    document.getElementById('person-mobile-brand').innerText = response['mobile_brand'].charAt(0).toUpperCase() + response['mobile_brand'].slice(1);
                    document.getElementById('person-description').innerText = response['description'].charAt(0).toUpperCase() + response['description'].slice(1);
                } else {
                    const msg = document.createElement('p');

                    msg.classList.add("text-danger");
                    msg.innerText = "Data not found!";

                    document.getElementById('detail-div').replaceWith(msg);
                }
            }
        }

        xhr.send();
    </script>
</body>

</html>