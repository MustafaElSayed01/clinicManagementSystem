<?php
session_start();
include_once '../handlers/connect.php';
if(isset($_SESSION['NID']) && ($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
}
$validRoles = array(100,3,2,1);
if (!in_array($role,$validRoles)){
    echo " <script>alert(' غير مسموح لك بالدخول ');</script> ";
    header('Refresh:1 ; URL = index.php');
    die();
}
if (isset($_GET['view']) &&  $_GET["view"] == 'r'){
        $pNID = htmlspecialchars($_GET['NID']);
        $getPatientInfo = " SELECT * FROM patients WHERE nationalID = '$pNID' ";
        $resultGetInfo = mysqli_query($conn, $getPatientInfo);
        $getPatientHistory = " SELECT * FROM labanalysis INNER JOIN patients ON labanalysis.patientID = patients.ID WHERE patients.nationalID = '$pNID'";
        $resultGetHistory = mysqli_query($conn, $getPatientHistory);
        if ($resultGetHistory ->num_rows > 0){
            $patientHistory = mysqli_fetch_assoc($resultGetHistory);
        }
            if ($resultGetInfo ->num_rows > 0){
                $patientData = mysqli_fetch_assoc($resultGetInfo);
    include_once 'navbar.php';
        echo "    
            <!DOCTYPE html>
            <html dir='rtl' lang='ar'>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' href='../CSS/patientProfile.css'>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
                <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
                <title> بيانات المريض </title>
            </head>
            <body>
            <div class='container1'>
                <div class='main1'>
                    <div class='row'>
            <div class='col-md-8 mt-1  margin'>
            <div class='card mb-3 content1'>
            <div class='card-body'>
                <div class='patient-info'>
        <img src='Uploads/Images/" ?><?php echo $patientData['photo'] ?><?php echo"' class='rounded-circle' width='150'>
        <h4> الاسم </h4>
        <p>"; ?><?php echo $patientData['name']?><?php echo "</p>
        <hr/>
        <h4> السن </h4>
        <p>"; ?><?php echo $patientData['age']?><?php echo "</p>
        <hr/>
        <h4> رقم الهاتف الشخصي </h4>
        <p>"; ?><?php echo $patientData['phone']?><?php echo "</p>
        <hr/>
        <h4> رقم هاتف الطوارئ </h4>
        <p>"; ?><?php echo $patientData['emergencyContact']?><?php echo "</p>
        <hr/>
        <h4> الرقم القومي  </h4>
        <p>"; ?><?php echo $patientData['nationalID']?><?php echo "</p>
        <hr/>
        <h4> البريد الإليكتروني  </h4>
        <p>"; ?><?php echo $patientData['emailAddress']?><?php echo "</p>
        <hr/>
        <h4> عنوان السكن  </h4>
        <p>"; ?><?php echo $patientData['address']?><?php echo "</p>
        <hr/>
        <h4> عدد الحجوزات </h4>
        <p>"; ?><?php echo $patientData['reservations']?><?php echo "</p>
        </div>

        <form method='POST' onsubmit='validRPInputs()' action='../handlers/handleEditProfile.php'>
            <label> المبلغ المستحق </label>
            <input type = 'number' name = 'toPay' id = 'toPay' placeholder = '"; ?><?php echo $patientData['toPay'] ?><?php echo "'>
            <input hidden name = 'pID' value ='"; ?><?php echo $patientData['ID'] ?><?php echo "'>
            <br/>
            <label> Chest Pain Type </label>
            <select name='pCPT'>
            <option></option>
            <option value = '0'>0</option>
            <option value = '1'>1</option>
            <option value = '2'>2</option>
            <option value = '3'>3</option>
            <option value = '4'>4</option>
            </select>
            <br/>
            <label> Blood Pressure </label>
            <input type='number' placeholder = '"; ?><?php echo $patientData['bloodPressure'] ?><?php echo"' id = 'pBP' name='pBP'>
            <br/>
            <label> Cholesterol </label>
            <input type='number' placeholder = '"; ?><?php echo $patientData['cholesterol'] ?><?php echo"' id = 'pC' name='pC'>
            <br/>
            <label> Max heart rate </label>
            <input type='number' placeholder = '"; ?><?php echo $patientData['maxHeartRate'] ?><?php echo"' id = 'pMHR' name='pMHR'>
            <br/>
            <label> Exercise Angina	 </label>
            <select name='pEA'>
            <option></option>
            <option value = '0'>0</option>
            <option value = '1'>1</option>
            </select>
            <br/>
            <label> Plasma Glucose </label>
            <input type='number' placeholder = '"; ?><?php echo $patientData['plasmaGlucose'] ?><?php echo"' id = 'pPG' name='pPG'>
            <br/>
            <label> Skin Thickness </label>
            <input type='number' placeholder = '"; ?><?php echo $patientData['skinThickness'] ?><?php echo"' id = 'pST' name='pST'>
            <br/>
            <label> Insulin </label>
            <input type='number' placeholder = '"; ?><?php echo $patientData['insulin'] ?><?php echo"' id = 'pI' name='pI'>
            <br/>
            <label> BMI </label>
            <input type='number' placeholder = '"; ?><?php echo $patientData['bmi'] ?><?php echo"' id = 'pBMI' name='pBMI'>
            <br/>
            <label> Diabetes Degree </label>
            <input type='number' placeholder = '"; ?><?php echo $patientData['diabetesDegree'] ?><?php echo"' id = 'pDD' name='pDD'>
            <br/>
            <label> Hypertension </label>
            <select name='pHT'>
            <option></option>
            <option value = '0'>0</option>
            <option value = '1'>1</option>
            </select>                
            <br/>
            <label> Heart Disease </label>
            <select name='pHD'>
            <option></option>
            <option value = '0'>0</option>
            <option value = '1'>1</option>
            </select>
            <br/>
            <label> Pregnancies </label>
            <input type='number' id = 'pPreg' placeholder = '"; ?><?php echo $patientData['Pregnancies'] ?><?php echo"' name='pPreg'>
            <br/>
            <label> Residence Type </label>
            <select name = 'pRT'>
                <option></option>
                <option value = '0'> مدينة </option>
                <option value = '1'> قرية </option>
            </select>
            <br/>
            <label> Smoking Status </label>
            <select name = 'pSS'>
                <option></option>
                <option value = '0'>غير مدخن</option>
                <option value = '1'>مدخن قليلا</option>
                <option value = '2'>مدخن متوسط</option>
                <option value = '3'>مدخن بكثره</option>
            </select>
            <br/>
            <input type='submit' name ='rpEdit' value='تعديل'>
            </form>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            <footer>"; ?>
<?php include_once 'footer.php'; ?>
</footer>
</body>
<?php
        echo"
        <script src = '../JS/functions.js'></script>";
        
    }
} else if (isset($_GET['view']) &&  $_GET["view"] == 'n'){
    $rID = htmlspecialchars($_GET['ID']);
    $getPrescription = " SELECT prescription FROM reservationtable WHERE ID = '$rID'";
    $getnData = "SELECT * FROM users INNER JOIN nurses ON users.userID = nurses.nationalID WHERE users.userID = '$ID'";
    $resultnData = mysqli_query($conn,$getnData);
    if ($resultnData ->num_rows > 0){
        $nurseData = mysqli_fetch_assoc($resultnData);
    }
    $resultGetData = mysqli_query($conn, $getPrescription);
    if ($resultGetData ->num_rows > 0){
        $pres = mysqli_fetch_assoc($resultGetData);
        include_once 'navbar.php';
        echo "    
            <!DOCTYPE html>
    <html dir='rtl' lang='ar'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='../CSS/patientProfile.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
        <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
        <title> بيانات المريض </title>
    </head>
    <body>
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
        <img src='Uploads/Images/" ?><?php echo $pres['prescription'] ?><?php echo"' >
        <br/>
        <form method='POST' action = '../handlers/handleEditProfile.php' enctype='multipart/form-data'>
        <Label> التقرير الطبي </Label>
        <input type = 'file' name = 'prescription' accept='image/png, image/jpeg'>
        <input type = 'hidden' name = 'rID' value = '$rID'>
        <input type = 'submit' name = 'npEdit' value = 'تحديث'>
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
        ";
    }
    


}
$conn->close();
?>