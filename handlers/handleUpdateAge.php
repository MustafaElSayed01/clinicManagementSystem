<?php
include_once 'connect.php';
function getAge($NID){
    $bDecade = substr($NID,0,1);
    $bYear = substr($NID,1,2);
    $bMonth = substr($NID,3,2);
    $bDay = substr($NID,5,2);
    if ($bDecade == '2'){
        $year = '19' . $bYear;
    } elseif ($bDecade == '3'){
        $year = '20'. $bYear;
    }
    $fullDate = $year . '-' . $bMonth . '-' . $bDay;
    $bDate = new DateTime($fullDate);
    $today = new DateTime('today');
    $age = $bDate->diff($today)->y;
    return $age;
}
$getAdminsInfo = " SELECT nationalID FROM admin "; 
$resultAdminsInfo = mysqli_query($conn,$getAdminsInfo);
if(!$resultAdminsInfo){
    die($conn->error);
} else {
    while ($rowA = $resultAdminsInfo->fetch_assoc()){
        $age = getAge($rowA['nationalID']);
        $updateAdminsInfo = " UPDATE admin SET age = '$age' WHERE nationalID = '$rowA[nationalID]'";
        $resultuAdminsInfo = mysqli_query($conn,$updateAdminsInfo);
        if(!$resultuAdminsInfo){
            die($conn->error);
        }
    }
}
$getDoctorsInfo = " SELECT nationalID FROM doctors ";
$resultDoctorsInfo = mysqli_query($conn,$getDoctorsInfo);
if(!$resultDoctorsInfo){
    die($conn->error);
} else {
    while ($rowD = $resultDoctorsInfo->fetch_assoc()){
        $age = getAge($rowD['nationalID']);
        $updateDoctorsInfo = " UPDATE doctors SET age = '$age' WHERE nationalID = '$rowD[nationalID]'";
        $resultuDoctorsInfo = mysqli_query($conn,$updateDoctorsInfo);
        if(!$resultuDoctorsInfo){
            die($conn->error);
        }
    }
}
$getNursesInfo = " SELECT nationalID FROM nurses ";
$resultNursesInfo = mysqli_query($conn,$getNursesInfo);
if(!$resultNursesInfo){
    die($conn->error);
} else {
    while ($rowN = $resultNursesInfo->fetch_assoc()){
        $age = getAge($rowN['nationalID']);
        $updateNursesInfo = " UPDATE nurses SET age = '$age' WHERE nationalID = '$rowN[nationalID]'";
        $resultuNursesInfo = mysqli_query($conn,$updateNursesInfo);
        if(!$resultuNursesInfo){
            die($conn->error);
        }
    }
}
$getReceptionistsInfo = " SELECT nationalID FROM receptionists ";
$resultReceptionistsInfo = mysqli_query($conn,$getReceptionistsInfo);
if(!$resultReceptionistsInfo){
    die($conn->error);
} else {
    while ($rowR = $resultReceptionistsInfo->fetch_assoc()){
        $age = getAge($rowR['nationalID']);
        $updateReceptionistsInfo = " UPDATE receptionists SET age = '$age' WHERE nationalID = '$rowR[nationalID]'";
        $resultuReceptionistsInfo = mysqli_query($conn,$updateReceptionistsInfo);
        if(!$resultuReceptionistsInfo){
            die($conn->error);
        }
    }
}
$getPatientsInfo = " SELECT ID,nationalID FROM patients "; 
$resultPatientsInfo = mysqli_query($conn,$getPatientsInfo);
if(!$resultPatientsInfo){
    die($conn->error);
} else {
    while ($rowP = $resultPatientsInfo->fetch_assoc()){
        $age = getAge($rowP['nationalID']);
        $updatePatientsInfo = " UPDATE patients SET age = '$age' WHERE nationalID = '$rowP[nationalID]'";
        $updatePatientsLA = " UPDATE labanalysis SET age = '$age' WHERE patientID = '$rowP[ID]' ";
        $resultuPatientsInfo = mysqli_query($conn,$updatePatientsInfo);
        $resultuPatientsLA = mysqli_query($conn,$updatePatientsLA);
        if(!$resultuPatientsInfo){
            die($conn->error);
        }
    }
}