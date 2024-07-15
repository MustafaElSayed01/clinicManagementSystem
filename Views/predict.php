<?php
session_start();
include_once '../handlers/connect.php';
if(isset($_SESSION['NID']) && ($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
}
$validRoles = array(4);
if (!in_array($role,$validRoles)){
    echo " <script>alert(' غير مسموح لك بالدخول ');</script> ";
    header('Refresh:1 ; URL = index.php');
    die($conn->error);
}
$getpData = "SELECT * FROM users INNER JOIN patients ON users.userID = patients.nationalID INNER JOIN labanalysis on patients.ID = labanalysis.patientID WHERE users.userID = $ID";
$resultpData = mysqli_query($conn,$getpData);
if ($resultpData ->num_rows > 0){
    $patientData = mysqli_fetch_assoc($resultpData);
}
?>

<html lang="ar" dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='../CSS/all.min.css'>
    <link rel='stylesheet' href='../CSS/normalize.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="../CSS/predict.css">
    <title>predict</title>
</head>

<body>
    <?php include_once 'navbar.php'; ?>
    <div class='pred-container'>
        <div class='bg'></div>
        <div class='left'>
            <div class='info'>
                <h2>برجاء الاجابه على هذه الاسئله</h2>
                <form method='POST' onsubmit='validPPInputs()' action='../handlers/handleEditProfile.php'>
                    <div class='edit'>
                    <label> Age </label>
                        <input type='number'
                            placeholder='<?php echo $patientData['age'] ?><?php echo"' disabled>
                        <br/>
                        <label> Blood Pressure </label>
                        <input type='number' placeholder = '"; ?><?php echo $patientData['bloodPressure'] ?><?php echo"' id = 'pBP' name='pBP'>
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
                        <label> Pregnancies </label>
                        <input type='number'  id = 'pPreg' placeholder = '"; ?><?php echo $patientData['Pregnancies'] ?>' name='pPreg'>
                        <br />
                        <input type='hidden' name='pID' value = '<?php echo $patientData['ID'] ?>' >
                        <input type='submit' name='updatePatientHistory' value='تأكيد'>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php 
include_once 'footer.php';
?>
</body>
<script src='JS/functions.js'></script>

</html>