<!DOCTYPE html>
<html>
<body>
    <div>
        <img src="ubc-logo.jpg" alt="">
    </div>


<form action="upload.php" method="post" enctype="multipart/form-data">
  Select a location:
  <?php
    include 'connect.php';
  $conn = openCon();

  $result = $conn->query("select Name, LID from Location");

  echo "<html>";
  echo "<body>";
  echo "<select name ='LID'>";

  while ($row = $result->fetch_assoc()) {

      unset($name,$id);
      $id = $row['LID'];
      $name = $row['Name']; 
      echo '<option value="'.$id.'">'.$name.'</option>';

}

    echo "</select>";
    echo "</body>";
    echo "</html>";
    $conn -> close();
?> 
    <br>
    <br>
  Select images to upload:
  <div style="float: left;">
    <input type="text" name="fileToUpload1" id="fileToUpload">
    <input type="text" name="fileToUpload2" id="fileToUpload">
    <input type="text" name="fileToUpload3" id="fileToUpload">
    <input type="text" name="fileToUpload4" id="fileToUpload">
    <input type="text" name="fileToUpload5" id="fileToUpload">
    <input type="text" name="des" id="fileToUpload">
</div>
<br>
<br>
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>