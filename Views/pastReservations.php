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
    header('Refresh:1 ; URL = index.php');
    die();
}
$getpData = "SELECT * FROM users INNER JOIN patients ON users.userID = patients.nationalID WHERE users.userID = $ID";
$resultpData = mysqli_query($conn,$getpData);
if ($resultpData ->num_rows > 0){
    $patientData = mysqli_fetch_assoc($resultpData);
}
$getSpecializations = " SELECT DISTINCT(name) FROM specializations";
$resultgetSpecs = mysqli_query($conn, $getSpecializations);
if (!$resultgetSpecs) {
    die($conn->error);
}
$sequence = 1;
$current_time = date('y-m-d H:i:s');
$shownData = "SELECT reservationtable.ID, reservationtable.doctorID, reservationtable.reservedDateFrom, reservationtable.reservedDayAR, reservationtable.prescription, reservationtable.isRated, doctors.name, doctors.specialization, doctors.reservationPrice FROM reservationtable INNER JOIN doctors ON reservationtable.doctorID = doctors.ID WHERE reservationtable.reservedDateFrom < '$current_time' AND reservationtable.patientNID = '$ID' ORDER BY reservedDateFrom ASC ";
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
    <title>  سجل الحجز </title>
</head>
<style>
    
</style>
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
        <div class='card-body'>
        <ul class='switcher'>
        <li class='active' data-cat='.all'>جميع الأقسام</li>
        "; ?>
                    <?php 
                    while ($row = $resultgetSpecs->fetch_assoc()) {
                        $specName = explode(' ',$row['name']);
                        echo "<li data-cat='." . $specName[0] . "'>" . $row['name'] . "</li>";
                    }
                    ?>
                    <?php echo"
        </ul>
<table>
            <tr class='all أسنان أمراض عيون جلدية أنف '>
                <th>التسلسل</th>
                <th>التاريخ:</th>
                <th>اليوم:</th>
                <th>المعاد:</th>
                <th>العيادة:</th>
                <th>اسم الدكتور:</th>
                <th>سعر الكشف:</th>
                <th>التقرير:</th>
                <th>تقييم:</th>
            </tr>
";
while ($row = $resultShownData->fetch_assoc()) {
    $date = date("Y-m-d", strtotime($row['reservedDateFrom']));
    $time = date('H:i', strtotime($row['reservedDateFrom']));
    $datetime = strtotime($time);
    $arabic_time = date('h:i A', $datetime);
    $specName = explode(' ',$row['specialization']);
    echo "<tr class='all $specName[0]'>
    <td>" . $sequence . "</td>
    <td>" . $date . "</td>
    <td>" . $row['reservedDayAR'] . "</td>
    <td>" . $arabic_time  . "</td>
    <td class='$row[specialization]'>" . $row['specialization'] . "</td>
    <td>" . $row['name'] . "</td>
    <td>" . $row['reservationPrice'] . "</td>
    <td id = 'prescription'><img src='Uploads/Images/" ?><?php echo $row['prescription'] ?><?php echo"'> </td>";
    if($row['isRated'] == '0'){
        echo"
    <td>
    <form method ='POST' class='rating-form' action='../handlers/handleRating.php'><select name = 'rating'>
    <option></option>
    <option value = '1'>1</option>
    <option value = '2'>2</option>
    <option value = '3'>3</option>
    <option value = '4'>4</option>
    <option value = '5'>5</option>
    </select>
    <input type='hidden' name='doctorID' value = '$row[doctorID]'>
    <input type='hidden' name='rtID' value = '$row[ID]'>
    <input type='submit' name= 'rate' value= 'تأكيد'>
    </form></td>
    ";}
    echo"
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
<script src="../JS/pastResevations.js"></script>
</html>

