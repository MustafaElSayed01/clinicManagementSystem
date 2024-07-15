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
$getSpecializations = " SELECT DISTINCT(name) FROM specializations WHERE nurseID IS NULL";
$resultgetSpecs = mysqli_query($conn, $getSpecializations);
if (!$resultgetSpecs) {
    die($conn->error);
}
$getNurses = " SELECT ID,name,specialization FROM nurses WHERE specialization IS NULL";
$resultgetNurses = mysqli_query($conn, $getNurses);
if (!$resultgetNurses) {
    die($conn->error);
}
?>
<!DOCTYPE html>
<html dir='rtl' lang='ar'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="stylesheet" href="../CSS/editNurseSpecs.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
    <title> تعديل تخصصات الممرضين </title>
</head>

<body>
    <?php include_once 'navbar.php'; ?>
    <!-- Set Nurse -->
    <div class='container'>
        <div class='main'>
            <div class='row'>
            <div class='col-md-4 mt-1'>
                        <div class='crad-body'>
                            <img src='Uploads/Images/<?php echo $adminData['photo'] ?><?php echo"' class='rounded-circle' width='150'>
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
                <form method='POST' action='../handlers/handleNurseSpecs.php'>
                    <Label> القسم: </Label>
                    <select name='spec'>
                            <option></option>"; ?>
                                    <?php 
        while ($row = $resultgetSpecs->fetch_assoc()) {
            echo " <option value = '" . $row['name'] . "'> " . $row['name'] . " </option>";
        }
        ?>
                    </select>
                    <Label> الممرض المسؤول: </Label>
                    <select name='nurseID'>
                        <option></option>
                        <?php 
        while ($row = $resultgetNurses->fetch_assoc()) {
            echo " <option value = '" . $row['ID'] . "'> " . $row['name'] . " </option>";
        }
        ?>
                    </select>
                    <input type='submit' name='assign' value='تعيين'>
                    <hr />
                </form>
                <!-- unSet Nurse -->
                <?php 
$getunSpecializations = " SELECT DISTINCT(name) FROM specializations WHERE nurseID IS NOT NULL";
$resultgetunSpecs = mysqli_query($conn, $getunSpecializations);
if (!$resultgetunSpecs) {
    die($conn->error);
}
$getunNurses = " SELECT ID,name,specialization FROM nurses WHERE specialization IS NOT NULL";
$resultgetunNurses = mysqli_query($conn, $getunNurses);
if (!$resultgetunNurses) {
    die($conn->error);
}
?>
                <form method='POST' action='../handlers/handleNurseSpecs.php'>
                    <Label> القسم: </Label>
                    <select name='spec'>
                        <option></option>
                        <?php 
        while ($row = $resultgetunSpecs->fetch_assoc()) {
            echo " <option value = '" . $row['name'] . "'> " . $row['name'] . " </option>";
        }
        ?>
                    </select>
                    <hr />
                    <Label> الممرض المسؤول: </Label>
                    <select name='nurseID'>
                        <option></option>
                        <?php 
        while ($row = $resultgetunNurses->fetch_assoc()) {
            echo " <option value = '" . $row['ID'] . "'> " . $row['name'] . " </option>";
        }
        ?>
                    </select>
                    <input type='submit' name='unAssign' value='حذف'>
                </form>
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