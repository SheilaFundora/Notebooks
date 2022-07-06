<?php

session_start();
if( !empty($_SESSION['userId']) ){
    session_destroy();
    header("Location: signin.php");
}
header("Location: signin.php");

