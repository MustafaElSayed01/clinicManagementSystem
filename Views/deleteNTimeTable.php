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
?>
<!DOCTYPE html>
<html dir='rtl' lang='ar'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="stylesheet" href="../CSS/addDeleteNTT.css">
    <title>تعديل جدول الاسبوع التالي</title>
</head>
<?php

$getDoctors = "SELECT name,ID FROM doctors ORDER BY specialization ASC";
$resultgetDoctors = mysqli_query($conn, $getDoctors);
if (!$resultgetDoctors) {
    die("Error getting data from database" . $conn->error);
}
$nextWeek = strtotime('monday next week');
$firstOFweek = date('Y-m-d', strtotime("monday", $nextWeek));
$lastOFweek = date('Y-m-d', strtotime("monday +6 days", $nextWeek));    
echo " 
<body>";
include_once 'navbar.php'; 
echo"
<div class='bg'></div>
        <div class='left'>
        <form action='../handlers/handleEditNTimeTable.php' method='POST'>
        <div class='edit'>
            <label> اليوم </label>
            <input type = 'date' id = 'fdate' min = '$firstOFweek' max = '$lastOFweek' name = 'reservedDate' onchange = 'myDate()' required>
            <input  id = 'fday' name = 'dayAR' disabled>";?>
                <?php echo"
                <label> اختر الدكتور </label>
                <select name ='dID'>
                            <option></option>  "?>
                    <?php
                    while ($row = $resultgetDoctors->fetch_assoc()) {
                        echo "<option value= '" . $row['ID']. "'>" . $row['name'] . "</option>"; 
                    }
                    ?>
                        </select>
                        <input type='submit' name ='dTDelete' value='حذف'>
                    </div> 
    </form>
    </div>
<footer>       
        <?php
            include_once 'footer.php';
        ?>
</footer>
<script src='JS/reserve.js'></script>
</body>
</html>