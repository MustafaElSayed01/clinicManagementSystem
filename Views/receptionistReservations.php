<?php
session_start();
include_once '../handlers/connect.php';
if(isset($_SESSION['NID']) && ($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
}
$validRoles = array(100,3);
if (!in_array($role,$validRoles)){
    echo " <script>alert(' غير مسموح لك بالدخول ');</script> ";
    header('Refresh:1 ; URL = index.php');
    die();
} 
$getrData = "SELECT * FROM users INNER JOIN receptionists ON users.userID = receptionists.nationalID WHERE users.userID = '$ID'";
$resultrData = mysqli_query($conn,$getrData);
if ($resultrData ->num_rows > 0){
    $receptionistData = mysqli_fetch_assoc($resultrData);
}
$sequence = 1;
$today = date('Y-m-d',strtotime('today'));
$tomorrow = date('Y-m-d',strtotime('tomorrow'));
$shownData = "SELECT reservationtable.reservedDateFrom, reservationtable.reservedDayAR, reservationtable.patientName, reservationtable.patientNID, reservationtable.price, doctors.name, doctors.specialization FROM reservationtable INNER JOIN doctors ON reservationtable.doctorID = doctors.ID WHERE isBusy = '1' AND reservedDateFrom BETWEEN '$today' AND '$tomorrow' ORDER BY reservedDateFrom ASC ";
$resultShownData = $conn->query($shownData);
if (!$resultShownData) {
    die($conn->error);
}
setlocale(LC_TIME, 'ar_SA.utf8');
function getAge($NID){
    $bDecade = substr($NID,0,1);
    $bYear = substr($NID,1,2);
    $bMonth = substr($NID,3,2);
    $bDay = substr($NID,5,2);
    if($bDecade == 2){
        $year = '19' . $bYear;
    } elseif ($bDecade == 3){
        $year = '20'. $bYear;
    }
    $fullDate = $year . '-' . $bMonth . '-' . $bDay;
    $bDate = new DateTime($fullDate);
    $today = new DateTime('today');
    $age = $bDate->diff($today)->y;
    return $age;
}
?>
<!DOCTYPE html>
<html dir='rtl' lang='ar'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="stylesheet" href="../CSS/receptionistReservations.css">
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
                <img src='Uploads/Images/" ?><?php echo $receptionistData['photo'] ?><?php echo"' class='rounded-circle' width='150' height = '150'>
                    <div class='mt-3 sidebar'>
                    <h3>" ?>
    <?php
                    $name = explode(' ',$receptionistData['name']);
                    echo $name[0] . ' ' . $name[1] ?>
    <?php echo "</h3>
                            <a href='index.php'>الصفحه الرئيسيه</a>
                            <a href='editProfile.php'>تعديل البيانات</a>
                            <a href='changePassword.php'>تغيير كلمة المرور</a>
                            <a href='receptionistReservations.php'>حجوزات اليوم</a>
                            <a href='timeTable.php'>جدول العيادة</a>
                            <a href='signup.php'> اضافه شخص</a>
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
                <th>اسم المريض:</th>
                <th>العمر:</th>
                <th>الملف الشخصي:</th>
                <th>العيادة:</th>
                <th>اسم الدكتور:</th>
                <th>سعر الكشف:</th>
            </tr>
";
while ($row = $resultShownData->fetch_assoc()) {
    $pNID = $row['patientNID'];
    $pAge = getAge($pNID);
    $date = date("Y-m-d", strtotime($row['reservedDateFrom']));
    $time = date('H:i', strtotime($row['reservedDateFrom']));
    $datetime = strtotime($time);
    $arabic_time = strftime('%I:%M %p', $datetime);
    echo "<tr>
    <td>" . $sequence . "</td>
    <td>" . $date . "</td>
    <td>" . $row['reservedDayAR'] . "</td>
    <td>" . $arabic_time  . "</td>
    <td>" . $row['patientName'] . "</td>
    <td>" . $pAge . "</td>
    <td><a href = 'patientProfile.php?view=r&NID=$pNID'>ملف المريض</a></td>
    <td>" . $row['specialization'] . "</td>
    <td>" . $row['name'] . "</td>    
    <td>" . $row['price'] . "</td>    
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
    </div>
    <footer>
        <?php include_once 'footer.php'; ?>
    </footer>
</body>

</html>