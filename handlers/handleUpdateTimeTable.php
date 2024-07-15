<?php
include_once 'connect.php';
$nextWeek = strtotime('monday this week');
$firstOFnweek = date('Y-m-d', strtotime("monday", $nextWeek));
$lastOFnweek = date('Y-m-d', strtotime("monday +6 days", $nextWeek));
$getnextWeek = " SELECT doctorID,nextWeek,nWeekFrom,nWeekTo FROM timetable WHERE nextWeek BETWEEN '$firstOFnweek' AND '$lastOFnweek' ";
$resultgetnWeek = mysqli_query($conn,$getnextWeek);
if(!$resultgetnWeek){
    die($conn->error);
} else {
    while ($row = $resultgetnWeek->fetch_assoc()){
        $updatecurrentWeek = "UPDATE timetable SET currentWeek = '$row[nextWeek]', cWeekFrom = '$row[nWeekFrom]', cWeekTo = '$row[nWeekTo]', nextWeek = NULL, nWeekFrom = '00:00:00', nWeekTo = '00:00:00' WHERE doctorID = '$row[doctorID]' AND currentWeek IS NULL";
        $resultupdatecurrentWeek = mysqli_query($conn,$updatecurrentWeek);
        if(!$resultupdatecurrentWeek){
            die($conn->error);
        }
    }
    include_once 'handleUpdateAge.php';
    echo " <script>alert(' تم  تحديث الجدول بنجاح ');</script> ";
    header('Refresh: 1; URL=../Views/timeTable.php');
    die();
}