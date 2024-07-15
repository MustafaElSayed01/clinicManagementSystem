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
    die($conn->error);
  }
  $nextWeek = strtotime('next week');
  $firstOFweek = date('Y-m-d', strtotime("monday -2 days", $nextWeek));
  $lastOFweek = date('Y-m-d', strtotime("monday +4 days", $nextWeek));
include_once 'navbar.php';
?>
<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='../CSS/nTimeTable.css'>
    <title>جدول الاسبوع التالي</title>
</head>
<!-- // Ophthalmologist //opt
// Otolaryngologist  //oto
// Dentist //den
// Dermatologist //der
// Diabetes //dia -->
<?php
$week = ["SAT","SUN","MON","TUE","WED","THU"];
$specializations = ["Opt","Oto","Den","Der","Dia"];
$tHead = ["عيون","أنف وأذن وحنجرة","أسنان","جلدية","أمراض الباطنة"];
  echo "
<body>";
echo"
<div class='timeTable'>
<div class='table100 ver'>
<table>
      <thead>
      <tr class='head'>
      <th>التخصص/اليوم</th>
          <th>السبت</th>
          <th>الاحد</th>
          <th>الاثنين</th>
          <th>الثلاثاء</th>
          <th>الاربعاء</th>
          <th>الخميس</th>
        </tr>
      </thead>
      <tbody>
      ";
      for($i = 0; $i < sizeof($specializations); $i++){
        echo"<tr><th>$tHead[$i]</th>";
        for($j = 0; $j < sizeof($week); $j++){
            echo"<td><div id='$week[$j]$specializations[$i]'></div></td>";
        }
    }
    echo" 
      </tbody>
    </table>
    <div class = 'links'>
      <a href='addNTimeTable.php?edit=add'>اضافة</a>
      <a href='deleteNTimeTable.php?edit=delete'>حذف</a>
      <a id='friday' href='../handlers/handleUpdateTimeTable.php'>تحديث</a>
    </div>
  </div>
  </div>
";
  $queryArray = array(
    array('day' => 'SATOpt', 'reserveDay' => 'Sat', 'specialization' => 'عيون'), array('day' => 'SATOto', 'reserveDay' => 'Sat', 'specialization' => 'أنف وأذن وحنجرة'), array('day' => 'SATDen', 'reserveDay' => 'Sat', 'specialization' => 'أسنان'), array('day' => 'SATDer', 'reserveDay' => 'Sat', 'specialization' => 'جلدية'), array('day' => 'SATDia', 'reserveDay' => 'Sat', 'specialization' => 'أمراض باطنة'),
    array('day' => 'SUNOpt', 'reserveDay' => 'Sun', 'specialization' => 'عيون'), array('day' => 'SUNOto', 'reserveDay' => 'Sun', 'specialization' => 'أنف وأذن وحنجرة'), array('day' => 'SUNDen', 'reserveDay' => 'Sun', 'specialization' => 'أسنان'), array('day' => 'SUNDer', 'reserveDay' => 'Sun', 'specialization' => 'جلدية'), array('day' => 'SUNDia', 'reserveDay' => 'Sun', 'specialization' => 'أمراض باطنة'),
    array('day' => 'MONOpt', 'reserveDay' => 'Mon', 'specialization' => 'عيون'), array('day' => 'MONOto', 'reserveDay' => 'Mon', 'specialization' => 'أنف وأذن وحنجرة'), array('day' => 'MONDen', 'reserveDay' => 'Mon', 'specialization' => 'أسنان'), array('day' => 'MONDer', 'reserveDay' => 'Mon', 'specialization' => 'جلدية'), array('day' => 'MONDia', 'reserveDay' => 'Mon', 'specialization' => 'أمراض باطنة'),
    array('day' => 'TUEOpt', 'reserveDay' => 'Tue', 'specialization' => 'عيون'), array('day' => 'TUEOto', 'reserveDay' => 'Tue', 'specialization' => 'أنف وأذن وحنجرة'), array('day' => 'TUEDen', 'reserveDay' => 'Tue', 'specialization' => 'أسنان'), array('day' => 'TUEDer', 'reserveDay' => 'Tue', 'specialization' => 'جلدية'), array('day' => 'TUEDia', 'reserveDay' => 'Tue', 'specialization' => 'أمراض باطنة'),
    array('day' => 'WEDOpt', 'reserveDay' => 'Wed', 'specialization' => 'عيون'), array('day' => 'WEDOto', 'reserveDay' => 'Wed', 'specialization' => 'أنف وأذن وحنجرة'), array('day' => 'WEDDen', 'reserveDay' => 'Wed', 'specialization' => 'أسنان'), array('day' => 'WEDDer', 'reserveDay' => 'Wed', 'specialization' => 'جلدية'), array('day' => 'WEDDia', 'reserveDay' => 'Wed', 'specialization' => 'أمراض باطنة'),
    array('day' => 'THUOpt', 'reserveDay' => 'Thu', 'specialization' => 'عيون'), array('day' => 'THUOto', 'reserveDay' => 'Thu', 'specialization' => 'أنف وأذن وحنجرة'), array('day' => 'THUDen', 'reserveDay' => 'Thu', 'specialization' => 'أسنان'), array('day' => 'THUDer', 'reserveDay' => 'Thu', 'specialization' => 'جلدية'), array('day' => 'THUDia', 'reserveDay' => 'Thu', 'specialization' => 'أمراض باطنة')
  );
  foreach ($queryArray as $d => $day) {
    $query = "SELECT specialization, doctorName, doctorID FROM timetable
    WHERE day ='" . $day['reserveDay'] . "' AND specialization ='" . $day['specialization'] . "' AND nextWeek BETWEEN '$firstOFweek' AND '$lastOFweek' LIMIT 1";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "
            <script>
                document.getElementById('$day[day]').innerHTML = '$row[doctorName]';
            </script>
        ";
    }
  }

include_once 'footer.php';
  $conn->close();
  ?>
</body>
<script>
var today = new Date();
if (today.getDay() !== 5) {
  document.getElementById("friday").style.display = "none";
}
</script>
</html>