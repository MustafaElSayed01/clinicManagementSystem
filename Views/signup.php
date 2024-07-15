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
$getaData = " SELECT * FROM admin WHERE userID = '$ID'";
    $resultaData = mysqli_query($conn,$getaData);
    if ($resultaData ->num_rows > 0){
        $adminData = mysqli_fetch_assoc($resultaData);
    }
    $getrData = "SELECT * FROM users INNER JOIN receptionists ON users.userID = receptionists.nationalID WHERE users.userID = $ID";
    $resultrData = mysqli_query($conn,$getrData);
    if ($resultrData ->num_rows > 0){
        $receptionistData = mysqli_fetch_assoc($resultrData);
    }
$getSpecializations = " SELECT DISTINCT(name) FROM specializations";
$resultgetSpecs = mysqli_query($conn, $getSpecializations);
if (!$resultgetSpecs) {
    die($conn->error);
}
$getnSpecializations = " SELECT DISTINCT(name) FROM specializations WHERE nurseID IS NULL";
$resultgetsSpecs = mysqli_query($conn, $getnSpecializations);
if (!$resultgetsSpecs) {
    die($conn->error);
}
?>
<!DOCTYPE html>
<html lang='ar' dir="rtl">

<head>
    <link rel='stylesheet' href='../CSS/all.min.css'>
    <link rel='stylesheet' href='../CSS/normalize.css'>
    <link rel="stylesheet" href="../CSS/signup.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' rel='stylesheet'
        integrity='sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ' crossorigin='anonymous'>
        <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
    <title>تسجيل مستخدم</title>
</head>

<body>
    <?php include_once 'navbar.php'; ?>
    <!-- Admin -> '100'
    Dr -> '1'
    Nurse -> '2'
    Receptionist -> '3'
    Patient -> '4' -->
    <div class='container'>
        <div class='main'>
            <div class='row'>
                <div class='col-md-4 mt-1'>
                    <div class='crad-body'>
                        <?php 
                            if($role == '100'){
                                echo"
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
            </div>
    <div class='col-md-8 mt-1'>
                    <div class='card mb-3 content'>
                        <div class='card-body'>
                        <h2>اضافه مشرف جديد</h2>
                            <form method='POST' class='form100' action='../handlers/handleSignups.php'>
                                    <label> الرقم القومي </label>
                                    <input type='number' name='aID' required>
                                    <br>
                                    <label> الاسم </label>
                                    <input type='text' name='aName' required>
                                    <label hidden >Role</label>
                                    <input value='100' name='aRole' hidden> 
                                    <br>
                                    <input type='submit' name ='aAssign' value='اضافه'>
                                    <input name = 'createdBy' value = '$ID' hidden>
                            </form>
                                <hr/>
                            <h2>اضافه دكتور جديد</h2>
                                <form method='POST' class='form1' action='../handlers/handleSignups.php'>
                                    <label> الرقم القومي </label>
                                    <input type='number' name='dID' required>
                                    <br>
                                    <label> الاسم </label>
                                    <input type='text' name='dName' required>
                                    <br/>
                                    <Label> القسم: </Label>
                                    <select name = 'dSpec'>
                                        <option></option>";
                                        while ($row = $resultgetSpecs->fetch_assoc()) {
                                            echo " <option value = '" . $row['name'] . "'> " . $row['name'] . " </option>";
                                        }
                                        echo "
                                    <label hidden >Role</label>
                                    <input value='1' name='dRole' hidden>
                                    <br/> 
                                    <input type='submit' name ='dAssign' value='اضافه'>
                                    <input name = 'createdBy' value = '$ID' hidden>
                                </form>
                                <hr>
                            <h2>اضافه ممرض جديد</h2>
                                <form method='POST' class='form2' action='../handlers/handleSignups.php'>
                                    <label> الرقم القومي </label>
                                    <input type='number' name='nID' required>
                                    <br>
                                    <label> الاسم </label>
                                    <input type='text' name='nName' required>
                                    <br>
                                    <Label> القسم: </Label>
                                    <select name = 'nSpec'>
                                        <option></option>";
                                        while ($row = $resultgetsSpecs->fetch_assoc()) {
                                            echo " <option value = '" . $row['name'] . "'> " . $row['name'] . " </option>";
                                        }
                                        echo "
                                    <label hidden >Role</label>
                                    <input value='2' name='nRole' hidden> 
                                    <br>
                                    <input type='submit' name ='nAssign' value='اضافه'>
                                    <input name = 'createdBy' value = '$ID' hidden>
                                </form>
                                <hr>
                            <h2>اضافه موظف استقبال جديد</h2>
                                <form method='POST' class='form3' action='../handlers/handleSignups.php'>
                                    <label> الرقم القومي </label>
                                    <input type='number' name='rID' required>
                                    <br>
                                    <label> الاسم </label>
                                    <input type='text' name='rName' required>
                                    <label hidden >Role</label>
                                    <input value='3' name='rRole' hidden> 
                                    <br>
                                    <input type='submit' name ='rAssign' value='اضافه'>
                                    <input name = 'createdBy' value = '$ID' hidden>
                                </form>
                                <hr>
                            <h2>اضافه مريض جديد</h2>
                                <form method='POST' class='form4' action='../handlers/handleSignups.php'>
                                    <label> الرقم القومي </label>
                                    <input type='number' name='pID' required>
                                    <br>
                                    <label> الاسم </label>
                                    <input type='text' name='pName' required>
                                    <label hidden >Role</label>
                                    <input value='4' name='pRole' hidden> 
                                    <br>
                                    <input type='submit' name ='pAssign' value='اضافه'>
                                    <input name = 'createdBy' value = '$ID' hidden>
                                </form>
                        </div>
                    </div>
                </div>";
    } else if($role == '3'){
        echo"
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
</div>
<div class='col-md-8 mt-1'>
<div class='card mb-3 content'>
<div class='card-body'>
<h2>اضافه مريض جديد</h2>
<form  method='POST' class='form11'  enctype='multipart/form-data' action='../handlers/handleSignups.php'>
<label> الرقم القومي </label>
<input type='number' name='pID' required>
<br/>
<label> الاسم </label>
<input type='text' name='pName' required>
<br/>
<div class='predict' dir='ltr'>
            <label> Chest Pain Type </label>
            <select name='pCPT' required>
            <option></option>
            <option value = '0'>0</option>
            <option value = '1'>1</option>
            <option value = '2'>2</option>
            <option value = '3'>3</option>
            <option value = '4'>4</option>
            </select>
            <br/>
            <label> Blood Pressure </label>
            <input type='number' name='pBP' required>
            <br/>
            <label> Cholesterol </label>
            <input type='number' name='pC' required>
            <br/>
            <label> Max heart rate </label>
            <input type='number' name='pMHR' required>
            <br/>
            <label> Exercise Angina </label>
            <select name='pEA' required>
            <option></option>
            <option value = '0'>0</option>
            <option value = '1'>1</option>
            </select>
            <br/>
            <label> Plasma Glucose </label>
            <input type='number' name='pPG' required>
            <br/>
            <label> Skin Thickness </label>
            <input type='number' name='pST' required>
            <br/>
            <label> Insulin </label>
            <input type='number' name='pI' required>
            <br/>
            <label> BMI </label>
            <input type='number' name='pBMI' required>
            <br/>
            <label> Diabetes Degree </label>
            <input type='number' name='pDD' required>
            <br/>
            <label> Hypertension </label>
            <select name='pHT' required>
            <option></option>
            <option value = '0'>0</option>
            <option value = '1'>1</option>
            </select>
            <br/>
            <label> Heart Disease </label>
            <select name='pHD' required>
            <option></option>
            <option value = '0'>0</option>
            <option value = '1'>1</option>
            </select>
            <br/>
            <label> Pregnancies </label>
            <input type='number' name='pPreg' required>
            <br/>
            <label> Residence Type </label>
            <select name = 'pRT' required>
                <option></option>
                <option value = '0'> مدينة </option>
                <option value = '1'> قرية </option>
            </select>
            <br/>
            <label> Smoking Status </label>
            <select name = 'pSS' required>
                <option></option>
                <option value = 'never'>غير مدخن</option>
                <option value = 'light'>مدخن قليلا</option>
                <option value = 'moderate'>مدخن متوسط</option>
                <option value = 'high'>مدخن بكثره</option>
            </select>
            <label hidden>Role</label>
            <input value='4' name='pRole' hidden> 
            </div>
            <br>
            <input type='submit' name ='rpAssign' value='اضافه'>
            <input name = 'createdBy' value = '$ID' hidden>
            </form>	
        </div>
        </div>
        </div>
        <script src='../JS/recepSignup.js'></script>
        <script src='../JS/adminSignup.js'></script>
        ";
    } ?>
                        <footer>
                            <?php include_once 'footer.php'; ?>
                        </footer>
</body>

</html>

<!-- <br/>
            <label> Ray </label>
            <input type='file'  accept='image/png, image/jpeg' id = 'photo' name='pRay' required>  -->