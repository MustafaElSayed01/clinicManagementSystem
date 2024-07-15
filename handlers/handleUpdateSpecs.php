<?php
include_once 'connect.php';
$getAssignedNurses = " SELECT name,nurseID FROM specializations WHERE nurseID IS NOT NULL";
$resultgetData = $conn->query($getAssignedNurses);
if (!$resultgetData) {
    die($conn->error);
}
$updateSpecializations = $conn->prepare(" UPDATE specializations SET nurseID = ? WHERE name = ?");
$updateSpecializations->bind_param("is", $nurseID, $specName);
while ($row = $resultgetData->fetch_assoc()) {
    $specName = $row['name'];
    $nurseID = $row['nurseID'];
    if ($updateSpecializations->execute()) {
        echo " <script>alert(' تم تحديث البيانات بنجاح ');</script> ";
        header('Refresh: 1; URL=../Views/editNurseSpecs.php');
        die();
    } else { 
        echo " <script>alert('  لم يتم  تحديث البيانات بنجاح ');</script> ";
        header('Refresh: 1; URL=../Views/editNurseSpecs.php');
        die();
    }
}
$updateSpecializations->close();
$conn->close();