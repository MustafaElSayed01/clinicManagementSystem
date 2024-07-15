<?php
include_once 'connect.php';
$now = date ('Y-m-d H:i:s');
$timestamp = strtotime($now);
$timestamp += 3600;
$newTime = date('Y-m-d H:i:s', $timestamp);
$updateTime = "UPDATE reservationtable SET isAvailable = '0' WHERE '$newTime' >= reservedDateFrom";
$resultUpdateTime = mysqli_query($conn,$updateTime);
if (!$resultUpdateTime){
    die($conn->error);
}
?>