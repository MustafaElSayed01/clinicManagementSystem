<?php
session_start();
include_once '../handlers/connect.php';
if (isset($_SESSION['NID']) && ($_SESSION['Role'])) {
	$ID = $_SESSION['NID'];
	$role = $_SESSION['Role'];
}
$validRoles = array(100, 1);
if (!in_array($role, $validRoles)) {
	echo " <script>alert(' غير مسموح لك بالدخول ');</script> ";
	header('Refresh:1 ; URL = profile.php');
	die();
}
if (isset($_GET['ID'])) {
	$dID = htmlspecialchars($_GET['ID']);
}
$getdData = "SELECT * FROM users INNER JOIN doctors ON users.userID = doctors.nationalID WHERE doctors.ID = '$dID'";
$resultdData = mysqli_query($conn, $getdData);
if ($resultdData->num_rows > 0) {
	$doctorData = mysqli_fetch_assoc($resultdData);
}
$getaData = "SELECT * FROM admin WHERE userID = '$ID' ";
$resultaData = mysqli_query($conn, $getaData);
if ($resultaData->num_rows > 0) {
	$adminData = mysqli_fetch_assoc($resultaData);
}
if (isset($_GET['view']) && $_GET['view'] == 'reservations') {
	if (isset($_GET['month'])) {
		if ($_GET['month'] == 'current') {
			$firstDayofMonth = date('Y-m-01');
			$lastDayofMonth = date('Y-m-t');
		} else if ($_GET['month'] == 'prev') {
			$firstDayofMonth = date('Y-m-01', strtotime('first day of last month'));
			$lastDayofMonth = date('Y-m-t', strtotime('last day of last month'));
		} else if ($_GET['month'] == 'today') {
			$today = date('Y-m-d');
			$startoftheday = $today . ' 00:00:00';
			$endoftheday = $today . ' 23:59:59';
			$firstDayofMonth = $startoftheday;
			$lastDayofMonth = $endoftheday;
		}
	}

	$sequence = 1;
	$shownData = "SELECT reservedDateFrom, reservedDayAR, patientName, patientNID FROM reservationtable WHERE doctorID = '$dID' AND isBusy = '1' AND reservationtable.reservedDateFrom BETWEEN '$firstDayofMonth' AND '$lastDayofMonth' ORDER BY reservedDateFrom ASC ";
	$resultShownData = $conn->query($shownData);
	if (!$resultShownData) {
		die();
	}
	if ($resultShownData->num_rows > 0) {
		function getAge($NID)
		{
			$bDecade = substr($NID, 0, 1);
			$bYear = substr($NID, 1, 2);
			$bMonth = substr($NID, 3, 2);
			$bDay = substr($NID, 5, 2);
			if ($bDecade == 2) {
				$year = '19' . $bYear;
			} elseif ($bDecade == 3) {
				$year = '20' . $bYear;
			}
			$fullDate = $year . '-' . $bMonth . '-' . $bDay;
			$bDate = new DateTime($fullDate);
			$today = new DateTime('today');
			$age = $bDate->diff($today)->y;
			return $age;
		}
?>
		<!DOCTYPE html>
		<html dir='rtl' lang='ar'>

		<head>
			<meta charset='UTF-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
			<link rel='stylesheet' href='../CSS/bootstrap.min.css'>
			<link rel="stylesheet" href="../CSS/doctorProfile.css">
			<title> حجوزات الطبيب </title>
		</head>

		<body>
			<?php
			include_once 'navbar.php';
			echo "
    <div class='container'>
    <div class='main'>
        <div class='row'>
            <div class='col-md-4 mt-1'>
                <div class='crad-body'>
                "; ?>
			<?php
			if ($role == 100) {
				echo "
                        <img src='Uploads/Images/" ?><?php echo $adminData['photo'] ?><?php echo "' class='rounded-circle' width='150' height = '150'>
                        <div class='mt-3 sidebar'>
                        <h3>" ?>
			<?php
				$name = explode(' ', $adminData['name']);
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
                            </div> ";
			} else if ($role == 1) {
				echo "
                                        <img src='Uploads/Images/" ?><?php echo $doctorData['photo'] ?><?php echo "' class='rounded-circle' width='150' height = '150'>
                    <div class='mt-3 sidebar'>
                    <h3>" ?>
			<?php
				$name = explode(' ', $doctorData['name']);
				echo $name[0] . ' ' . $name[1] ?>
		<?php echo "</h3>
                                <a href=''>الصفحه الرئيسيه</a>
                                <a href='editProfile.php'>تعديل البيانات</a>
                                <a href='changePassword.php'>تغيير كلمة المرور</a>
                                <a href='doctorProfile.php?view=reservations&month=current&ID=$ID'>الحجوزات</a>
                                <a href='../handlers/handleLogout.php'> تسجيل الخروج</a>
                            </div>
                        ";
			}
		?>
		<?php echo "
                </div>
            </div>
        <div class='col-md-8 mt-1'>
            <div class='card mb-3 content'>
            <div class='card-body'>
        <table>
                <tr>
                    <th>التسلسل</th>
                    <th>التاريخ:</th>
                    <th>اليوم:</th>
                    <th>المعاد:</th>
                    <th>اسم المريض:</th>
                    <th>عمر المريض:</th>
                </tr>
    ";
		while ($row = $resultShownData->fetch_assoc()) {
			$pNID = $row['patientNID'];
			$pAge = getAge($pNID);
			$date = date("Y-m-d", strtotime($row['reservedDateFrom']));
			$time = date('H:i', strtotime($row['reservedDateFrom']));
			$datetime = strtotime($time);
			$arabic_time = strftime('%I:%M %p', $datetime);
			echo "<tr>
        <td>" . $sequence . "</td>
        <td>" . $date . "</td>
        <td>" . $row['reservedDayAR'] . "</td>
        <td>" . $arabic_time . "</td>
        <td>" . $row['patientName'] . "</td>    
        <td>" . $pAge . "</td>    
            </tr>";
			$sequence++;
		}
		echo "
            </table>
            <div class='links'>
            <a href='doctorProfile.php?ID=$dID&view=reservations&month=prev'>الشهر الماضي</a>
            <a href='doctorProfile.php?ID=$dID&view=reservations&month=current'>الشهر الحالي</a>
            <a href='doctorProfile.php?ID=$dID&view=reservations&month=today'> حجوزات اليوم </a>
            </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
            <footer>";
		include_once 'footer.php';
		echo "
            </footer>
            </body>
            </html>
    ";
	} else {
		echo " <script> alert(' عذرا, لا توجد بيانات للعرض '); </script> ";
		header('Refresh:1 ; URL= profile.php');
	}
} else if (isset($_GET['view']) &&  $_GET["view"] == 'profile') {
	$getDoctorInfo = " SELECT * FROM doctors WHERE ID = '$dID' ";
	$reservationsCount = " SELECT COUNT(*) AS count FROM reservationtable WHERE doctorID = '$dID' AND isBusy = '1' ";
	$resultGetData = mysqli_query($conn, $getDoctorInfo);
	if ($resultGetData->num_rows > 0) {
		$doctorData = mysqli_fetch_assoc($resultGetData);
		$resultReservations = mysqli_query($conn, $reservationsCount);
		if ($resultReservations === false) {
			die();
		}
		$doctorReservations = $resultReservations->fetch_assoc();
		include_once 'navbar.php';
		echo "    
            <!DOCTYPE html>
    <html dir='rtl' lang='ar'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='../CSS/doctorProfile.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
            <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
        <title> بيانات الطبيب </title>
    </head>
    <body>
    <div class='container'>
    <div class='main1'>
        <div class='row'>
            <div class='col-md-4 mt-1'>
                <div class='crad-body'>
                <img src='Uploads/Images/" ?><?php echo $doctorData['photo'] ?><?php echo "' class='rounded-circle' width='150'>
                    <div class='mt-3 sidebar'> 
                        <h3></h3>
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
        <h4> الاسم </h4>
        <p>"; ?><?php echo $doctorData['name'] ?><?php echo "</p>
        <hr>
        <h4> السن </h4>
        <p>"; ?><?php echo $doctorData['age'] ?><?php echo "</p>
        <hr>

        <h4> التخصص </h4>
        <p>"; ?><?php echo $doctorData['specialization'] ?><?php echo "</p>
        <hr>

        <h4> رقم الهاتف  </h4>
        <p>"; ?><?php echo $doctorData['phone'] ?><?php echo "</p>
        <hr>

        <h4> الرقم القومي  </h4>
        <p>"; ?><?php echo $doctorData['nationalID'] ?><?php echo "</p>
        <hr>

        <h4> البريد الإليكتروني  </h4>
        <p>"; ?><?php echo $doctorData['emailAddress'] ?><?php echo "</p>
        <hr>

        <h4> عنوان السكن  </h4>
        <p>"; ?><?php echo $doctorData['address'] ?><?php echo "</p>
        <hr>

        <h4> نبذه عنه  </h4>
        <p>"; ?><?php echo $doctorData['description'] ?><?php echo "</p>
        <hr>

        <h4> إجمالي حجوزات الطبيب </h4>
        <p>"; ?><?php echo $doctorReservations['count'] ?><?php echo "</p>
        <hr>

        <form method='POST' onsubmit='validADInputs()' action='../handlers/handleEditProfile.php'>
            <label> ثمن الكشف </label>
            <input type = 'number' name = 'reservationPrice' id = 'RPrice' placeholder = '"; ?><?php echo $doctorData['reservationPrice'] ?><?php echo "'>
        <hr>
            
            <label> سعر الساعة </label>
            <input  type = 'number' name = 'perHour' id = 'pHour' placeholder = '"; ?><?php echo $doctorData['perHour'] ?><?php echo "'>
            <input hidden name = 'dID' value ='"; ?><?php echo $doctorData['ID'] ?><?php echo "'>
            <input type='submit' name ='adEdit' value='تعديل'>
            </form>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            <footer>";
include_once 'footer.php';
echo "
            </footer>
        </body>
        <script src='JS/functions.js'></script>
        <script src='JS/doctorProfile.js'></script>
    ";
}
}
$conn->close();
?>