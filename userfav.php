<?php
// enable the session variable that requires logged-in status
session_start();

// open database
include 'connect.php';
$conn = OpenCon();

// get the pid of the current user
$username = $_SESSION['username'];
$sql1 = $conn->prepare("SELECT pid FROM People WHERE username = ?");
$sql1->bind_param("s", $username);
$sql1->execute();
$result1 = $sql1->get_result();
$row1 = $result1->fetch_assoc();
$pid = $row1["pid"];

// select the first image from each favorite post
$sql2 = $conn->prepare("SELECT ftime, lid, name, psid, url, min(phid) as minphid 
FROM (SELECT name, url, ftime, phid, Pub_Post.psid, Pub_Post.lid
FROM Location, Pub_Post, Contain_Photo, Favorite_Post 
WHERE Favorite_Post.pid= ?  
AND Contain_Photo.PSID=Pub_Post.PSID 
AND Pub_Post.LID=Location.LID 
AND Favorite_Post.PSID=Pub_Post.PSID) a 
GROUP BY psid 
ORDER BY ftime;");
$sql2->bind_param("s", $pid);
$sql2->execute();
$result2 = $sql2->get_result();
?>

<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <style>
            .secondary {
                color: grey
            }
        </style>
        <title>
            Explore UBC
        </title>
        <h1>
            <a href="/304project/home.php">Explore UBC</a>
        </h1>
    </head>
    <body>
        <div class="text-center">
        <?php 
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            echo "<h2>" . $_SESSION['username'] . "'s " . 
            "<nav class='nav justify-content-center'><a class='nav-link active' href='/304project/userfav.php'>Favorites</a>" . 
            " / " . "<a class='nav-link secondary' href='/304project/userupload.php'>Uploads</a></nav>"; 
            echo "<br>";
            if ($result2->num_rows>0) {
                while($row2 = $result2->fetch_assoc()) {
                    echo "<a href='/304project/postCollection.php?lid=" . $row2['lid'] . "'>". 
                    $row2["name"] . "</a><br>" . 
                    "<a href='/304project/post.php?psid=" . $row2['psid'] . "'>
                    <img src=" . $row2['url'] . " style='width:512px;'><br>";
                }
            } else {
                echo "Nothing here for now! <br> Add some photos to your favorite list and you will see them here.";
            }
        } else {
            echo "User logged out, please return to <a href='/304project/home.php'>Homepage</a>";
        }
        ?>
        </div>
    </body> 
</html>