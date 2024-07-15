<?php
session_start();
include 'connect.php';
if(isset($_POST['addSpec'])){
    $spec = trim(htmlspecialchars($_POST['addSpecName']));
    $addSpec = " INSERT INTO specializations (name) VALUES ('$spec') ";
    $resultaddSpec = mysqli_query($conn, $addSpec);
    if (!$resultaddSpec){
        die($conn->error);
    } else {
        echo " <script>alert(' تمت الإضافة بنجاح ');</script> ";
        header('Refresh:1 ; URL = ../Views/editSpecs.php');
        die();
    }
}
if(isset($_POST['deleteSpec'])){
    $spec = trim(htmlspecialchars($_POST['deleteSpecName']));
    $deleteSpec = " DELETE FROM specializations WHERE name = '$spec' ";
    $resultdeleteSpec = mysqli_query($conn, $deleteSpec);
    if (!$resultdeleteSpec){
        die($conn->error);
    } else {
        $unAssignDoctor = " UPDATE doctors SET specialization = NULL WHERE specialization = '$spec' ";
        $unAssignNurse = " UPDATE nurses SET specialization = NULL WHERE specialization = '$spec' ";
        $resultunADoctor = mysqli_query($conn,$unAssignDoctor);
        $resultunANurse = mysqli_query($conn,$unAssignNurse);
        echo " <script>alert(' تم الحذف بنجاح ');</script> ";
        header('Refresh:1 ; URL = ../Views/editSpecs.php');
        die();
    }
}
?>