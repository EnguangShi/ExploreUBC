<?php
// enable the session variable that requires logged-in status
session_start();
?>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <title>
            Explore UBC
        </title>
        <div class="d-flex justify-content-between">
            <div><h1><a href="/304project/home.php">Explore UBC</a></h1></div>
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    echo "<div class='text-end'><a href='/304project/logout.php'>Log out</a>";
                    echo " ";
                    echo "<a href='/304project/userupload.php'>" . $_SESSION['username'] . "</a></div>";
                } else {
                    echo "<div class='text-end'><a href='/304project/login.html'>Log in</a>";
                    echo " ";
                    echo "<a href='/304project/signup.html'>Sign up</a></div>";
                }
            ?>
        </div>
    </head>
    <body>
        <br><br><br><br><br>
        <div class='text-center fs-1'><a href="/304project/eatery.php">Eatery</a></div><br>
        <div class='text-center fs-1'><a href="/304project/building.php">Building</a></div><br>
        <div class='text-center fs-1'><a href="/304project/attraction.php">Attraction</a></div>
    </body>
</html>

