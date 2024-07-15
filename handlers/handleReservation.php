<?php
session_start();
include_once 'connect.php';
if(isset($_SESSION['NID']) && ($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
} 
if(isset($_POST['reserve'])){
    $reservedDate = trim(htmlspecialchars($_POST['reservedDate']));
    $reservationPrice = trim(htmlspecialchars($_POST['reservationPrice']));
    $dID = trim(htmlspecialchars($_POST['dID']));
    if ($role == '3'){
        $pName = trim(htmlspecialchars($_POST['pName']));
        $pPhone = trim(htmlspecialchars($_POST['pPhone']));
        $pNID = trim(htmlspecialchars($_POST['pNID']));
    } else {
        $getUserInfo = "SELECT name,phone FROM patients WHERE nationalID = '$ID'";
        $resultgetUInfo = mysqli_query($conn, $getUserInfo);
        if ($resultgetUInfo ->num_rows > 0){
            $patientData = mysqli_fetch_assoc($resultgetUInfo);
        }
        $pName = $patientData['name'];
        $pPhone = $patientData['phone'];
        $pNID = $ID;
    }
    $reserve = " UPDATE reservationtable SET patientNID = '$pNID', patientName = '$pName', patientPhone = '$pPhone', price = '$reservationPrice', reservedBy = '$ID', isBusy = '1' WHERE reservedDateFrom = '$reservedDate' AND doctorID = '$dID'";
    $resultReserve = mysqli_query($conn, $reserve);
    if(!$resultReserve){
        die($conn->error);
    }
    $updatePatientProfile = $conn->prepare(" UPDATE patients SET toPay = toPay + ?, reservations = reservations + 1 WHERE nationalID = ? ");
    $updatePatientProfile->bind_param("ii", $reservationPrice, $pNID);
    $conn->autocommit(FALSE);
    $updatePatientProfile->execute();
    $conn->commit();
    if($role == '4'){
        echo " <script>alert(' تم حجز الموعد بنجاح ');</script> ";
        header('Refresh:1 ; URL = ../Views/reservations.php');
        die(); 
    } else{
        echo " <script>alert(' تم حجز الموعد بنجاح ');</script> ";
        header('Refresh:1 ; URL = ../Views/index.php');
        die(); 
    }
}