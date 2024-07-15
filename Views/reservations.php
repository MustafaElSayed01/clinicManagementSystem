<?php
session_start();
include_once '../handlers/connect.php';
if(isset($_SESSION['NID']) && ($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
}
$validRoles = array(4);
if (!in_array($role,$validRoles)){
    echo " <script>alert(' غير مسموح لك بالدخول ');</script> ";
    header('Refresh:1 ; URL = profile.php');
    die($conn->error);
}
$getpData = "SELECT * FROM users INNER JOIN patients ON users.userID = patients.nationalID WHERE users.userID = $ID";
$resultpData = mysqli_query($conn,$getpData);
if ($resultpData ->num_rows > 0){
    $patientData = mysqli_fetch_assoc($resultpData);
}
$sequence = 1;
$now = date ('Y-m-d H:i:s');
$timestamp = strtotime($now);
$timestamp += 3600;
$newTime = date('Y-m-d H:i:s', $timestamp);
$shownData = "SELECT reservationtable.ID, reservationtable.doctorID, reservationtable.reservedDateFrom, reservationtable.reservedDayAR, reservationtable.prescription, doctors.name, doctors.specialization, doctors.reservationPrice FROM reservationtable INNER JOIN doctors ON reservationtable.doctorID = doctors.ID WHERE reservationtable.reservedDateFrom >= '$newTime' AND  reservationtable.patientNID = '$ID' ORDER BY reservedDateFrom ASC ";
$resultShownData = $conn->query($shownData);
if (!$resultShownData) {
    die($conn->error);
}
setlocale(LC_TIME, 'ar_SA.utf8');
?>
<!DOCTYPE html>
<html dir='rtl' lang='ar'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="stylesheet" href="../CSS/reservations.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
    <title> الحجوزات </title>
</head>

<body>
    <?php
include_once 'navbar.php';
echo"
<div class='container'>
<div class='main'>
    <div class='row'>
        <div class='col-md-4 mt-1'>
            <div class='crad-body'>
                <img src='Uploads/Images/" ?><?php echo $patientData['photo'] ?><?php echo"' class='rounded-circle' width='150'>
                <div class='mt-3 sidebar'> 
                    <h3>" ?>
    <?php $name = explode(' ',$patientData['name']);
                    echo $name[0] . ' ' . $name[1] ?>
    <?php echo "</h3>
                    <a href='index.php'>الصفحه الرئيسيه</a>
                    <a href='editProfile.php'>تعديل البيانات</a>
                    <a href='changePassword.php'>تغيير كلمة المرور</a>
                    <a href='timeTable.php'>جدول العيادة</a>
                    <a href='reservations.php'>الحجوزات</a>
                    <a href='pastReservations.php'>سجل الحجوزات</a>
                    <a href='../handlers/handleLogout.php'> تسجيل الخروج</a>
                </div>
            </div>
        </div>
    <div class='col-md-8 mt-1'>
        <div class='card mb-3 content'>
<table>
            <tr>
                <th>التسلسل</th>
                <th>التاريخ:</th>
                <th>اليوم:</th>
                <th>المعاد:</th>
                <th>العيادة:</th>
                <th>اسم الدكتور:</th>
                <th>سعر الكشف:</th>
                <th>حذف:</th>
            </tr>
";
while ($row = $resultShownData->fetch_assoc()) {
    $date = date("Y-m-d", strtotime($row['reservedDateFrom']));
    $time = date('H:i', strtotime($row['reservedDateFrom']));
    $datetime = strtotime($time);
    $arabic_time = strftime('%I:%M %p', $datetime);
    $prescrtiption = $row['prescription'];
    echo "<tr>
    <td>" . $sequence . "</td>
    <td>" . $date . "</td>
    <td>" . $row['reservedDayAR'] . "</td>
    <td>" . $arabic_time  . "</td>
    <td>" . $row['specialization'] . "</td>
    <td>" . $row['name'] . "</td>
    <td>" . $row['reservationPrice'] . "</td>
    <td><a href = '../handlers/handleCancelReservation.php?ID=" . $row['ID'] . "'>الغاء الحجز</a></td>
        </tr>";
            $sequence++;    
        }
        $conn->close();
        ?>
    </table>
    </div>
    </div>
    </div>
    </div>
    </div>
    <footer>
        <?php include_once 'footer.php'; ?>
    </footer>
</body>

</html>