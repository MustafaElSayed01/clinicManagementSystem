<?php
session_start();
include 'connect.php';
if(isset($_POST['assign'])){
    $spec = trim(htmlspecialchars($_POST['spec']));
    $nurseID = trim(htmlspecialchars($_POST['nurseID']));
    $setSpec = "UPDATE nurses SET specialization = '$spec' WHERE ID = '$nurseID'";
    $resultsetSpec = mysqli_query($conn, $setSpec);
    if (!$resultsetSpec){
        die($conn->error);
    } else {
        $setNurse = " UPDATE specializations SET nurseID = '$nurseID' WHERE name = '$spec' ";
        $resultsetNurse = mysqli_query($conn, $setNurse);
        if (!$resultsetNurse){
            die($conn->error);
        } else {
            echo " <script>alert(' تم التعديل بنجاح ');</script> ";
            header('Refresh:1 ; URL = ../Views/editNurseSpecs.php');
            die();
        }
    }
}
if(isset($_POST['unAssign'])){
    $spec = trim(htmlspecialchars($_POST['spec']));
    $nurseID = trim(htmlspecialchars($_POST['nurseID']));
    $verifyInputs = " SELECT * FROM specializations INNER JOIN nurses ON specializations.nurseID = nurses.ID WHERE specializations.name = '$spec' AND nurses.ID = '$nurseID' ";
    $resultVInputs = mysqli_query($conn, $verifyInputs);
    if ($resultVInputs -> num_rows > 0){
        $unsetSpec = "UPDATE nurses SET specialization = NULL WHERE ID = '$nurseID'";
        $resultunsetSpec = mysqli_query($conn, $unsetSpec);
        if (!$resultunsetSpec){
            die($conn->error);
        } else {
            $unsetNurse = " UPDATE specializations SET nurseID = NULL WHERE name = '$spec' ";
            $resultunsetNurse = mysqli_query($conn, $unsetNurse);
            if (!$resultunsetNurse){
                die($conn->error);
            } else {
                echo " <script>alert(' تم التعديل بنجاح ');</script> ";
                header('Refresh:1 ; URL = ../Views/editNurseSpecs.php');
                die();
            }
        }
    } else {
        echo " <script>alert(' رجاء اختيار ممرض يعمل في القسم المختار ');</script> ";
        header('Refresh:1 ; URL = ../Views/editNurseSpecs.php');
        die();
    }
}
?>