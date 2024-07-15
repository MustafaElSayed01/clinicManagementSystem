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
    <link rel="stylesheet" href="../CSS/editProfile.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
    <title>تعديل البيانات الشخصية</title>
</head>

<body>
    <?php include_once 'navbar.php'; ?>
    
    <?php
if ($role == '4'){
    $getpData = "SELECT * FROM users INNER JOIN patients ON users.userID = patients.nationalID WHERE users.userID = '$ID'";
    $resultpData = mysqli_query($conn,$getpData);
    if ($resultpData ->num_rows > 0){
        $patientData = mysqli_fetch_assoc($resultpData);
    }
    echo "
    <div class='container'>
    <div class='main'>
        <div class='row'>
            <div class='col-md-4 mt-1'>
                <div class='crad-body'>
                <img src='Uploads/Images/" ?><?php echo $patientData['photo'] ?><?php echo"' class='rounded-circle' width='150' height = '150'>
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
            <div class='col-md-8 mt-1'>
                <div class='card mb-3 content'>
                    <div class='card-body'>
        <form method='POST' enctype='multipart/form-data'  class='form4' onsubmit='validPInputs()' action='../handlers/handleEditProfile.php'>
        <h2> الاسم </h2>
        <p>"; ?><?php echo $patientData['name']?><?php echo "</p>
        <label> رقم الهاتف </label>
        <input type='tel'  name='pPhone' min = '01000000000' max = '01599999999' id = 'phone' pattern='^01[0-2]\d{1,8}$' placeholder ='";?><?php echo $patientData['phone'] ?><?php echo "'>
        <label> رقم هاتف للطوارئ </label>
        <input type='tel' name='pEPhone' min = '01000000000' max = '01599999999' id = 'ePhone' pattern='^01[0-2]\d{1,8}$' placeholder ='";?><?php echo $patientData['emergencyContact'] ?><?php echo "'>
        <h2> الرقم القومي </h2>
        <p>"; ?><?php echo $patientData['nationalID']?><?php echo "</p>
        <label> البريد الإليكتروني </label>
        <input type='email' name='pEAddress' id = 'email' placeholder ='";?><?php echo $patientData['emailAddress'] ?><?php echo "'> 
        <label> عنوان السكن </label>
        <input type='text'  name='pAddress' id = 'address' placeholder ='";?><?php echo $patientData['address'] ?><?php echo "'> 
        <label> الصورة </label>
        <input type='file'  accept='image/png, image/jpeg' name='pPhoto' placeholder ='";?><?php echo $patientData['photo'] ?><?php echo "'> 
        <input type='submit' name ='pEdit' value='تعديل'>
        </form>
        </div>
        </div>
    </div>
    </div>
    </div>
    </div>    
    </body>
        <script src = 'JS/functions.js'></script>";
} else if ($role == '1'){
    $getdData = "SELECT * FROM users INNER JOIN doctors ON users.userID = doctors.nationalID WHERE users.userID = '$ID'";
    $resultdData = mysqli_query($conn,$getdData);
    if ($resultdData ->num_rows > 0){
        $doctorData = mysqli_fetch_assoc($resultdData);
    echo "    
    <div class='container'>
    <div class='main'>
        <div class='row'>
            <div class='col-md-4 mt-1'>
                <div class='crad-body'>
                <img src='Uploads/Images/" ?><?php echo $doctorData['photo'] ?><?php echo"' class='rounded-circle' width='150' height = '150'>
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
                    <div class='card-body'>
                        <form method='POST' enctype='multipart/form-data' class='form1' onsubmit='validDInputs()' action='../handlers/handleEditProfile.php'>
        <h2> الاسم </h2>
        <p>"; ?><?php echo $doctorData['name']?><?php echo "</p>
        <h2> التخصص </h2>
        <p>"; ?><?php echo $doctorData['specialization']?><?php echo "</p>
        <label> رقم الهاتف </label>
        <input type='tel'  name='dPhone' min = '01000000000' max = '01599999999' id = 'phone' pattern='^01[0-2]\d{1,8}$' placeholder = '";?><?php echo $doctorData['phone'] ?><?php echo "'>
        <h2> الرقم القومي </h2>
        <p>"; ?><?php echo $doctorData['nationalID']?><?php echo "</p>
        <label> البريد الإليكتروني </label>
        <input type='email'  name='dEAddress' id = 'email' placeholder = '"; ?><?php echo $doctorData['emailAddress'] ?><?php echo "'> 
        <label> عنوان السكن </label>
        <input type='text'  name='dAddress' id = 'address' placeholder = '"; ?><?php echo $doctorData['address'] ?><?php echo "'> 
        <label> نبذه عنك </label>
        <input type='text'  name='dDescription' id = 'description' placeholder = '"; ?><?php echo $doctorData['description'] ?><?php echo "'> 
        <label> الصورة </label>
        <input type='file'  name='dPhoto' accept='image/png, image/jpeg' placeholder = '"; ?><?php echo $doctorData['photo'] ?><?php echo "'>
        <input type='submit' name ='dEdit' value='تعديل'>
        </form>
        </div>
        </div>
    </div>
    </div>
    </div>
    </div>    
    </body>
    <script src =  'JS/functions.js'></script>";
    }
} else if ($role == '2'){
    $getnData = "SELECT * FROM users INNER JOIN nurses ON users.userID = nurses.nationalID WHERE users.userID = '$ID'";
    $resultnData = mysqli_query($conn,$getnData);
    if ($resultnData ->num_rows > 0){
        $nurseData = mysqli_fetch_assoc($resultnData);
    }
    echo "
    <div class='container'>
    <div class='main'>
        <div class='row'>
            <div class='col-md-4 mt-1'>
                <div class='crad-body'>
                <img src='Uploads/Images/" ?><?php echo $nurseData['photo'] ?><?php echo"' class='rounded-circle' width='150' height = '150'>
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
                    <div class='card-body'>
                        <form method='POST' enctype='multipart/form-data' class='form2' onsubmit='validNInputs()' action='../handlers/handleEditProfile.php'>
            <h2> الاسم </h2>
            <p>"; ?><?php echo $nurseData['name']?><?php echo "</p>
            <label>  القسم </label>
            <input disabled placeholder = '"; ?><?php echo $nurseData['specialization'] ?><?php echo "'>
            <label> رقم الهاتف </label>
            <input type='tel' name='nPhone' min = '01000000000' max = '01599999999' id = 'phone' pattern='^01[0-2]\d{1,8}$' placeholder = '"; ?><?php echo $nurseData['phone'] ?><?php echo "'>
            <h2> الرقم القومي </h2>
            <p>"; ?><?php echo $nurseData['nationalID']?><?php echo "</p>
            <label> البريد الإليكتروني </label>
            <input type='email' name='nEAddress' id = 'email' placeholder = '"; ?><?php echo $nurseData['emailAddress'] ?><?php echo "'> 
            <label> عنوان السكن </label>
            <input type='text' name='nAddress' id = 'address' placeholder = '"; ?><?php echo $nurseData['address'] ?><?php echo "'> 
            <label> الصورة </label>
            <input type='file' name='nPhoto' accept='image/png, image/jpeg' placeholder = '"; ?><?php echo $nurseData['photo'] ?><?php echo "'> 
            <input type='submit' name ='nEdit' value='تعديل'>
            </form>
            </div>
                </div>
    </div>
            </div>
        </div>
    </div>
        </body>
        <script src =  'JS/functions.js'></script>";
} else if ($role == '3'){
    $getrData = "SELECT * FROM users INNER JOIN receptionists ON users.userID = receptionists.nationalID WHERE users.userID = '$ID'";
    $resultrData = mysqli_query($conn,$getrData);
    if ($resultrData ->num_rows > 0){
        $receptionistData = mysqli_fetch_assoc($resultrData);
    }
    echo "
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
                    <div class='card-body'>
    <form method='POST' enctype='multipart/form-data' class='form3' onsubmit='validRInputs()' action='../handlers/handleEditProfile.php'>
            <h2> الاسم </h2>
            <p>"; ?><?php echo $receptionistData['name']?><?php echo "</p>
            <label> رقم الهاتف </label>
            <input type='tel' name='rPhone' min = '01000000000' max = '01599999999' id = 'phone' pattern='^01[0-2]\d{1,8}$' placeholder = '"; ?><?php echo $receptionistData['phone'] ?><?php echo "'>
            <h2> الرقم القومي </h2>
            <p>"; ?><?php echo $receptionistData['nationalID']?><?php echo "</p>
            <label> البريد الإليكتروني </label>
            <input type='email' name='rEAddress' id = 'email' placeholder = '"; ?><?php echo $receptionistData['emailAddress'] ?><?php echo "'> 
            <label> عنوان السكن </label>
            <input type='text' name='rAddress' id = 'address' placeholder = '"; ?><?php echo $receptionistData['address'] ?><?php echo "'> 
            <label> الصورة </label>
            <input type='file' name='rPhoto' accept='image/png, image/jpeg' placeholder = '"; ?><?php echo $receptionistData['phone'] ?><?php echo "'> 
            <input type='submit' name ='rEdit' value='تعديل'>
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </body>
        <script src = 'JS/functions.js'></script>";
} else if ($role == '100'){
    $getaData = "SELECT * FROM admin WHERE userID = '$ID' ";
    $resultaData = mysqli_query($conn,$getaData);
    if ($resultaData ->num_rows > 0){
        $adminData = mysqli_fetch_assoc($resultaData);
    }
    echo "
    <div class='container'>
    <div class='main'>
        <div class='row'>
            <div class='col-md-4 mt-1'>
                <div class='crad-body'>
                <img src='Uploads/Images/" ?><?php echo $adminData['photo'] ?><?php echo"' class='rounded-circle' width='150' height = '150'>
                    <div class='mt-3 sidebar'>
                    <h3>" ?>
    <?php
                    $name = explode(' ',$adminData['name']);
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
    <form method='POST' enctype='multipart/form-data' class= 'form100' onsubmit='validAInputs()' action='../handlers/handleEditProfile.php'>
        <h2> الاسم </h2>
        <p>"; ?><?php echo $adminData['name']?><?php echo "</p>
        <label> رقم الهاتف </label>
        <input type='tel' id = 'phone' placeholder = '";?><?php echo $adminData['phone'] ?><?php echo "' name='aPhone' min = '01000000000' max = '01599999999' pattern='^01[0-2]\d{1,8}$'>
        <h2> الرقم القومي </h2>
        <p>"; ?><?php echo $adminData['nationalID']?><?php echo "</p>
        <label> البريد الإليكتروني </label>
        <input type='email' id = 'email' placeholder = '";?><?php echo $adminData['emailAddress'] ?><?php echo "' name='aEAddress'> 
        <label> عنوان السكن </label>
        <input type='text' id = 'address' placeholder = '";?><?php echo $adminData['address'] ?><?php echo "' name='aAddress'> 
        <label> الصورة </label>
        <input type='file' placeholder = '";?><?php echo $adminData['photo'] ?><?php echo "' name='aPhoto' accept='image/png, image/jpeg'> 
        <input type='submit' name ='aEdit' value='تعديل'>
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </body>
            <script src = 'JS/functions.js'></script>";

}
include_once 'footer.php';
?>

</html>




