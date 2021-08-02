<?php
// destory session and refresh homepage
session_start();
session_unset();
session_destroy();
header("location:home.php");
exit();
?>