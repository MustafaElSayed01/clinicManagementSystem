<?php
session_start();
include_once '../handlers/connect.php';
if(isset($_SESSION['NID']) && ($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
}
$validRoles = array(2);
if (!in_array($role,$validRoles)){
    echo " <script>alert(' غير مسموح لك بالدخول ');</script> ";
    header('Refresh:1 ; URL = index.php');
    die($conn->error);
}
if ($role == '2'){    
    $getnData = "SELECT * FROM users INNER JOIN nurses ON users.userID = nurses.nationalID WHERE users.userID = '$ID'";
    $resultnData = mysqli_query($conn,$getnData);
    if ($resultnData ->num_rows > 0){
        $nurseData = mysqli_fetch_assoc($resultnData);
    }
}
$getNurseID = " SELECT ID FROM nurses WHERE nationalID = '$ID' ";
$resultNurseID = mysqli_query($conn, $getNurseID);
if ($resultNurseID ->num_rows > 0){
    $data = mysqli_fetch_assoc($resultNurseID);
    $nID = $data['ID'];
}
$sequence = 1;
$today = date('Y-m-d',strtotime('today'));
$tomorrow = date('Y-m-d',strtotime('tomorrow'));
$shownData = " SELECT reservationtable.ID, reservationtable.patientName, reservationtable.patientNID, reservationtable.reservedDateFrom, reservationtable.reservedDayAR, reservationtable.prescription, doctors.name FROM reservationtable INNER JOIN specializations ON reservationtable.doctorID = specializations.doctorID INNER JOIN nurses ON specializations.nurseID = nurses.ID INNER JOIN doctors ON reservationtable.doctorID = doctors.ID WHERE nurses.ID = '$nID' AND isBusy = '1' AND reservedDateFrom BETWEEN '$today' AND '$tomorrow' ORDER BY reservedDateFrom ASC ";
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
    <link rel="stylesheet" href="../CSS/nurseReservations.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
    <title> جدول اليوم </title>
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
                <img src='Uploads/Images/" ?><?php echo $nurseData['photo'] ?><?php echo"' class='rounded-circle' width='150'>
                    <div class='mt-3 sidebar'>
                    <h3>" ?>
    <?php
                    $name = explode(' ',$nurseData['name']);
                    echo $name[0] . ' ' . $name[1] ?>
    <?php echo "</h3>
                            <a href='index.php'>الصفحه الرئيسيه</a>
                            <a href='editProfile.php'>تعديل البيانات</a>
                            <a href='changePassword.php'>تغيير كلمة المرور</a>
                            <a href='nurseReservations.php'>جدول اليوم</a>
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
                <th>اسم الدكتور:</th>
                <th>الملف الشخصي:</th>
            </tr>
";
while ($row = $resultShownData->fetch_assoc()) {
    $pNID = $row['patientNID'];
    $rID = $row['ID'];
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
    <td>" . $row['name'] . "</td>    
    <td><a href = 'patientProfile.php?view=n&ID=$rID'>ملف المريض</a></td>
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

</body>
<footer>
    <?php include_once 'footer.php'; ?>
</footer>

</html>