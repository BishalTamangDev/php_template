<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- title -->
    <title> External API </title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- bootstrap css :: cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="/php_template/css/style.css">

    <style>
        .user-image {
            width: 60px;
            height: 60px;
            border-radius: 0.6rem;
        }
    </style>
</head>

<body>
    <?php include 'sections/header.php';?>
    
    <main class="container main">
        <div class="d-flex flex-column gap-3" id="data-container">
            <p class="text-secondary"> Loading users... </p>
        </div>
    </main>

    <!-- bootstrap js :: cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        const xhr = new XMLHttpRequest();

        xhr.open("GET", "https://api.github.com/users", true);

        xhr.onload = function() {
            if(this.status == 200) {
                const users = JSON.parse(this.response);

                var output = "";

                for(var i in users) {
                    // console.log(users[i]);
                    output += '<div class="d-flex flex-row gap-3 shadow-sm p-2">';
                    output += '<img src="' + users[i].avatar_url + '" class="user-image">';

                    output += '<ul class="list-unstyled">';
                    output += '<li> ID : ' + users[i].id + '</li>';
                    output += '<li class="text-secondary"> ' + users[i].login + '</li>';
                    output += '</ul>';
                    
                    output += "</div>";
                }

                document.getElementById('data-container').innerHTML = output;
            }
        }

        xhr.onerror = function () {
            console.log("Network Error!");
        }

        xhr.send();
    </script>
</body>

</html>