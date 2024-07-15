<?php
session_start();
include_once '../handlers/connect.php';
if(isset($_SESSION['NID']) && ($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
}
$validRoles = array(100,4,3,2,1);
if (!in_array($role,$validRoles)){
    echo " <script>alert(' غير مسموح لك بالدخول ');</script> ";
    header('Refresh:1 ; URL = index.php');
    die();
}
?>
<!DOCTYPE html>
<html dir='rtl' lang='ar'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="stylesheet" href="../CSS/changePassword.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
    <title> تغيير كلمة المرور </title>
</head>

<body>
    <?php include_once 'navbar.php'; ?>
    <div class='container'>
        <div class='main'>
            <div class='row'>
                <?php
                if ($role == '4'){
                    $getpData = "SELECT * FROM users INNER JOIN patients ON users.userID = patients.nationalID WHERE users.userID = $ID";
                    $resultpData = mysqli_query($conn,$getpData);
                    if ($resultpData ->num_rows > 0){
                        $patientData = mysqli_fetch_assoc($resultpData);
                        echo "
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
                                                <a href='reservations.php'>الحجوزات</a>
                                                <a href='timeTable.php'>جدول العيادة</a>
                                                <a href='../handlers/handleLogout.php'> تسجيل الخروج</a>
                                            </div>
                                        </div>
                                    </div>
                                    ";
                    }
                }  else if ($role == '1'){
                    $getdData = "SELECT * FROM users INNER JOIN doctors ON users.userID = doctors.nationalID WHERE users.userID = '$ID'";
                    $resultdData = mysqli_query($conn,$getdData);
                    if ($resultdData ->num_rows > 0){
                        $doctorData = mysqli_fetch_assoc($resultdData);
                        $ID = $doctorData['ID'];
                        echo "
                                    <div class='col-md-4 mt-1'>
                                        <div class='crad-body'>
                                        <img src='Uploads/Images/" ?><?php echo $doctorData['photo'] ?><?php echo"' class='rounded-circle' width='150'>
                                        <div class='mt-3 sidebar'> 
                                                <h3>" ?>
                <?php
                                                $name = explode(' ',$doctorData['name']);
                                                echo $name[0] . ' ' . $name[1] ?>
                <?php echo "</h3>
                                                <a href=''>الصفحه الرئيسيه</a>
                                                <a href='editProfile.php'>تعديل البيانات</a>
                                                <a href='changePassword.php'>تغيير كلمة المرور</a>
                                                <a href='doctorProfile.php?view=reservations&month=current&ID=$ID'>الحجوزات</a>
                                                <a href='../handlers/handleLogout.php'> تسجيل الخروج</a>
                                            </div>
                                        </div>
                                    </div>
                                    ";
                    }
                } else if ($role == '2'){
                    $getnData = "SELECT * FROM users INNER JOIN nurses ON users.userID = nurses.nationalID WHERE users.userID = $ID";
                    $resultnData = mysqli_query($conn,$getnData);
                    if ($resultnData ->num_rows > 0){
                        $nurseData = mysqli_fetch_assoc($resultnData);
                        echo "<body>
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
                                </div>";
                    }
                }else if ($role == '3'){
                    $getrData = "SELECT * FROM users INNER JOIN receptionists ON users.userID = receptionists.nationalID WHERE users.userID = $ID";
                    $resultrData = mysqli_query($conn,$getrData);
                    if ($resultrData ->num_rows > 0){
                        $receptionistData = mysqli_fetch_assoc($resultrData);
                        echo "
                    <body>
                    <div class='container'>
                        <div class='main'>
                            <div class='row'>
                                <div class='col-md-4 mt-1'>
                                    <div class='crad-body'>
                                    <img src='Uploads/Images/" ?><?php echo $receptionistData['photo'] ?><?php echo"' class='rounded-circle' width='150'>
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
                                </div>";
                    }
                }else if ($role == '100'){
                    $getaData = " SELECT * FROM admin WHERE userID = '$ID'";
                    $resultaData = mysqli_query($conn,$getaData);
                    if ($resultaData ->num_rows > 0){
                        $adminData = mysqli_fetch_assoc($resultaData);
                        echo "<body>
                        <div class='container'>
                            <div class='main'>
                                <div class='row'>
                                    <div class='col-md-4 mt-1'>
                                        <div class='crad-body'>
                                            <img src='../Uploads/Images/" ?><?php echo $adminData['photo'] ?><?php echo"' class='rounded-circle' width='150'>
                                            <div class='mt-3 sidebar'> 
                                                <h3>" ?>
                <?php $name = explode(' ',$adminData['name']);
                                                    echo $name[0] . ' ' . $name[1] ?>
                <?php 
                                                echo "</h3>
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
                                                ";
                    }
                }
                ?>
                <div class='col-md-8 mt-1'>
                    <div class='card mb-3 content'>
                        <div class='card-body'>
                            <form method='POST' class = 'form' enctype='multipart/form-data'
                                action='../handlers/handleChangePassword.php'>
                                <label> كلمة المرور الحالية </label>
                                <input type='password' name='cPassword' required>
                                <hr>
                                <label> كلمة المرور الجديدة </label>
                                <input type='password' name='nPassword' required>
                                <input type='submit' name='updatePassword' value='تغيير'>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <?php
            include_once 'footer.php';
        ?>
    </footer>
    <script src="../JS/changePass.js"></script>
</body>

</html>