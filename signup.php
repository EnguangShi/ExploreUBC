<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <title>
            Explore UBC
        </title>
        <h1>
            <a href="/304project/home.html">Explore UBC</a>
        </h1>
    </head>
</html>

<?php
// execute a query
function executePlainSQL($cmdstr) { 
    global $conn;
    $result = $conn->query($cmdstr);
    return $result;
}

// open database
include 'connect.php';
$conn = OpenCon();

// get username, password, display from the form
$username = $_POST['username'];
$password = $_POST['password'];

// create a new account
$sql = "INSERT INTO People VALUES(DEFAULT, '$password', '$username');";
$sql .= "INSERT INTO Users VALUES(DEFAULT);";
if ($conn->multi_query($sql) === TRUE) {
    echo "<h2><div class='text-center'>Account Created Successfully!</div></h2>";
    echo "<br><div class='text-center'><a href='/304project/login.html'>Log in Now</a></div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// close database
$conn->close();
?>