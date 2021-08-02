<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eat</title>
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
            width: 150%;
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
        <a href="eat.php">SHOW ALL</a>
        <a href="eat-asia.php">ASIAN FOOD</a>
        <a href="eat-ff.php">FAST FOOD</a>
        <a href="eat-hf.php">HEALTHY FOOD</a>
        <a href="eat-cf.php">COFFEE</a>
        <a href="eat-pz.php">PIZZA</a>
        <a href="home.php">RETURN</a>
    </div>

    <div>
        <div style="float:left;">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>OpenTime</th>
                    <th>CloseTime</th>
                </tr>
                
                <?php
                include 'connect.php';
                $db_conn= openCon();
        
                if ($db_conn->connect_error) {
                    die("Connection failed: ". $db_conn->connect_error);
                }
                
                $sql = "SELECT Name, Address, OpenTime, CloseTime FROM Location 
                        NATURAL JOIN Eatery_Menu
                        WHERE Eatery_Menu.Type LIKE 'Asia%'";
                $result = $db_conn->query($sql);
        
                if ($result->num_rows > 0) {
                    $x=0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>". '<a href = "postCollection.php?lid=$x++">'.$row["Name"].'</a>'."</td><td>". $row["Address"]."</td><td>". $row["OpenTime"]."</td><td>".
                        $row["CloseTime"]."</td></tr>";
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

        <div style="float: right;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d10414.24295319328!2d-123.25178443688809!3d49.26577116072483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sfast%20food!5e0!3m2!1sen!2sca!4v1623866562102!5m2!1sen!2sca" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</body>
</html>