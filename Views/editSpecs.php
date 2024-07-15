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
$getSpecializations = " SELECT DISTINCT(name) FROM specializations";
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
    <link rel="stylesheet" href="../CSS/editSpecs.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
    <title> تعديل التخصصات </title>
</head>

<body>
    <?php include_once 'navbar.php'; ?>
    <!-- See Specializations -->
    <div class='container'>
        <div class='main'>
            <div class='row'>
            <div class='col-md-4 mt-1'>
                        <div class='crad-body'>
                            <img src='Uploads/Images/<?php echo $adminData['photo'] ?><?php echo"' class='rounded-circle' width='150'>
                            <div class='mt-3 sidebar'> 
                                <h3>"; ?>
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
                            <Label> الاقسام: </Label>
                            <select id='specName' name='availableSpecs' onchange='updateValue()'>
                                <option></option>"; ?>
                                <?php 
        while ($row = $resultgetSpecs->fetch_assoc()) {
            echo " <option value = '" . $row['name'] . "'> " . $row['name'] . " </option>";
        }
        ?>
                            </select>
                            <br />
                            <a  class='a' id='spec' href=''>عرض التفاصيل</a>
                            <?php
if(isset($_GET['spec'])){
    $specName = htmlspecialchars($_GET['spec']);
    $getDoctorsInfo = " SELECT * FROM doctors WHERE specialization = '$specName' ";
    $getNurseInfo = " SELECT * FROM nurses WHERE specialization = '$specName' ";
    $resultGetDInfo = mysqli_query($conn, $getDoctorsInfo);
    if (!$resultGetDInfo){
        die($conn->error);
    } else {
        $resultGetNInfo = mysqli_query($conn, $getNurseInfo);
        if (!$resultGetNInfo){
            die($conn->error);
        } else {
            if ($resultGetNInfo ->num_rows > 0){
                $nurseData = mysqli_fetch_assoc($resultGetNInfo);
                echo " 
            <br/> <Label> الاطباء المختصه: </Label> <br/>"; 
            while ($row = $resultGetDInfo->fetch_assoc()) {
                echo " <input value = '" . $row['name'] . "' disabled> <br/> ";
            }
            echo " 
            <Label> الممرضة المختصه: </Label> <br/>";
            echo " <input value = '" . $nurseData['name'] . "' disabled> ";
            } else {
                echo " 
                <br/> <Label> الاطباء المختصه: </Label> <br/>"; 
                while ($row = $resultGetDInfo->fetch_assoc()) {
                    echo " <input value = '" . $row['name'] . "' disabled> <br/> ";
                }
            }
        }
    }
    echo "
<form method = 'POST' action = '../handlers/handleEditSpecs.php'>
    <input value='" . $specName . " ' name = 'deleteSpecName' hidden> 
    <input type='submit' name='deleteSpec' value='حذف القسم'>
</form>";
}
?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
                            <script>
                            function updateValue() {
                                var value = document.getElementById('specName').value;
                                var redirect = document.getElementById('spec');
                                redirect.href = 'editSpecs.php?spec=' + value;
                            }
                            </script>
                            <footer>
                                <?php include_once 'footer.php'; ?>
                            </footer>
</body>

</html>