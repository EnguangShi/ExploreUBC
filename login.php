<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <title>
            Explore UBC
        </title>
        <h1>
            <a href="/304project/home.php">Explore UBC</a>
        </h1>
    </head>
</html>

<?php

// enable the session variable that requires logged-in status
session_start();

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

// user log in
$sql = "SELECT * FROM People WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);
if ($result->num_rows === 1) {
    // set sessions
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $username = $_SESSION['username'];
    $sql1 = $conn->prepare("SELECT pid FROM People WHERE username = ?");
    $sql1->bind_param("s", $username);
    $sql1->execute();
    $result1 = $sql1->get_result();
    $row1 = $result1->fetch_assoc();
    $pid = $row1["pid"];
    $_SESSION['pid'] = $pid;
    echo "<h2><div class='text-center'>Logged in Successfully!</div></h2>";
    echo "<br><div class='text-center'><a href='/304project/home.php'>Homepage</a></div>";
} else {
    echo "<h2><div class='text-center'>Invalid Username & Password Pair</div></h2>";
    echo "<br><div class='text-center'><a href='/304project/login.html'>Retry</a></div>";
}

// close database
$conn->close();
?>