<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="postCollection.css" />
</head>

<body>
    <?php
        echo "<div class =\"title\">";
        include 'connect.php';
        $conn = OpenCon();
        //get LID from url
        //$LID = 1;
        $LID = explode('=',$_SERVER["QUERY_STRING"])[1];

//        if(!empty($_POST['url1'])){
//            $sql = "INSERT INTO pub_post
//                    VALUES (DEFAULT,'".$LID."','".$_SESSION["pid"]."','".date('Y-h-d')."','".$_POST['description']."')
//                    ";
//            }
//            $conn -> query($sql);
//            $sql = "
//                    SELECT PSID
//                    FROM pub_post
//
//                    ";
//            $sql = "INSERT INTO contain_photo
//                    VALUES (DEFAULT,'".$_POST['url1']."','".$psid."')
//                    ";
//            $conn ->query($sql);
//
//        if(!empty($_POST['url2'])){
//            $sql = "INSERT INTO contain_photo
//                    VALUES (DEFAULT,'".$_POST['url2']."','".$psid."')
//                    ";
//            $conn ->query($sql);
//        }
//
//        if(!empty($_POST['url3'])){
//            $sql = "INSERT INTO contain_photo
//                    VALUES (DEFAULT,'".$_POST['url3']."','".$psid."')
//                    ";
//            $conn ->query($sql);
//        }

        //select name from location
        $sql = "SELECT Name 
                FROM location
                WHERE LID = {$LID}";

        $result = $conn -> query($sql);
        if($result->num_rows > 0){
            $row = $result -> fetch_assoc();
                echo "<h1>".$row["Name"]."</h1>";

        }
        echo "</div>";

        echo "<div class=\"container\">";
        $sql = "SELECT PSID
                FROM pub_post
                WHERE LID = {$LID}";
        $result = $conn -> query($sql);
        if($result->num_rows > 0){
            while($row = $result -> fetch_assoc()){
                $psid = $row["PSID"];
                $sql = "SELECT url
                        FROM contain_photo
                        WHERE PSID = {$psid}";
                $result1 = $conn -> query($sql);
                if($result->num_rows > 0){
                    while($row1 = $result1 -> fetch_assoc()){
                        echo "<div class=\"panel\" id =" . $psid . " style=\"background-image: url('" . $row1["url"] . "')\">";
                        echo "</div>";
                    }
                }
            }
        }
        CloseCon($conn);
        echo "</div>";
    ?>
    <script src = "index.js"></script>

</body>
</html>