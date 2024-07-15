<?php
session_start();
include_once 'connect.php';
if (isset($_POST['dTAssign'])){
    $dID = htmlspecialchars($_POST['dID']);
    $getDoctorSpecialization = " SELECT name FROM specializations WHERE doctorID = '$dID' ";
    $docSpecilaization = mysqli_query($conn, $getDoctorSpecialization);
    $row = mysqli_fetch_array($docSpecilaization);
    $getAllDoctors = " SELECT doctorID FROM specializations WHERE name = '$row[name]' ";
    $resultADoctors = mysqli_query($conn, $getAllDoctors);
    $IDs = array();
    while ($row = mysqli_fetch_array($resultADoctors)){
        $IDs[] = $row['doctorID'];
    }
    $reserveDate = htmlspecialchars($_POST['reserveDate']);
    $startoftheday = $reserveDate.' 00:00:00';
    $endoftheday = $reserveDate.' 23:59:59';
    foreach ($IDs as $ID) {
        $verify = " SELECT * FROM reservationtable WHERE doctorID = '$ID' AND reservedDateFrom BETWEEN '$startoftheday' AND '$endoftheday' ";
        $resultVerify = mysqli_query($conn, $verify);
        if ($resultVerify->num_rows > 0){
            echo " <script>alert(' لا يمكن وضع أكثر من طبيب من نفس القسم في نفس اليوم ');</script> ";
            header('Refresh:1 ; URL = ../Views/addNTimeTable.php');
            die();        
        }
    }
    $timeFrom = htmlspecialchars($_POST['timeFrom']);
    $timeTo = htmlspecialchars($_POST['timeTo']);
    $time1 = DateTime::createFromFormat('H:i', $timeFrom);
    $time2 = DateTime::createFromFormat('H:i', $timeTo);
    $diff = $time2->diff($time1);
    $diffString = $diff->format('%H');
    $count = $diffString * 4;
    $reserveDay = date('D', strtotime($reserveDate));
    $find = array(
    'Sat',
    'Sun',
    'Mon',
    'Tue',
    'Wed',
    'Thu',
    );
    $replace = array(
        'السبت',
        'الأحد',
        'الاثنين',
        'الثلاثاء',
        'الأربعاء',
        'الخميس',
    );
    $ar_day_format = $reserveDay;
    $ar_day = str_replace($find, $replace, $ar_day_format);
    $dInfo = "SELECT ID, name, specialization, reservationPrice FROM doctors WHERE doctors.ID = '$dID'";
    $resultInfo = mysqli_query($conn, $dInfo);
    if ($resultInfo ->num_rows > 0){
        $doctor_data = mysqli_fetch_assoc($resultInfo);
    }
    $dName = $doctor_data['name'];
    $price = $doctor_data['reservationPrice'];
    $dSpecialization = $doctor_data['specialization'];
    $dateTime = date('Y-m-d H:i:s', strtotime("$reserveDate $timeFrom"));
    for($i = 1; $i <= $count; $i++) {
        $futureTime = strtotime('+15 minutes',strtotime($dateTime));
        $endTime = date('Y-m-d H:i:s',$futureTime);
        $editRTable = " INSERT INTO reservationtable (doctorID,reservedDateFrom,reservedDateTo,price,reservedDay,reservedDayAR) VALUES ('$dID','$dateTime','$endTime','$price','$reserveDay','$ar_day')";
        $resulteRTable = mysqli_query($conn, $editRTable);
        if (!$resulteRTable) {
            die(" عذراً, لقد حدث خطأ, برجاء المحاولة مرة اخرى" . $conn->error);
        }
        $dateTime = $endTime;
    }
    $editTTable = "INSERT INTO timetable (day,dayAR,specialization,doctorName,doctorID,nextWeek,nWeekFrom,nWeekTo) VALUES ('$reserveDay', '$ar_day','$dSpecialization','$dName','$dID','$reserveDate','$timeFrom','$timeTo')";
    $resulteTTable = mysqli_query($conn, $editTTable);
    if (!$resulteTTable) {
        die(" عذراً, لقد حدث خطأ, برجاء المحاولة مرة اخرى" . $conn->error);
    } else {
        echo " <script>alert('  تم تحديث الجدول بنجاح  ');</script> ";
        header('Refresh:1 ; URL = ../Views/addNTimeTable.php?edit=add');
        die();
    }
}
else if (isset($_POST['dTDelete'])){
    $dID = htmlspecialchars($_POST['dID']);
    $reservedDate = htmlspecialchars($_POST['reservedDate']);
    $startoftheday = $reservedDate.' 00:00:00';
    $endoftheday = $reservedDate.' 23:59:59';
    $deleteTTRecord = "DELETE FROM timetable WHERE doctorID = '$dID' AND nextWeek = '$reservedDate'";
    $resultdTTRecord = mysqli_query($conn, $deleteTTRecord);
    if (!$resultdTTRecord){
        die(" عذراً, لقد حدث خطأ, برجاء المحاولة مرة اخرى" . $conn->error);
    } else {
        $deleteRTRecord = "DELETE FROM reservationtable WHERE doctorID = '$dID' AND reservedDateFrom BETWEEN '$startoftheday' AND '$endoftheday'";
        $resultdRTRecord = mysqli_query($conn, $deleteRTRecord);
        if ($resultdRTRecord){
            echo " <script>alert(' تم تحديث الجدول بنجاح ');</script> ";
            header('Refresh:1 ; URL = ../Views/nTimeTable.php');
            die();
        }
    }
}

