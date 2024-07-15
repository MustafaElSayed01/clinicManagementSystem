<?php
session_start();
include_once 'connect.php';
if (isset($_SESSION['Role'])) {
    $ID = $_SESSION['NID'];
    if($_SESSION['Role'] == '100'){
        $logged = "UPDATE admin SET isLogged = '0' WHERE userID = '$ID'";
        $result = mysqli_query($conn, $logged);
    } else {
    $logged = "UPDATE users SET isLogged = '0' WHERE userID = '$ID'";
    $result = mysqli_query($conn, $logged);
    }
    unset($_SESSION['Role']);
    unset($_SESSION['NID']);
    session_destroy();
}
header("Location:../Views/login.php");
die();
