<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>building</title>
    <style type="text/css">

        div.scrollmenu {
        background-color: #333;
        overflow: auto;
        white-space: nowrap;
        }

        div.scrollmenu a {
        display: inline-block;
        color: white;
        text-align: center;
        padding: 14px;
        text-decoration: none;
        }

        div.scrollmenu a:hover {
        background-color: #777;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            color: #d96459;
            font-family: monospace;
            font-size: 25px;
            text-align: left;
        }

        th {
            background-color:#d96459;
            color: white;
        }

        tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
</head>
<body>
    <div>
        <img src="ubc-logo.jpg" alt="">
        <div style="float:right;">
            <form action="/action_page.php">
                <input type="text" placeholder="Username" name="username">
                <input type="text" placeholder="Password" name="psw">
                <button type="submit">Login</button>
                <a href="upload.html">Upload</a>
            </form>
        </div>
    </div>

    <div class="scrollmenu">
        <a href="bd.php">SHOW ALL</a>
        <a href="bd-sc.php">SCIENCES</a>
        <a href="bd-art.php">ARTS</a>
        <a href="bd-ot.php">OTHERS</a>
        <a href="home.php">RETURN</a>
    </div>

    <div>
        <div style="float:left;">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Faculty</th>
                </tr>
                
                <?php
                include 'connect.php';
                $db_conn= openCon();
        
                if ($db_conn->connect_error) {
                    die("Connection failed: ". $db_conn->connect_error);
                }
        
                $sql = "SELECT Location.Name, Location.Address, Faculty.FName FROM Location 
                join Building ON Location.LID = Building.LID
                join Faculty ON Building.FID = Faculty.FID
                where Faculty.FName = 'Faculty of Arts'";
                $result = $db_conn->query($sql);
        
                if ($result->num_rows > 0) {
                    $x=0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>". '<a href = "postCollection.php?lid=$x++">'.$row["Name"].'</a>'."</td><td>". $row["Address"]."</td><td>". $row["FName"]."</td><tr>";
                    }
                    echo "</table>";
                }
                else {
                    echo "0 result";
                }
        
                $db_conn->close();
                ?>           
            </table>
        </div>

        <div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d10414.150275706144!2d-123.2568332015316!3d49.26621025671205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1subc%20building!5e0!3m2!1sen!2sca!4v1623880973801!5m2!1sen!2sca" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>        </div>
    </div>
</body>
</html>