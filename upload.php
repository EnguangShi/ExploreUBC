<!DOCTYPE html>
<html>
<body>
<?php
    include 'connect.php';
    session_start();
    $db_conn = openCon();

    if ($db_conn->connect_error) {
      die("Connection failed: ". $db_conn->connect_error);
    }

    if(isset($_POST["submit"])) {
      $result = $db_conn -> query("insert into pub_post VALUES(DEFAULT,'".$_POST["LID"]."','". $_SESSION["pid"] ."','".date('Y-m-d')."','".$_POST['des']."')");
      $result = $db_conn -> query("SELECT PSID FROM pub_post WHERE PSID=(SELECT max(PSID) FROM pub_post);");
      $PSID = $result->fetch_assoc()["PSID"];
      if(!empty($_POST['fileToUpload1'])){
          $fileToUpload1 = $_POST['fileToUpload1'];
          $db_conn -> query("insert into Contain_Photo VALUES (DEFAULT, '$fileToUpload1', $PSID)");
      }
        if(!empty($_POST['fileToUpload2'])){$fileToUpload2 = $_POST['fileToUpload2'];
        $db_conn -> query("insert into Contain_Photo VALUES (DEFAULT, '$fileToUpload2', $PSID)");}
        if(!empty($_POST['fileToUpload3'])){$fileToUpload3 = $_POST['fileToUpload3'];
            $db_conn -> query("insert into Contain_Photo VALUES (DEFAULT, '$fileToUpload3', $PSID)");}
        if(!empty($_POST['fileToUpload4'])){$fileToUpload4 = $_POST['fileToUpload4'];
            $db_conn -> query("insert into Contain_Photo VALUES (DEFAULT, '$fileToUpload4', $PSID)");}
        if(!empty($_POST['fileToUpload5'])){$fileToUpload5 = $_POST['fileToUpload5'];
            $db_conn -> query("insert into Contain_Photo VALUES (DEFAULT, '$fileToUpload5', $PSID)");}
    }


    $db_conn->close();
    header("Location: home.php");
?>
</body>
</html>
