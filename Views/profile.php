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
    <link rel='stylesheet' href='../CSS/all.min.css'>
    <link rel='stylesheet' href='../CSS/normalize.css'>
    <link rel='stylesheet' href='../CSS/profile.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
    <title>الصفحة الشخصية</title>
    <?php include_once 'navbar.php'; ?>
</head>
<?php
if ($role == '4'){
    $getpData = "SELECT * FROM users INNER JOIN patients ON users.userID = patients.nationalID WHERE users.userID = $ID";
    $resultpData = mysqli_query($conn,$getpData);
    if ($resultpData ->num_rows > 0){
        $patientData = mysqli_fetch_assoc($resultpData);
        echo "<body>
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
                        <h1 class='m-3 pt-3'>معلومات شخصيه</h1>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>الاسم</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $patientData['name'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5> رقم الهاتف </h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $patientData['phone'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>رقم هاتف للطوارئ</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $patientData['emergencyContact'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>السن</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $patientData['age'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>الرقم القومي</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $patientData['nationalID'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>البريد الإليكتروني </h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $patientData['emailAddress'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>الجنس</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $patientData['gender'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>العنوان</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $patientData['address'] ?>
<?php echo"</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe' crossorigin='anonymous'></script>
    </body>";
    } else {
        header('Location:editProfile.php');
        die();
    }
    include_once 'footer.php';

} else if ($role == '1'){
    $getdData = "SELECT * FROM users INNER JOIN doctors ON users.userID = doctors.nationalID WHERE users.userID = '$ID'";
    $resultdData = mysqli_query($conn,$getdData);
    if ($resultdData ->num_rows > 0){
        $doctorData = mysqli_fetch_assoc($resultdData);
        $ID = $doctorData['ID'];
        echo "<body>
        <div class='container'>
            <div class='main'>
                <div class='row'>
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
                <div class='col-md-8 mt-1'>
                    <div class='card mb-3 content'>
                        <h1 class='m-3 pt-3'>معلومات شخصيه</h1>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>الاسم</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $doctorData['name'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>التخصص</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $doctorData['specialization'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>رقم الهاتف</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $doctorData['phone'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>السن</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $doctorData['age'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>الرقم القومي</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $doctorData['nationalID'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>البريد الإليكتروني </h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $doctorData['emailAddress'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>الجنس</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $doctorData['gender'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>العنوان</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $doctorData['address'] ?>
<?php echo"</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe' crossorigin='anonymous'></script>
    </body>";
    } else {
        header('Location:editProfile.php');
        die();
    }
    include_once 'footer.php';

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
                </div>
            <div class='col-md-8 mt-1'>
                <div class='card mb-3 content'>
                    <h1 class='m-3 pt-3'>معلومات شخصيه</h1>
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-3'>
                            <h5>القسم</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $nurseData['specialization'] ?>
<?php echo"</div>
                        </div>
                            <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                            <h5>الاسم</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $nurseData['name'] ?>
<?php echo"</div>
                        </div>
                            <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>رقم الهاتف</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $nurseData['phone'] ?>
<?php echo"</div>
                        </div>
                            <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>السن</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $nurseData['age'] ?>
<?php echo"
                            </div>
                        </div>
                            <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>الرقم القومي</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $nurseData['nationalID'] ?>
<?php echo"</div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>البريد الإليكتروني </h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $nurseData['emailAddress'] ?>
<?php echo"</div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>الجنس</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $nurseData['gender'] ?>
<?php echo"</div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>العنوان</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $nurseData['address'] ?>
<?php echo"</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe' crossorigin='anonymous'></script>
    </body>";
    } else {
        header('Location:editProfile.php');
        die();
    }
    include_once 'footer.php';

} else if ($role == '3'){
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
                </div>
            <div class='col-md-8 mt-1'>
                <div class='card mb-3 content'>
                    <h1 class='m-3 pt-3'>معلومات شخصيه</h1>
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>الاسم</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $receptionistData['name'] ?>
<?php echo"</div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>رقم الهاتف</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $receptionistData['phone'] ?>
<?php echo"</div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>السن</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $receptionistData['age'] ?>
<?php echo"</div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>الرقم القومي</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $receptionistData['nationalID'] ?>
<?php echo"</div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>البريد الإليكتروني </h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $receptionistData['emailAddress'] ?>
<?php echo"</div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>الجنس</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $receptionistData['gender'] ?>
<?php echo"</div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-3'>
                                <h5>العنوان</h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $receptionistData['address'] ?>
<?php echo"</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe' crossorigin='anonymous'></script>
    </body>";
    } else {
        header('Location:editProfile.php');
        die();
    }
    include_once 'footer.php';
} else if ($role == '100'){
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
                            <img src='Uploads/Images/" ?><?php echo $adminData['photo'] ?><?php echo"' class='rounded-circle' width='150'>
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
                        <h1 class='m-3 pt-3'>معلومات شخصيه</h1>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>الاسم</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $adminData['name'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <h5>رقم الهاتف</h5>
                                </div>
                                <div class='col-md-9 text-secondary'>" ?>
<?php echo $adminData['phone'] ?>
<?php echo"</div>
                            </div>
                            <hr>
                            <div class='row'>
                            <div class='col-md-3'>
                                <h5> السن </h5>
                            </div>
                            <div class='col-md-9 text-secondary'>" ?>
<?php echo $adminData['age'] ?>
<?php echo"</div>
                        </div>
                        <hr>
                        <div class='row'>
                        <div class='col-md-3'>
                            <h5> البريد الإليكتروني </h5>
                        </div>
                        <div class='col-md-9 text-secondary'>" ?>
<?php echo $adminData['emailAddress'] ?>
<?php echo"</div>
                    </div>
                    <hr>
                    <div class='row'>
                    <div class='col-md-3'>
                        <h5> عنوان السكن </h5>
                    </div>
                    <div class='col-md-9 text-secondary'>" ?>
<?php echo $adminData['address'] ?>
<?php echo"</div>
                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe' crossorigin='anonymous'></script>
    </body>";
include_once 'footer.php';
}
}
?>

</html>