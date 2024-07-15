<?php
session_start();
include_once 'connect.php';

if(isset($_POST['rate'])){
    $dID = trim(htmlspecialchars($_POST['doctorID']));
    $rating = trim(htmlspecialchars($_POST['rating']));
    $RTID = trim(htmlspecialchars($_POST['rtID']));
    $rate = $conn->prepare(" UPDATE doctors SET rateCount = rateCount + 1, rate = rate + ? WHERE ID = ? ");
    $rate->bind_param("ii", $rating, $dID);
    $updateRTable = " UPDATE reservationtable SET isRated = '1' WHERE ID = '$RTID' ";
    $conn->autocommit(FALSE);
    $rate->execute();
    $result = mysqli_query($conn,$updateRTable);
    $conn->commit();
    echo " <script>alert(' تم التقييم بنجاح ');</script> ";
    header('Refresh:1 ; URL = ../Views/pastReservations.php');
    die(); 
}