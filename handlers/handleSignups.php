<?php
session_start();
include_once 'connect.php';
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
function getGender($NID){
    $gender = substr($NID,-2,1);
    if($gender % 2 == 0){
        $gender = 'انثى';
    } else {
        $gender = 'ذكر';
    }
    return $gender;
}
// Admin
if (isset($_POST['aAssign'])) {
    $errors = array();
    if(empty($_POST['aID']) || empty($_POST['aName'])){
        $errors[] = " برجاء ملئ جميع البيانات ";
    } else if (!is_numeric($_POST['aID'])){
        $errors[] = " اسم المستخدم يجب ان يكون ارقام ";
    } else if (strlen($_POST['aID']) != 14 ){
        $errors[] = " يجب أن يكون 14 رقم فقط ";
    } 
    $stmt = $conn->prepare("SELECT COUNT(*) FROM admin WHERE userID = ?");
    $stmt->bind_param("i", $_POST['aID']);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if ($count > 0) {
    $errors[] = " لقد تم استخدام هذا الرقم القومي من قبل, برجاء تسجيل رقم جديد ";
    }
    if (empty($errors)) {
        $aUserID = $aPW = trim(htmlspecialchars($_POST['aID']));
        $aName = trim(htmlspecialchars($_POST['aName']));
        $aRole = trim(htmlspecialchars($_POST['aRole']));
        $creator = trim(htmlspecialchars($_POST['createdBy']));
        $hashedPW = password_hash($aPW, PASSWORD_DEFAULT);
        $aAge = getAge($aUserID);
        $aGender = getGender($aUserID);
        $createUser = "INSERT INTO users (userID,userPW,role,createdBy,createdAt) VALUES ('$aUserID','$hashedPW','$aRole','$creator',NOW())";
        $createProfile = "INSERT INTO admin (userID,userPW,name,age,nationalID,gender) VALUES ('$aUserID','$hashedPW','$aName','$aAge','$aUserID','$aGender')";
        $resultcreateProfile = $conn->query($createProfile);
        if ($resultcreateProfile){
            echo " <script>alert(' تم انشاء اسم المستخدم بنجاح ');</script> ";
            header('Refresh:1 ; URL = ../Views/signup.php');
            die();
        } else {
            echo " <script>alert(' لم يتم انشاء اسم المستخدم  ');</script> ";
            header('Refresh:1 ; URL = ../Views/signup.php');
            die();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p><br/>";
            header('Refresh: 5; URL = ../Views/signup.php');
        }
    }
    $conn->close();
}
// Doctor
else if (isset($_POST['dAssign'])) { 
    $errors = array();
    if(empty($_POST['dID']) || empty($_POST['dName']) || empty($_POST['dSpec'])){
        $errors[] = "Please Fill all data and try again.";
    } else if (!is_numeric($_POST['dID'])){
        $errors[] = "User ID must be a number.";
    } else if (strlen($_POST['dID']) < 14 ){
        $errors[] = "User ID must be at least 14 characters.";
    } 
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE userID = ?");
    $stmt->bind_param("i", $_POST['dID']);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if ($count > 0) {
        $errors[] = "User ID must be unqiue.";
    }
    $stmt = $conn->prepare("SELECT COUNT(*) FROM specializations WHERE name = ? AND doctorID IS NOT NULL");
    $stmt->bind_param("s", $_POST['dSpec']);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if ($count > 2) {
        $errors[] = "You can't assign more doctors to this specialization.";
    }
    if (empty($errors)) {
        $dUserID = $dPW = trim(htmlspecialchars($_POST['dID']));
        $dName = trim(htmlspecialchars($_POST['dName']));
        $dSpec = trim(htmlspecialchars($_POST['dSpec']));
        $dRole = trim(htmlspecialchars($_POST['dRole']));
        $creator = trim(htmlspecialchars($_POST['createdBy']));
        $hashedPW = password_hash($dPW, PASSWORD_DEFAULT);
        $dAge = getAge($dUserID);
        $dGender = getGender($dUserID);
        $createUser = "INSERT INTO users (userID,userPW,role,createdBy,createdAt) VALUES ('$dUserID','$hashedPW','$dRole','$creator',NOW())";
        $createProfile = "INSERT INTO doctors (name,age,nationalID,gender,specialization,photo) VALUES ('$dName','$dAge','$dUserID','$dGender','$dSpec','default.png')";
        $getDocID = "SELECT ID FROM doctors ORDER BY ID DESC LIMIT 1";
        $resultgetDocID = mysqli_query($conn,$getDocID);
        $row = mysqli_fetch_array($resultgetDocID);
        $dID = $row['ID'];
        $newID = $dID +1;
        $updateSpecializations = "INSERT INTO specializations (name,doctorID) VALUES ('$dSpec','$newID')";
        $resultcreateUser = $conn->query($createUser);
        $resultcreateProfile = $conn->query($createProfile);
        $resultupdateSpec = $conn->query($updateSpecializations);
        if ($resultcreateUser && $resultcreateProfile && $resultupdateSpec){
            include_once 'handleUpdateSpecs.php';
            echo "<script>";
            header('Refresh: 3; url=../Views/signup.php');
            die();
        } else {
            echo "<script>alert('لم يتم انشاء اسم المستخدم')</script>";
            header('Refresh: 1; url=../Views/signup.php');
            die();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }
    $conn->close();
}
// Nurse
else if (isset($_POST['nAssign'])) {
    $errors = array();
    if(empty($_POST['nID']) || empty($_POST['nName']) || empty($_POST['nSpec'])){
        $errors[] = "Please Fill all data and try again.";
    } else if (!is_numeric($_POST['nID'])){
        $errors[] = "User ID must be a number.";
    } else if (strlen($_POST['nID']) < 14 ){
        $errors[] = "User ID must be at least 14 characters.";
    } 
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE userID = ?");
    $stmt->bind_param("i", $_POST['nID']);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if ($count > 0) {
        $errors[] = "User ID must be unqiue.";
    }
    if (empty($errors)) {
        $nUserID = $nPW = trim(htmlspecialchars($_POST['nID']));
        $nName = trim(htmlspecialchars($_POST['nName']));
        $nSpec = trim(htmlspecialchars($_POST['nSpec']));
        $nRole = trim(htmlspecialchars($_POST['nRole']));
        $creator = trim(htmlspecialchars($_POST['createdBy']));
        $hashedPW = password_hash($nPW, PASSWORD_DEFAULT);
        $nAge = getAge($nUserID);
        $nGender = getGender($nUserID);
        $createUser = "INSERT INTO users (userID,userPW,role,createdBy,createdAt) VALUES ('$nUserID','$hashedPW','$nRole','$creator',NOW())";
        $createProfile = "INSERT INTO nurses (name,age,nationalID,gender,specialization,photo) VALUES ('$nName','$nAge','$nUserID','$nGender','$nSpec','default.png')";
        $getNurseID = "SELECT ID FROM nurses ORDER BY ID DESC LIMIT 1";
        $resultgetNurseID = mysqli_query($conn,$getNurseID);
        $row = mysqli_fetch_array($resultgetNurseID);
        $nID = $row['ID'];
        $newID = $nID +1;
        $updateSpecializations = " UPDATE specializations SET nurseID ='$newID' WHERE name = '$nSpec' ";
        $resultcreateUser = $conn->query($createUser);
        $resultcreateProfile = $conn->query($createProfile);
        $resultupdateSpec = $conn->query($updateSpecializations);
        if ($resultcreateUser && $resultcreateProfile && $resultupdateSpec){
            echo "<script>";
            header('Refresh: 3; url=../Views/signup.php');
            die();
        } else {
            echo "<script>alert('لم يتم انشاء اسم المستخدم')</script>";
            header('Refresh: 1; url=../Views/signup.php');
            die();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }
    $conn->close();
}
// Receptionist 
else if (isset($_POST['rAssign'])) {
    $errors = array();
    if(empty($_POST['rID']) || empty($_POST['rName'])){
        $errors[] = "Please Fill all data and try again.";
    } else if (!is_numeric($_POST['rID'])){
        $errors[] = "User ID must be a number.";
    } else if (strlen($_POST['rID']) < 14 ){
        $errors[] = "User ID must be at least 14 characters.";
    } 
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE userID = ?");
    $stmt->bind_param("i", $_POST['rID']);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if ($count > 0) {
        $errors[] = "User ID must be unqiue.";
    }
    if (empty($errors)) {
        $rUserID = $rPW = trim(htmlspecialchars($_POST['rID']));
        $rName = trim(htmlspecialchars($_POST['rName']));
        $rRole = trim(htmlspecialchars($_POST['rRole']));
        $creator = trim(htmlspecialchars($_POST['createdBy']));
        $hashedPW = password_hash($rPW, PASSWORD_DEFAULT);
        $rAge = getAge($rUserID);
        $rGender = getGender($rUserID);
        $createUser = "INSERT INTO users (userID,userPW,role,createdBy,createdAt) VALUES ('$rUserID','$hashedPW','$rRole','$creator',NOW())";
        $createProfile = "INSERT INTO receptionists (name,age,nationalID,gender,photo) VALUES ('$rName','$rAge','$rUserID','$rGender','default.png')";
        $resultcreateUser = $conn->query($createUser);
        $resultcreateProfile = $conn->query($createProfile);
        if ($resultcreateUser && $resultcreateProfile){
            echo "<script>";
            header('Refresh: 3; url=../Views/signup.php');
            die();
        } else {
            echo "<script>alert('لم يتم انشاء اسم المستخدم')</script>";
            header('Refresh: 1; url=../Views/signup.php');
            die();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }
    $conn->close();
}
// Patient
else if (isset($_POST['pAssign'])) {
    $errors = array();
    if(empty($_POST['pID']) || empty($_POST['pName'])){
        $errors[] = "Please Fill all data and try again.";
    } else if (!is_numeric($_POST['pID'])){
        $errors[] = "User ID must be a number.";
    } else if (strlen($_POST['pID']) < 14 ){
        $errors[] = "User ID must be at least 14 characters.";
    } 
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE userID = ?");
    $stmt->bind_param("i", $_POST['pID']);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if ($count > 0) {
        $errors[] = "User ID must be unqiue.";
    }
    if (empty($errors)) {
        $pUserID = $pPW = trim(htmlspecialchars($_POST['pID']));
        $pName = trim(htmlspecialchars($_POST['pName']));
        $pRole = trim(htmlspecialchars($_POST['pRole']));
        $creator = trim(htmlspecialchars($_POST['createdBy']));
        $hashedPW = password_hash($pPW, PASSWORD_DEFAULT);
        $pAge = getAge($pUserID);
        $pGender = getGender($pUserID);
        $createUser = "INSERT INTO users (userID,userPW,role,createdBy,createdAt) VALUES ('$pUserID','$hashedPW','$pRole','$creator',NOW())";
        $createProfile = "INSERT INTO patients (name,age,nationalID,gender,photo) VALUES ('$pName','$pAge','$pUserID','$pGender','default.png')";
        $resultcreateUser = $conn->query($createUser);
        $resultcreateProfile = $conn->query($createProfile);
        if ($resultcreateProfile){
            $getPatientData = " SELECT * FROM patients WHERE nationalID = '$pUserID' ";
            $resultPatientData = mysqli_query($conn, $getPatientData);
            if ($resultPatientData ->num_rows > 0){
                $patientData = mysqli_fetch_assoc($resultPatientData);
            }
            $userID = $patientData['ID'];
            $userAge = $patientData['age'];
            $userGender = $patientData['gender'];
        }
        $createUserLA = "INSERT INTO labanalysis (patientID,age,gender) VALUES ('$userID','$userAge','$userGender')";
        $resultCreateULA = mysqli_query($conn, $createUserLA);
        if ($resultcreateUser && $resultcreateProfile){
            echo "<script>alert('تم انشاء اسم المستخدم بنجاح')</script>";
            header('Refresh: 1; url=../Views/signup.php');
            die();
        } else {
            echo "<script>alert('لم يتم انشاء اسم المستخدم')</script>";
            header('Refresh: 1; url=../Views/signup.php');
            die();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }
 $conn->close();
}
// Receptionist assigning patient
else if (isset($_POST['rpAssign'])) {
    $errors = array();
    if(empty($_POST['pID']) || empty($_POST['pName'])){
        $errors[] = "Please Fill all data and try again.";
    } else if (!is_numeric($_POST['pID'])){
        $errors[] = "User ID must be a number.";
    } else if (strlen($_POST['pID']) < 14 ){
        $errors[] = "User ID must be at least 14 characters.";
    } 
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE userID = ?");
    $stmt->bind_param("i", $_POST['pID']);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if ($count > 0) {
        $errors[] = "User ID must be unqiue.";
    }
    if (empty($errors)) {
        $pUserID = $pPW = trim(htmlspecialchars($_POST['pID']));
        $pName = trim(htmlspecialchars($_POST['pName']));
        $pRole = trim(htmlspecialchars($_POST['pRole']));
        $creator = trim(htmlspecialchars($_POST['createdBy']));
        $pCPT = trim(htmlspecialchars($_POST['pCPT']));
        $pBP = trim(htmlspecialchars($_POST['pBP']));
        $pC = trim(htmlspecialchars($_POST['pC']));
        $pMHR = trim(htmlspecialchars($_POST['pMHR']));
        $pEA = trim(htmlspecialchars($_POST['pEA']));
        $pPG = trim(htmlspecialchars($_POST['pPG']));
        $pST = trim(htmlspecialchars($_POST['pST']));
        $pI = trim(htmlspecialchars($_POST['pI']));
        $pBMI = trim(htmlspecialchars($_POST['pBMI']));
        $pDD = trim(htmlspecialchars($_POST['pDD']));
        $pHT = trim(htmlspecialchars($_POST['pHT']));
        $pHD = trim(htmlspecialchars($_POST['pHD']));
        $pPreg = trim(htmlspecialchars($_POST['pPreg']));
        $pRT = trim(htmlspecialchars($_POST['pRT']));
        $pSS = trim(htmlspecialchars($_POST['pSS']));
        $hashedPW = password_hash($pPW, PASSWORD_DEFAULT);
        $pAge = getAge($pUserID);
        $pGender = getGender($pUserID);
        $createUser = "INSERT INTO users (userID,userPW,role,createdBy,createdAt) VALUES ('$pUserID','$hashedPW','$pRole','$creator',NOW())";
        $createProfile = "INSERT INTO patients (name,age,nationalID,gender,photo) VALUES ('$pName','$pAge','$pUserID','$pGender','default.png')";
        $getPatientID = "SELECT ID FROM patients ORDER BY ID DESC LIMIT 1";
        $resultPatientID = mysqli_query($conn, $getPatientID);
        if($resultPatientID -> num_rows > 0){
            $row = mysqli_fetch_array($resultPatientID);
            $pID = $row['ID']+1;
        }
        $createLabAnalysis = "INSERT INTO labanalysis (patientID, age, gender, chestPainType, bloodPressure, cholesterol, maxHeartRate, exerciseAngina, plasmaGlucose, skinThickness, insulin, bmi, diabetesDegree, hypertension, heartDisease, Pregnancies, residenceType, smokingStatus) VALUES ('$pID', '$pAge', '$pGender', '$pCPT', '$pBP', '$pC', '$pMHR', '$pEA', '$pPG', '$pST', '$pI', '$pBMI', '$pDD', '$pHT', '$pHD', '$pPreg', '$pRT', '$pSS')";
        $resultcreateUser = $conn->query($createUser);
        $resultcreateProfile = $conn->query($createProfile);
        $resultcreateLabAnalysis = $conn->query($createLabAnalysis);
        if ($resultcreateUser && $resultcreateProfile && $resultcreateLabAnalysis){
            echo "<script>alert(' تم انشاء اسم المستخدم')</script>";
            header('Refresh: 1; url=../Views/signup.php');
            die();
        } else {
            echo "<script>alert('لم يتم انشاء اسم المستخدم')</script>";
            header('Refresh: 1; url=../Views/signup.php');
            die();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }
    $conn->close();
}
?>