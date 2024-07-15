<?php
session_start();
include_once '../handlers/connect.php';
if(isset($_SESSION['NID']) && ($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
}
$validRoles = array(4,3,2,1);
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
    <link rel="stylesheet" href="../CSS/search.css">
    <link rel='stylesheet' href='../CSS/all.min.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
    <title>تعديل البيانات الشخصية</title>
</head>

<body>
    <?php include_once 'navbar.php'; ?>

    <?php
if(isset($_POST['search'])){
    $target = $_POST['target'];
    if ($role == 1 || $role == 2 || $role == 3){
        $targetID = $target;
        $getTargetData = " SELECT * FROM patients INNER JOIN labanalysis ON patients.ID = labanalysis.patientID WHERE patients.nationalID = '$targetID' ";
        $resultGetInfo = mysqli_query($conn, $getTargetData);
        if ($resultGetInfo->num_rows > 0) {
            $patientData = mysqli_fetch_assoc($resultGetInfo);
            echo "
            <div class='container1'>
                <div class='main1'>
                    <div class='row'>
            <div class='col-md-8 mt-1  margin'>
            <div class='card mb-3 content1'>
            <div class='card-body flex'>
                <div class='patient-info'>
                <h4> الاسم </h4>
                <p>"; ?><?php echo $patientData['name']?><?php echo "</p>
                <hr/>
                <h4> السن </h4>
                <p>"; ?><?php echo $patientData['age']?><?php echo "</p>
                <hr/>
                <h4> عنوان السكن  </h4>
                <p>"; ?><?php echo $patientData['address']?><?php echo "</p>
                </div>
                
                <form method='POST' dir='ltr' onsubmit='validPLAInputs()' action='../handlers/handleEditProfile.php'>
                <label> Chest Pain Type </label>
                <select name='pCPT'>
                <option>"; ?><?php echo $patientData['chestPainType']?><?php echo " </option>
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
                <option>"; ?><?php echo $patientData['exerciseAngina']?><?php echo " </option>
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
                <option>"; ?><?php echo $patientData['hypertension']?><?php echo " </option>
                <option value = '0'>0</option>
                <option value = '1'>1</option>
                </select>                
                <br/>
                <label> Heart Disease </label>
                <select name='pHD'>
                <option>"; ?><?php echo $patientData['heartDisease']?><?php echo " </option>
                <option value = '0'>0</option>
                <option value = '1'>1</option>
                </select>
                <br/>
                <label> Pregnancies </label>
                <input type='number' id = 'pPreg' placeholder = '"; ?><?php echo $patientData['Pregnancies'] ?><?php echo"' name='pPreg'>
                <br/>
                <label> Residence Type </label>
                <select name = 'pRT'>
                <option>"; ?><?php echo $patientData['residenceType']?><?php echo " </option>
                    <option value = '0'> مدينة </option>
                    <option value = '1'> قرية </option>
                </select>
                <br/>
                <label> Smoking Status </label>
                <select name = 'pSS'>
                <option>"; ?><?php echo $patientData['smokingStatus']?><?php echo " </option>
                <option value = 'never'>غير مدخن</option>
                <option value = 'light'>مدخن قليلا</option>
                <option value = 'moderate'>مدخن متوسط</option>
                <option value = 'high'>مدخن بكثره</option>
                </select>
                <br/>
                <input hidden name = 'pID' value ='"; ?><?php echo $patientData['ID'] ?><?php echo "'>
                <input type='submit' name ='EditPHistory' value='تعديل'>
                </form>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                ";
            if ($role == 3){
                echo "
                <div class='lol'>
                <hr/>
                <h4> عدد الحجوزات </h4>
                <p>"; ?><?php echo $patientData['reservations']?><?php echo "</p>
                <hr/>
                <form method='POST' onsubmit = 'validRPPInputs' action = '../handlers/handleEditProfile.php'>
                <label> المبلغ المستحق </label>
                <input type = 'number' name = 'toPay' id = 'toPay' placeholder = '"; ?><?php echo $patientData['toPay'] ?><?php echo "'>
                <input hidden name = 'pID' value ='"; ?><?php echo $patientData['ID'] ?><?php echo "'>
                <input type = 'submit' value ='تعديل' name = 'rEditPpayment'>
                </div>
                <footer>";
include_once 'footer.php';
echo"
</footer>
                </body>
                <script src='../JS/functions.php'></script>
                </html>
                ";
            }
        } else {
            echo " <script> alert (' عذراً, لا يوجد مريض مسجل بهذا الرقم, رجاء التأكد من صحة البيانات '); </script>";
            header('Refresh: 1; URL = index.php');
        }
    } else if ($role == 4){
        $getpData = "SELECT * FROM users INNER JOIN patients ON users.userID = patients.nationalID WHERE users.userID = $ID";
$resultpData = mysqli_query($conn,$getpData);
if ($resultpData ->num_rows > 0){
    $patientDataSearch = mysqli_fetch_assoc($resultpData);
}
        $currentWeek = strtotime('monday this week');
        $firstOFweek = date('Y-m-d', strtotime("monday", $currentWeek));
        $lastOFweek = date('Y-m-d', strtotime("monday +6 days", $currentWeek));
        $getDoctorData = " SELECT * FROM doctors WHERE name LIKE '$target%' LIMIT 1";
        $resultGetInfo = mysqli_query($conn, $getDoctorData);
        if ($resultGetInfo->num_rows > 0) {
            $doctorData = mysqli_fetch_assoc($resultGetInfo);
            if($doctorData['rateCount'] != 0){
            $drRating = $doctorData['rate'] / $doctorData['rateCount'];
            } else {
                $drRating = 0;
            }
            $doctorID = $doctorData['ID'];
            $getDoctorTime = " SELECT * FROM timetable WHERE doctorID = '$doctorID' AND currentWeek BETWEEN '$firstOFweek' AND '$lastOFweek' ";
            $resultGetTime = mysqli_query($conn, $getDoctorTime);
            echo "
            <div class='container'>
            <div class='main'>
                <div class='row'>
                    <div class='col-md-4 mt-1'>
                        <div class='crad-body'>
                            <img src='Uploads/Images/" ?><?php echo $patientDataSearch['photo'] ?><?php echo"' class='rounded-circle' width='150'>
                            <div class='mt-3 sidebar'> 
                            <h3>" ?>
    <?php $name = explode(' ',$patientDataSearch['name']);
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
            <img src='Uploads/Images/";?><?php echo $doctorData['photo'] ?><?php echo" '>
            <div class='info'>
            <div class='doctor-data'>
                <label>الاسم:</label>
                <p>";?><?php echo $doctorData['name'] ?><?php echo"</p>
                <hr>
                <label>التخصص:</label>
                <p>";?><?php echo $doctorData['specialization'] ?><?php echo"</p>
                <hr>
                <label>سعر الكشف:</label>
                <p>";?><?php echo $doctorData['reservationPrice'] ?><?php echo"</p>
                <hr>
                <label>نبذة:</label>
                <p>";?><?php echo $doctorData['description'] ?><?php echo"</p>
                <hr>

                <label>التقييم:</label>
                <p>";?><?php echo $drRating ?><?php echo"</p>
            </div>
            <div class='reserve'><p> المواعيد المتاحة هذا الاسبوع </p>
            
            ";
            while ($row = $resultGetTime->fetch_assoc()){
                $day = $day_name = date('D', strtotime($row['currentWeek']));
                $dID = $row['doctorID'];
                $timeFrom = date('H:i', strtotime($row['cWeekFrom'])); 
                $datetimeFrom = strtotime($timeFrom);
                $arabic_timeFrom = strftime('%I:%M %p', $datetimeFrom);
                $timeTo = date('H:i', strtotime($row['cWeekTo'])); 
                $datetimeTo = strtotime($timeTo);
                $arabic_timeTo = strftime('%I:%M %p', $datetimeTo);
                echo "<div><p>اليوم : <span>" . $row['currentWeek'] . "</span></p>";
                echo "<p>من الساعة :<span>" . $arabic_timeFrom . "</span></p>";
                echo "<p>الى الساعة :<span>" . $arabic_timeTo . "</span></p>";
                echo "<a href='reservation.php?dID=$dID&reservedDay=$day'>احجز الان</a></div> 
                </div>
                </div>
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
                </body></html>
                ";
            }
        } else {
            echo " <script> alert (' عذراً, لا يوجد طبيب مسجل بهذا الاسم, رجاء التأكد من صحة البيانات '); </script>";
            header('Refresh: 1; URL = index.php');
        }
    }
}