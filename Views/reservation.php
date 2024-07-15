<?php
session_start();
include_once '../handlers/connect.php';
include_once '../handlers/handleUpdateAvailableTime.php';
if(isset($_SESSION['NID']) && isset($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
} else {
    $role = 5;
}
$validRoles = array(3,4);
if (!in_array($role,$validRoles)){
    echo " <script>alert(' غير مسموح لك بالدخول ');</script> ";
    header('Refresh:1; URL = timeTable.php');
    die();
}
$today = date('Y-m-d');
$currentWeek = strtotime('monday this week');
$lastOFweek = date('Y-m-d', strtotime("monday +4 days", $currentWeek));
?>
<?php
if(isset($_GET['dID']) && $_GET['reservedDay']){
    $doctorID = htmlspecialchars($_GET['dID']);
    $reservedDay = htmlspecialchars($_GET['reservedDay']);
    $currentTime = date('H:i');
    $timestamp = strtotime($currentTime);
    $timestamp += 3600;
    $newTime = date('H:i', $timestamp);
    $getDoctorInfo = " SELECT doctors.ID,doctors.name,doctors.photo,doctors.specialization,doctors.description, doctors.reservationPrice, doctors.rate, doctors.rateCount, timetable.currentWeek, timetable.day FROM doctors INNER JOIN timetable ON doctors.ID = timetable.doctorID WHERE doctors.ID  = '$doctorID' AND timetable.day = '$reservedDay' AND timetable.currentWeek BETWEEN '$today' AND '$lastOFweek'";
    $getPatientInfo = "SELECT ID from patients WHERE nationalID =  '$ID'";
    $resultgetDoctorInfo = mysqli_query($conn, $getDoctorInfo);
    if (!$resultgetDoctorInfo) {
        die($conn->error);
    } else if ($resultgetDoctorInfo -> num_rows == 0) {
        header ('Location:timeTable.php');
        die();
    } else {
        $doctorInfo = $resultgetDoctorInfo->fetch_assoc();
        if($doctorInfo['rateCount'] != 0){
            $drRating = $doctorInfo['rate'] / $doctorInfo['rateCount']; 
        } else {
            $drRating = 0;
        }
    }
    $reservedTime = $doctorInfo['currentWeek'];
    $resultgetPatientInfo = mysqli_query($conn, $getPatientInfo);
    if (!$resultgetPatientInfo) {
        die($conn->error);
    } else {
        $patientInfo = $resultgetPatientInfo->fetch_assoc();
    }
    $getAvailableDoctorTime = "SELECT reservedDateFrom FROM reservationtable WHERE doctorID = '$doctorID' AND reservedDay = '$reservedDay' AND isAvailable = '1' AND isBusy = '0'";
    $resultgetADoctorTime = mysqli_query($conn, $getAvailableDoctorTime);
    if (!$resultgetADoctorTime) {
        die($conn->error);
    }
}
?>
<html lang='ar' dir='rtl'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='../CSS/all.min.css'>
    <link rel='stylesheet' href='../CSS/normalize.css'>
    <link rel='stylesheet' href='../CSS/reservation.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='preconnect' href='https://fonts.gstatic.com' />
    <link href='https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap' rel='stylesheet' />
    <title>تأكيد الحجز</title>
</head>

<body>
    <div class="all">
        <?php include_once 'navbar.php'; ?>
        <div class='container'>
            <div class='reservation'>
                <div class='doctor-info'>
                    <img src='Uploads/Images/<?php echo $doctorInfo['photo'] ?> '>
                    <div class='info'>
                        <br />
                        <label>الاسم:</label>
                        <p><?php echo $doctorInfo['name'] ?></p>
                        <label>التخصص:</label>
                        <p><?php echo $doctorInfo['specialization'] ?></p>
                        <label>سعر الكشف:</label>
                        <p><?php echo $doctorInfo['reservationPrice'] ?></p>
                        <label>نبذة:</label>
                        <p><?php echo $doctorInfo['description'] ?></p>
                        <label>التقييم:</label>
                        <p><?php echo $drRating ?></p>
                    </div>
                </div>
                <div class='book'>
                    <div class='reserve'>
                        <form action='../handlers/handleReservation.php' class='form' method='POST'>
                            <label> اليوم: </label>
                            <?php 
                        echo"
                        <input id = 'fdate' value = '" . $doctorInfo['currentWeek'] . "' name = 'reservationDate' disabled>
                        <input id = 'fday' name = 'dayAR' disabled>
                        <input name = 'dID' value = '" . $doctorInfo['ID'] . "' hidden>
                        <input name = 'reservationPrice' value = '" . $doctorInfo['reservationPrice'] . "' hidden>
                        <label> وقت الحجز:
                        <select name = 'reservedDate' required>
                        <option></option> ";?>
                            <?php
                        while ($doctorATime = $resultgetADoctorTime->fetch_assoc()){
                            $time = date('H:i', strtotime($doctorATime['reservedDateFrom'])); 
                            $datetime = strtotime($time);
                            $arabic_time = strftime('%I:%M %p', $datetime);
                            echo "<option value = '" . $doctorATime['reservedDateFrom'] . "'>" . $arabic_time . "</option> ";
                        }
                        ?>
                            </select>
                            </label>
                            <?php
                        if ($role == '3'){
                            echo "
                            <Label> اسم المريض: </Label>
                            <input type = 'text' name = 'pName'>
                            <Label> رقم الهاتف : </Label>
                            <input type = 'text' name = 'pPhone'>
                            <Label> الرقم القومي : </Label>
                            <input type = 'number' name = 'pNID'>
                            ";
                        }
                        ?>
                            <input type='submit' name='reserve' value='حجز'>
                        </form>
                    </div>
                </div>
                <footer>
                    <?php include_once 'footer.php';?>
                </footer>
                <script src="JS/reservation.js"></script>
                <script>
                var input = document.getElementById('fdate');
                const options = {
                    weekday: 'short'
                };
                var d = new Date(input.value);
                var arDay = (d.toLocaleDateString('ar-EG', options));
                document.getElementById('fday').value = arDay;
                </script>
</body>

</html>