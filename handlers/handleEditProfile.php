<?php
session_start();
include_once 'connect.php';
if(isset($_SESSION['NID']) && ($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
}
// Admin
if(isset($_POST['aEdit'])){
    $aPhone = trim(htmlspecialchars($_POST['aPhone']));
    $aEAddress = trim(htmlspecialchars($_POST['aEAddress']));
    $errors = array();
    if (filter_var($aEAddress, FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = ' الايميل غير صحيح ';
    } 
    if(empty($errors)) {
        $aAddress = trim(htmlspecialchars($_POST['aAddress']));
        if (($_FILES['aPhoto']['name'] == '')){
            $editAData = "UPDATE admin SET phone = '$aPhone', emailAddress = '$aEAddress', address = '$aAddress' WHERE nationalID = '$ID'";
        } else {
            $aPhoto = $_FILES['aPhoto'];
            $photo_name = $aPhoto['name'];
            $photo_tmp_name = $aPhoto['tmp_name'];
            $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);
            $photo_new_name = uniqid() . "." . $photo_extension;
            move_uploaded_file($photo_tmp_name, "../Uploads/Images/$photo_new_name");
            $editAData = "UPDATE admin SET phone = '$aPhone', emailAddress = '$aEAddress', address = '$aAddress', photo = '$photo_new_name' WHERE nationalID = '$ID'";
        }
        $resulteditAData = $conn->query($editAData);
        if ($resulteditAData){
            echo " <script>alert(' تم تحديث البيانات بنجاح');</script> ";
            header('Refresh:1 ; URL = ../Views/profile.php');
            die();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p><br/>";
            header('Refresh: 5; URL = ../Views/editProfile.php');
        }
    }
}
// Doctor
else if(isset($_POST['dEdit'])){
    $dPhone = trim(htmlspecialchars($_POST['dPhone']));
    $dEAddress = trim(htmlspecialchars($_POST['dEAddress']));
    $errors = array();
    if (filter_var($dEAddress, FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = ' الايميل غير صحيح ';
    }
    if(empty($errors)) {
        $dAddress = trim(htmlspecialchars($_POST['dAddress']));
        $dDescription = trim(htmlspecialchars($_POST['dDescription']));
        $dSpecialization = trim(htmlspecialchars($_POST['dSpecialization']));
        if (($_FILES['dPhoto']['name'] == '')){
            $editDData = "UPDATE doctors SET phone = '$dPhone', emailAddress = '$dEAddress', address = '$dAddress', specialization = '$dSpecialization',description = '$dDescription' WHERE nationalID = '$ID'";
        } else {
            $dPhoto = $_FILES['dPhoto'];
            $photo_name = $dPhoto['name'];
            $photo_tmp_name = $dPhoto['tmp_name'];
            $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);
            $photo_new_name = uniqid() . "." . $photo_extension;
            move_uploaded_file($photo_tmp_name, "../Uploads/Images/$photo_new_name");
            $editDData = "UPDATE doctors SET phone = '$dPhone', emailAddress = '$dEAddress', address = '$dAddress', photo = '$photo_new_name', specialization = '$dSpecialization',description = '$dDescription' WHERE nationalID = '$ID'";
        }
        $resulteditDData = $conn->query($editDData);
        if ($resulteditDData){
            echo " <script>alert(' تم تحديث البيانات بنجاح');</script> ";
            header('Refresh:1 ; URL = ../Views/profile.php');
            die(); 
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p><br/>";
            header('Refresh: 5; URL = ../Views/editProfile.php');
        }
    }
}
// Admin edits Doctor's
else if(isset($_POST['adEdit'])){
    $reservationPrice = trim(htmlspecialchars($_POST['reservationPrice']));
    $perHour = trim(htmlspecialchars($_POST['perHour']));
    $dID = trim(htmlspecialchars($_POST['dID']));
    $editdData = "UPDATE doctors SET reservationPrice = '$reservationPrice', perHour = '$perHour' WHERE ID = '$dID'";
    $resulteditDData = $conn->query($editdData);
    if ($resulteditDData){
        echo " <script>alert(' تم تحديث البيانات بنجاح');</script> ";
        header('Refresh:1 ; URL = ../Views/doctors.php');
        die();
    }
}
// Nurse
else if(isset($_POST['nEdit'])){
    $nPhone = trim(htmlspecialchars($_POST['nPhone']));
    $nEAddress = trim(htmlspecialchars($_POST['nEAddress']));
    $errors = array();
    if (filter_var($nEAddress, FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = ' الايميل غير صحيح ';
    }
    if(empty($errors)) {
        $nAddress = trim(htmlspecialchars($_POST['nAddress']));
        if (($_FILES['nPhoto']['name'] == '')){
            $editNData = "UPDATE nurses SET phone = '$nPhone', emailAddress = '$nEAddress', address = '$nAddress' WHERE nationalID = $ID";
        } else {
            $nPhoto = $_FILES['nPhoto'];
            $photo_name = $nPhoto['name'];
            $photo_tmp_name = $nPhoto['tmp_name'];
            $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);
            $photo_new_name = uniqid() . "." . $photo_extension;
            move_uploaded_file($photo_tmp_name, "../Uploads/Images/$photo_new_name");
            $editNData = "UPDATE nurses SET phone = '$nPhone', emailAddress = '$nEAddress', address = '$nAddress', photo = '$photo_new_name' WHERE nationalID = '$ID' ";
        }
        $resulteditNData = $conn->query($editNData);
        if ($resulteditNData){
            echo " <script>alert(' تم تحديث البيانات بنجاح');</script> ";
            header('Refresh:1 ; URL = ../Views/profile.php');
            die();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p><br/>";
            header('Refresh: 5; URL = ../Views/editProfile.php');
        }
    }
} 
// Receptionist
else if(isset($_POST['rEdit'])){
    $rPhone = trim(htmlspecialchars($_POST['rPhone']));
    $rEAddress = trim(htmlspecialchars($_POST['rEAddress']));
    if (filter_var($rEAddress, FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = ' الايميل غير صحيح ';
    }
    if(empty($errors)) {
        $rAddress = trim(htmlspecialchars($_POST['rAddress']));
        if (($_FILES['rPhoto']['name'] == '')){
            $editRData = "UPDATE receptionists SET phone = '$rPhone',emailAddress = '$rEAddress', address = '$rAddress' WHERE nationalID = '$ID'";
        } else {
            $rPhoto = $_FILES['rPhoto'];
            $photo_name = $rPhoto['name'];
            $photo_tmp_name = $rPhoto['tmp_name'];
            $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);
            $photo_new_name = uniqid() . "." . $photo_extension;
            move_uploaded_file($photo_tmp_name, "../Uploads/Images/$photo_new_name");
            $editRData = "UPDATE receptionists SET phone = '$rPhone',emailAddress = '$rEAddress', address = '$rAddress', photo = '$photo_new_name' WHERE nationalID = '$ID'";
            }
        $resulteditRData = $conn->query($editRData);
        if ($resulteditRData){
            echo " <script>alert(' تم تحديث البيانات بنجاح');</script> ";
            header('Refresh:1 ; URL = ../Views/profile.php');
            die();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p><br/>";
            header('Refresh: 5; URL = ../Views/editProfile.php');
        }
    }
}
// Patient
else if(isset($_POST['pEdit'])){
    $pPhone = trim(htmlspecialchars($_POST['pPhone']));
    $pEPhone = trim(htmlspecialchars($_POST['pEPhone']));
    $pEAddress = trim(htmlspecialchars($_POST['pEAddress']));
    if (filter_var($pEAddress, FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = ' الايميل غير صحيح ';
    }
    if(empty($errors)) {
        $pAddress = trim(htmlspecialchars($_POST['pAddress']));
        if (($_FILES['pPhoto']['name'] == '')){
            $editPData = "UPDATE patients SET phone = '$pPhone', emergencyContact = '$pEPhone', emailAddress = '$pEAddress', address = '$pAddress' WHERE nationalID = '$ID'";
        } else {
            $pPhoto = $_FILES['pPhoto'];
            $photo_name = $pPhoto['name'];
            $photo_tmp_name = $pPhoto['tmp_name'];
            $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);
            $photo_new_name = uniqid() . "." . $photo_extension;
            move_uploaded_file($photo_tmp_name, "../Uploads/Images/$photo_new_name");
            $editPData = "UPDATE patients SET phone = '$pPhone', emergencyContact = '$pEPhone', emailAddress = '$pEAddress', address = '$pAddress', photo = '$photo_new_name' WHERE nationalID = '$ID'";
        }
        $resulteditPData = $conn->query($editPData);
        if ($resulteditPData){
            echo " <script>alert(' تم تحديث البيانات بنجاح');</script> ";
            header('Refresh:1 ; URL = ../Views/profile.php');
            die();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p><br/>";
            header('Refresh: 5; URL = ../Views/editProfile.php');
        }
    }
}
// Receptionist edits Patient's
else if(isset($_POST['rpEdit'])){
    $toPay = trim(htmlspecialchars($_POST['toPay']));
    $pID = trim(htmlspecialchars($_POST['pID']));
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
    $getPatientLA = " SELECT * FROM labanalysis WHERE patientID = '$pID'";
    $result = mysqli_query($conn,$getPatientLA);
    if ($result->num_rows > 0) {
        $pLA = mysqli_fetch_assoc($result);
    }
    if (empty($pCPT)){
        $pCPT = $pLA ['chestPainType'];
    }
    if (empty($pEA)){
        $pEA = $pLA ['exerciseAngina'];
    }
    if (empty($pHT)){
        $pHT = $pLA ['hypertension'];
    }
    if (empty($pHD)){
        $pHD = $pLA ['heartDisease'];
    }
    if (empty($pRT)){
        $pRT = $pLA ['residenceType'];
    }
    if (empty($pSS)){
        $pSS = $pLA ['smokingStatus'];
    }
    $updatePatientHistory = " UPDATE labanalysis SET chestPainType='$pCPT',bloodPressure='$pBP',cholesterol='$pC',maxHeartRate='$pMHR',exerciseAngina='$pEA',plasmaGlucose='$pPG',skinThickness='$pST',insulin='$pI',bmi='$pBMI',diabetesDegree='$pDD',hypertension='$pHT',heartDisease='$pHD',Pregnancies='$pPreg', residenceType = '$pRT', smokingStatus = '$pSS' WHERE patientID = '$pID'";
    $resultUpdatePH = mysqli_query($conn, $updatePatientHistory);
    $updatePatientProfile = $conn->prepare("UPDATE patients SET toPay = toPay - ?, paid = paid + ? WHERE ID = ?");
    $updatePatientProfile->bind_param("iis", $toPay, $toPay, $pID);
    $updatePatientProfile->execute();
    $updatePatientProfile->close();
    echo " <script>alert(' تم تحديث البيانات بنجاح');</script> ";
    header('Refresh:1 ; URL = ../Views/receptionistReservations.php');
    $conn->close();
    die();
}
// Nurse edits Patient's
else if(isset($_POST['npEdit'])){
    if (($_FILES['prescription']['name'] == '')){
        echo " <script>alert(' !! ');</script> ";
        header('Refresh:1 ; URL = ../Views/nurseReservations.php');
        die();
    } else {
        $prescription = $_FILES['prescription'];
        $photo_name = $prescription['name'];
        $photo_tmp_name = $prescription['tmp_name'];
        $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);
        $photo_new_name = uniqid() . "." . $photo_extension;
        move_uploaded_file($photo_tmp_name, "../Uploads/Images/$photo_new_name");
        $rID = trim(htmlspecialchars($_POST['rID']));
        $updatePatientProfile = " UPDATE reservationtable SET prescription = '$photo_new_name' WHERE ID = '$rID' ";
    }
    $update = mysqli_query($conn, $updatePatientProfile);
    if (!$update){
        echo " <script>alert(' لقد حدث خطأ, برجاء المحاولة مرة اخرى ');</script> ";
        header('Refresh:1 ; URL = ../Views/nurseReservations.php');
        $conn->close();
    } else {
        echo " <script>alert(' لقد تم تحديث البيانات بنجاح ');</script> ";
        header('Refresh:1 ; URL = ../Views/nurseReservations.php');
        $conn->close();
    }
}
else if(isset($_POST['updatePatientHistory'])){
    $pID = trim(htmlspecialchars($_POST['pID']));
    $pBP = trim(htmlspecialchars($_POST['pBP']));
    $pPG = trim(htmlspecialchars($_POST['pPG']));
    $pST = trim(htmlspecialchars($_POST['pST']));
    $pI = trim(htmlspecialchars($_POST['pI']));
    $pBMI = trim(htmlspecialchars($_POST['pBMI']));
    $pDD = trim(htmlspecialchars($_POST['pDD']));
    $pPreg = trim(htmlspecialchars($_POST['pPreg']));
    $updatePatientHistory = " UPDATE labanalysis SET bloodPressure='$pBP', plasmaGlucose='$pPG',skinThickness='$pST',insulin='$pI',bmi='$pBMI',diabetesDegree='$pDD', Pregnancies='$pPreg' WHERE patientID = '$pID'";
    $result = mysqli_query($conn, $updatePatientHistory);
} 
else if(isset($_POST['rEditPpayment'])){
    $toPay = trim(htmlspecialchars($_POST['toPay']));
    $pID = trim(htmlspecialchars($_POST['pID']));
    $updatePatientProfile = $conn->prepare("UPDATE patients SET toPay = toPay - ?, paid = paid + ? WHERE ID = ?");
    $updatePatientProfile->bind_param("iis", $toPay, $toPay, $pID);
    $updatePatientProfile->execute();
    $updatePatientProfile->close();
    echo " <script>alert(' تم تحديث البيانات بنجاح');</script> ";
    header('Refresh:1 ; URL = ../Views/receptionistReservations.php');
    $conn->close();
    die();
}
else if(isset($_POST['EditPHistory'])){
    $pID = trim(htmlspecialchars($_POST['pID']));
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
    $getPatientLA = " SELECT * FROM labanalysis WHERE patientID = '$pID'";
    $result = mysqli_query($conn,$getPatientLA);
    if ($result->num_rows > 0) {
        $pLA = mysqli_fetch_assoc($result);
    }
    if (empty($pCPT)){
        $pCPT = $pLA ['chestPainType'];
    }
    if (empty($pEA)){
        $pEA = $pLA ['exerciseAngina'];
    }
    if (empty($pHT)){
        $pHT = $pLA ['hypertension'];
    }
    if (empty($pHD)){
        $pHD = $pLA ['heartDisease'];
    }
    if (empty($pRT)){
        $pRT = $pLA ['residenceType'];
    }
    if (empty($pSS)){
        $pSS = $pLA ['smokingStatus'];
    }
    $updatePatientHistory = " UPDATE labanalysis SET chestPainType='$pCPT',bloodPressure='$pBP',cholesterol='$pC',maxHeartRate='$pMHR',exerciseAngina='$pEA',plasmaGlucose='$pPG',skinThickness='$pST',insulin='$pI',bmi='$pBMI',diabetesDegree='$pDD',hypertension='$pHT',heartDisease='$pHD',Pregnancies='$pPreg',residenceType = '$pRT', smokingStatus = '$pSS' WHERE patientID = '$pID'";
    $resultUpdatePH = mysqli_query($conn, $updatePatientHistory);
    if ($resultUpdatePH){
    echo " <script>alert(' تم تحديث البيانات بنجاح');</script> ";
    header('Refresh:1 ; URL = ../Views/index.php');
    $conn->close();
    die();
    } else {   
    echo " <script>alert(' حدث خطأ ما, برجاء المحاولة لاحقا ');</script> ";
    header('Refresh:1 ; URL = ../Views/index.php');
    $conn->close();
    die();
    }
}
