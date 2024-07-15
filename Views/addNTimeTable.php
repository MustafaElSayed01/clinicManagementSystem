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
<body>
<?php
include_once 'navbar.php';
    $getDoctors = "SELECT name,ID FROM doctors WHERE specialization IS NOT NULL ORDER BY specialization ASC";
    $resultgetDoctors = mysqli_query($conn, $getDoctors);
    if (!$resultgetDoctors) {
        die("Error getting data from database" . $conn->error);
    }
    $nextWeek = strtotime('next week');
    $firstOFweek = date('Y-m-d', strtotime("monday -2 days", $nextWeek));
    $lastOFweek = date('Y-m-d', strtotime("monday +4 days", $nextWeek));
echo "<div class='bg'></div>
        <div class='left'>
            <form action='../handlers/handleEditNTimeTable.php' method='POST'>
                <div class='edit'>
                        <Label> اليوم </Label>
                        <input type = 'date' id = 'fdate' min = '$firstOFweek' max = '$lastOFweek' name = 'reserveDate' oninput='checkDayOfWeek(event)' onchange = 'myDate()' required>
                        <input  id = 'fday' name = 'dayAR' disabled> ";?>
                            <?php echo"
                            <Label> اختر الدكتور </Label>
                            <select name ='dID'> 
                                        <option></option> "?>
                                <?php
                                while ($row = $resultgetDoctors->fetch_assoc()) {
                                    echo "<option value= '" . $row['ID']. "'>" . $row['name'] . "</option>"; 
                                } 
                                ?>
                                    </select> 
                                    <Label> من الساعة </Label>
                                        <input type='time' name='timeFrom' id = 'timeFrom' step='3600' required>
                                    <Label> الى الساعة </Label>
                                        <input type='time' name='timeTo' id = 'timeTo' step='3600' required>
                                        <br/>
                                        <p id='timeError' style='color: red'></p>
                                        <input type='submit' name ='dTAssign' value='اضافة'>
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