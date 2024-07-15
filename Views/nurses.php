<?php
session_start();
include_once '../handlers/connect.php';
if(isset($_SESSION['NID']) && ($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
}
$validRoles = array(100);
if (!in_array($role,$validRoles)){
    echo " <script>alert(' غير مسموح لك بالدخول ');</script> ";
    header('Refresh:1 ; URL = index.php');
    die();
}
$getaData = " SELECT * FROM admin WHERE userID = '$ID'";
    $resultaData = mysqli_query($conn,$getaData);
    if ($resultaData ->num_rows > 0){
        $adminData = mysqli_fetch_assoc($resultaData);
    }
$sequence = 1;
$shownData = " SELECT * FROM nurses ";
$resultShownData = $conn->query($shownData);
if (!$resultShownData) {
    die($conn->error);
} 
?>
<!DOCTYPE html>
<html dir='rtl' lang='ar'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="stylesheet" href="../CSS/nurses.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
    <title>  الممرضين  </title>
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
            <img src='Uploads/Images/"; ?><?php echo $adminData['photo'] ?><?php echo"' class='rounded-circle' width='150'>
            <div class='mt-3 sidebar'> 
                <h3>" ?>
                <?php $name = explode(' ',$adminData['name']);
                echo $name[0] . ' ' . $name[1] ?> 
            <?php echo "</h3>
            <a href='index.php'>الصفحه الرئيسيه</a>
            <a href='editProfile.php'>تعديل البيانات</a>
            <a href='changePassword.php'>تغيير كلمة المرور</a>
            <a href='timeTable.php'>جدول الاسبوع الحالي</a>
            <a href='nTimeTable.php'>جدول الاسبوع التالي</a>
            <a href='editNurseSpecs.php'>تخصصات الممرضين</a>
            <a href='editSpecs.php'>التخصصات </a>
            <a href='doctors.php'>الأطباء </a>
            <a href='nurses.php'>الممرضين </a>
            <a href='signup.php'> اضافه شخص</a>
            <a href='../handlers/handleLogout.php'> تسجيل الخروج</a>
        </div>
        </div>
    </div>
<div class='col-md-8 mt-1'>
<div class='card mb-3 content'>
<div class='card-body'>
        <table>
                <tr>
                    <th>التسلسل</th>
                    <th>الاسم:</th>
                    <th>السن:</th>
                    <th>التخصص:</th>
                    <th>ادارة:</th>
                </tr>
        ";
        while ($row = $resultShownData->fetch_assoc()) {
            echo "<tr>
                <td>" . $sequence . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['age'] . "</td>
                <td>" . $row['specialization'] . "</td>
                <td><a href = 'editNurseSpecs.php'> تعديل الأقسام </a></td>
            </tr>";
            $sequence++;
        }
        echo"</table>
        </form>
        </div>
        </div>

    </div>
</div>
</div>
</div>
<footer>";
include_once 'footer.php';
echo"
</footer>
</body>
</html>";

$conn->close();
?>