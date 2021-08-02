<?php
session_start();
?>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="Post.css">
        <div class="d-flex justify-content-between">
            <div><h1><a href="home.php">Explore UBC</a></h1></div>
            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                echo "<div class='text-end'><a href='logout.php'>Log out</a>";
                echo " ";
                echo "<a href='userupload.php'>" . $_SESSION['username'] . "</a></div>";
            } else {
                echo "<div class='text-end'><a href='login.html'>Log in</a>";
                echo " ";
                echo "<a href='signup.html'>Sign up</a></div>";
            }
            ?>
        </div>
    </head>
    <body>
    <?php
        function pid2name($conn, $pid){
            $sql = "SELECT Username
                            FROM people
                            WHERE PID = {$pid}
                            ";
            $result1 = $conn -> query($sql);
            $row = $result1 -> fetch_assoc();
            return $row["Username"];
        }

        $cur_pid = $_SESSION["pid"];
        include 'connect.php';
        $conn = OpenCon();
        $psid = explode('=',$_SERVER["QUERY_STRING"])[1];
        //check if deleted
        if(isset($_POST['delete']) and $_POST['delete'] === "1"){
            $sql = "SELECT LID
                    FROM pub_post
                    WHERE PSID = {$psid}";
            $result = $conn -> query($sql);
            $lid = $result -> fetch_assoc()["LID"];
            $sql = "DELETE FROM pub_post
                    WHERE PSID = {$psid}";
            $conn -> query($sql);
            $sql = "INSERT INTO del_post
                    VALUES ('$psid','1','".date("Y-m-d")."')
                    ";
            $conn -> query($sql);
            header("Location: postCollection.php?lid=".$lid);
        }

        $admin_pid = 1;
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $ctime = isset($_POST['CTime']) ? $_POST['CTime'] : '';
        $unliked = "<svg t=\"1623700455701\" class=\"icon\" viewBox=\"0 0 1024 1024\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" p-id=\"1193\" width=\"200\" height=\"200\"><path d=\"M667.787 117.333c165.077 0 270.88 132.374 270.88 310.528 0 138.251-125.099 290.507-371.574 461.59a96.768 96.768 0 0 1-110.186 0C210.432 718.368 85.333 566.112 85.333 427.86c0-178.154 105.803-310.528 270.88-310.528 59.616 0 100.054 20.832 155.787 68.096 55.744-47.253 96.17-68.096 155.787-68.096z m0 63.147c-41.44 0-70.262 15.19-116.96 55.04-2.166 1.845-14.4 12.373-17.942 15.381a32.32 32.32 0 0 1-41.77 0c-3.542-3.018-15.776-13.536-17.942-15.381-46.698-39.85-75.52-55.04-116.96-55.04-126.026 0-206.88 100.779-206.88 246.219 0 110.901 113.526 248.544 344.299 408.128a32.352 32.352 0 0 0 36.736 0C761.141 675.253 874.667 537.6 874.667 426.699c0-145.44-80.854-246.219-206.88-246.219z\" p-id=\"1194\"></path></svg>";
        $liked = "<svg t=\"1623801895600\" class=\"icon\" viewBox=\"0 0 1024 1024\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" p-id=\"8485\" width=\"200\" height=\"200\"><path d=\"M958.33 323.99c0-142.85-114.22-258.66-255.12-258.66-76.67 0-145.44 34.3-192.21 88.58-46.81-54.28-115.6-88.58-192.31-88.58-141.03 0-255.36 115.91-255.36 258.9 0 59.09 19.53 113.56 52.39 157.13a260.56 260.56 0 0 0 18.85 22.27L495 952.38c8.39 10.45 24.14 10.45 32.53 0l361.43-450c0.91-1.14 1.68-2.36 2.34-3.65 3.05-3.37 6.02-6.83 8.89-10.36 36.33-44.69 58.14-101.95 58.14-164.38z\" fill=\"#d81e06\" p-id=\"8486\"></path></svg>";
        $comment = "<svg t=\"1623700752391\" class=\"icon\" viewBox=\"0 0 1024 1024\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" p-id=\"7077\" width=\"200\" height=\"200\"><path d=\"M535.04 896c-61.44 0-373.76-17.92-412.16-20.48-17.92 0-30.72-12.8-35.84-28.16-5.12-15.36 0-33.28 12.8-43.52 2.56-2.56 10.24-7.68 15.36-12.8C176.64 747.52 197.12 727.04 204.8 716.8c-40.96-64-64-138.24-64-215.04 0-112.64 48.64-220.16 130.56-294.4 84.48-74.24 194.56-110.08 307.2-97.28 181.76 20.48 327.68 166.4 348.16 348.16 12.8 112.64-23.04 225.28-97.28 307.2-74.24 81.92-181.76 130.56-294.4 130.56zM225.28 803.84c110.08 5.12 268.8 15.36 309.76 15.36 89.6 0 176.64-38.4 238.08-104.96 61.44-69.12 89.6-156.16 79.36-248.32-17.92-145.92-135.68-263.68-281.6-281.6-92.16-10.24-179.2 17.92-248.32 79.36-66.56 61.44-104.96 145.92-104.96 238.08 0 64 17.92 125.44 53.76 179.2 30.72 40.96-2.56 87.04-46.08 122.88zM128 798.72z\" p-id=\"7078\" fill=\"#2c2c2c\"></path></svg>";
        $favorite = "<svg t=\"1623801997649\" class=\"icon\" viewBox=\"0 0 1024 1024\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" p-id=\"10322\" width=\"200\" height=\"200\"><path d=\"M512.009505 25.054894l158.199417 320.580987 353.791078 51.421464L767.995248 646.579761l60.432101 352.365345-316.417844-166.354615-316.436854 166.354615 60.432101-352.365345L0 397.057345l353.791078-51.421464z\" fill=\"#EFCE4A\" p-id=\"10323\"></path></svg>";
        $unfavorite = "<svg t=\"1623882201821\" class=\"icon\" viewBox=\"0 0 1024 1024\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" p-id=\"3324\" width=\"200\" height=\"200\"><path d=\"M265.6 937.6c-12.8 0-27.2-4.8-38.4-12.8-19.2-14.4-28.8-35.2-27.2-59.2l24-240L64 446.4c-16-17.6-20.8-41.6-12.8-64s25.6-38.4 48-43.2L334.4 288 456 80c11.2-20.8 32-32 56-32s44.8 12.8 56 32l121.6 208 235.2 51.2c22.4 4.8 41.6 20.8 48 43.2s1.6 46.4-12.8 64L800 625.6l24 240c1.6 24-8 44.8-27.2 59.2-19.2 14.4-43.2 16-64 6.4l-220.8-96-220.8 97.6c-8 3.2-17.6 4.8-25.6 4.8zM512 771.2c9.6 0 17.6 1.6 25.6 4.8l220.8 97.6 1.6-1.6-24-240c-1.6-17.6 4.8-36.8 16-49.6l160-179.2 6.4-33.6-6.4 32L676.8 352c-17.6-3.2-33.6-14.4-41.6-30.4l-121.6-208H512l-121.6 208c-9.6 16-24 27.2-41.6 30.4L112 403.2v1.6L272 584c12.8 12.8 17.6 32 16 49.6l-24 240 1.6 1.6 220.8-97.6c8-4.8 16-6.4 25.6-6.4z\" p-id=\"3325\"></path></svg>";
        $delete_btn = "<svg t=\"1623880683025\" class=\"icon\" viewBox=\"0 0 1024 1024\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" p-id=\"1844\" width=\"200\" height=\"200\"><path d=\"M798.1 872.6c0 34.3-27.9 62.2-62.1 62.2H288.1c-34.3-0.1-62.1-27.9-62.2-62.2V212.8h572.2v659.8zM350.2 101.2c0-7.2 5.6-12.8 12.8-12.8h298.8c7.2 0 12.7 5.6 12.7 12.8v37.5H350.2v-37.5z m634.3 37.5H748.7v-37.5c0-47.8-39-86.9-86.9-86.9H363c-47.9 0.1-86.8 38.9-86.9 86.9v37.5H39.5C18.7 138.7 2 155.4 2 176.1s16.7 37.5 37.5 37.5H151v659c0 75.7 61.4 137.1 137.1 137.1h447.8c75.7 0 137.1-61.4 137.1-137.1V212.8h111.6c20.7 0 37.5-16.7 37.5-37.5s-16.8-36.6-37.6-36.6zM512 822.4c20.7 0 37.5-16.7 37.5-37.5V386.5c0-20.7-16.7-37.5-37.5-37.5-20.7 0-37.5 16.7-37.5 37.5v398.4c0 20.7 16.8 37.5 37.5 37.5m-174.5 0c20.7 0 37.5-16.7 37.5-37.5V386.5c0-20.7-16.7-37.5-37.5-37.5-20.7 0-37.5 16.7-37.5 37.5v398.4c0.8 20.7 17.6 37.5 37.5 37.5m349 0c20.7 0 37.5-16.7 37.5-37.5V386.5c0-20.7-16.7-37.5-37.5-37.5-20.7 0-37.5 16.7-37.5 37.5v398.4c0.1 20.7 16.8 37.5 37.5 37.5\" p-id=\"1845\" fill=\"#2c2c2c\"></path></svg>";

        echo "<div class = \"post-item\">";
            echo "<div class = \"post-item-header\">";
                echo "<div class = \"post-item-header-info\">";

                $sql = "SELECT PID, PTime, Description 
                        FROM pub_post
                        WHERE PSID = {$psid}";
                $result = $conn -> query($sql);
                if($result->num_rows > 0){
                    $row = $result -> fetch_assoc();
                    $ptime = $row["PTime"];
                    $Des = $row["Description"];
                    $post_pid = $row["PID"];

                    echo "<b>". pid2name($conn,$post_pid) . "</b>";
                    echo "<text class = \"faded\">" . $ptime . "</text>";
                }else{
                    echo "Cant find post according to PSID";
                }
                echo "</div>";
            echo "</div>";

            if(!empty($content)){
                $sql = "INSERT INTO write_comment
                        VALUES (DEFAULT,'". $cur_pid ."','". $psid ."','". $ctime ."','". $content ."')
                        ";
                $conn -> query($sql);
                $content = null;
            }

            //grab post image url
            echo "<div class = \"container\">";
            $sql = "SELECT PHID, url 
                    FROM contain_photo
                    WHERE PSID = {$psid}";
            $result = $conn -> query($sql);
            if($result->num_rows > 0){
                while($row = $result -> fetch_assoc()){
                    echo "<div class=\"panel\" id =" . $row["PHID"] . " style=\"background-image: url('" . $row["url"] . "')\">";
                    echo "</div>";
                }
            }
            echo "</div>";

            //update like information in db
            if(isset($_POST["like"])){
                //press like
                if($_POST["like"] === "1"){
                    $sql = "INSERT INTO press_like
                            VALUES ('".$cur_pid."','".$psid."','".date('Y-m-d H:i:s')."')";
                    $result = $conn -> query($sql);
                }
                //cancel like
                else{
                    $sql = "DELETE FROM press_like
                            WHERE PID = {$cur_pid} AND PSID = {$psid}
                            ";
                    $result = $conn -> query($sql);
                }
            }

            //update favortie information in db
            if(isset($_POST["favorite"])){
                //press favorite
                if($_POST["favorite"] === "1"){
                    $sql = "INSERT INTO favorite_post
                                    VALUES ('".$cur_pid."','".$psid."','".date('Y-m-d H:i:s')."')";
                    $result = $conn -> query($sql);
                }
                //cancel favorite
                else{
                    $sql = "DELETE FROM favorite_post
                                    WHERE PID = {$cur_pid} AND PSID = {$psid}
                                    ";
                    $result = $conn -> query($sql);
                }
            }


            $like_btn = $unliked;
            $cmt_btn = $comment;
            $favorite_btn = $unfavorite;
            $like_list = array();

            //check if this user likes this post
            $sql = "SELECT PID
                    FROM press_like
                    WHERE PSID = {$psid}";
            $result = $conn -> query($sql);
            if($result -> num_rows > 0){
                while($row = $result ->fetch_assoc()){
                    array_push($like_list,pid2name($conn, $row["PID"]));
                    if(intval($row["PID"]) === $cur_pid){
                        $like_btn = $liked;
                    }
                }
            }

            //check if this user favorite this post
            $sql = "SELECT PID
                            FROM favorite_post
                            WHERE PSID = {$psid}";
            $result = $conn -> query($sql);
            if($result -> num_rows > 0){
                while($row = $result ->fetch_assoc()){
                    if(intval($row["PID"]) === $cur_pid){
                        $favorite_btn = $favorite;
                    }
                }
            }

            $likeornot = $like_btn === $unliked ? 1 : 0;
            $favoriteornot = $favorite_btn === $unfavorite ? 1 : 0;
            $deleteornot = 1;
            echo "<div class = \"post-item-operation\">";
                echo "
                    <form action = \"post.php?psid=". $psid ."\" method=\"post\">
                        <div style='display: none'><input type=\"submit\" id = \"real_like\" class = \"real_btn\" name = \"like\" value = ".$likeornot."></div>
                        <div style='display: none'><input type='submit' id = \"real_comment\" class = 'real_btn' name = 'comment' value='1'></div>
                        <div style='display: none'><input type='submit' id = \"real_favorite\" class = 'real_btn' name = \"favorite\" value=".$favoriteornot."></div>
                        <div style='display: none'><input type='submit' id = \"real_delete\" class = 'real_btn' name = \"delete\" value=".$deleteornot."></div>
                    </form>
                    <a class = 'fake_icon' id = 'like' href='#'>$like_btn</a>
                        $cmt_btn
                    <a class = 'fake_icon' id = 'favorite' href='#'>$favorite_btn</a>";
                if($cur_pid === $admin_pid){
                    echo "<a class = 'fake_icon' id = 'delete' href='#'>$delete_btn</a>";
                }
            echo "</div>";

            echo "<div class = \"post-item-likelist\">";
                echo "<span>liked by <b>". implode(", ",$like_list).

                    "</b></span>";
            echo "</div>";
            echo "<div class = \"post-item-description\">";
                echo "<b class = \"post-item-description-content\">" . pid2name($conn, $post_pid) . "</b>";
                echo "<text class = \"post-item-description-content\">" . $Des . "</text>";
            echo "</div>";
            echo "<div>";
                echo "<hr>";
            echo "</div>";
            echo "<div>";
            echo "
                <form id = \"ops\" action = \"post.php?psid=". $psid ."\" method=\"post\">
                    <input type=\"hidden\" name=\"PSID\" value=\"" . $psid . "\">
                    <input type=\"hidden\" name=\"PID\" value=\"" . $cur_pid . "\">
                    <input type=\"hidden\" name=\"CTime\" value=\"" . date('Y-m-d H:i:s') . "\">
                    <textarea id = \"content\" name = \"content\" placeholder=\"Leave your comment here!\" cols='75'></textarea>
                    <br>
                    <input type=\"submit\" value = \"Send\">
                </form>
                ";
            echo "<div class = \"post-item-comments\">";
                $sql = "SELECT PID, CTime, Content
                        FROM write_comment
                        WHERE PSID = {$psid}";
                $result = $conn -> query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "
                        <div class = \"post-item-comment\">
                            <div class = \"post-item-comment-content\">
                                <span>
                                    <b>". pid2name($conn,$row["PID"]) ."</b>
                                    <text>". $row["Content"] ."</text>
                                </span>
                                <text class = \"faded\">". $row["CTime"] ."</text>
                            </div>
                        </div>
                        ";
                    }
                }
            echo "</div>";
        echo "</div>";
        CloseCon($conn);
        ?>
    <script src = "post.js"></script>
    <script src = "index.js"></script>
    </body>
</html>