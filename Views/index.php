<?php
session_start();
if (isset($_SESSION['NID']) && ($_SESSION['Role'])) {
    $ID = $_SESSION['NID'];
    $role = $_SESSION['Role'];
    $validRoles = array(100, 4, 3, 2, 1);
    if (in_array($role, $validRoles)) {
        include_once 'navbar.php';
    }
} else {
    $role = 5;
    include_once 'navbarNONUSER.php';
}
?>
<!DOCTYPE html>
<html dir='rtl' lang='ar'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>الصفحة الرئيسية</title>
    <!-- Render All Elements Normally -->
    <link rel='stylesheet' href='../CSS/normalize.css' />
    <!-- Font Awesome Library -->
    <link rel='stylesheet' href='../CSS/all.min.css' />
    <!-- Main Template CSS File -->
    <link rel='stylesheet' href='../CSS/home.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <!-- Google Fonts -->
    <link rel='preconnect' href='https://fonts.gstatic.com' />
    <link href='https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap' rel='stylesheet' />
</head>

<body>
    <!-- Start Landing -->
    <div class='landing'>
        <!-- ال overlay هي طبقة شفافة فوق الخلفية -->
        <div class='overlay'></div>
        <div class='text'>
            <?php
            if ($role != '4') {
                echo "<div class='content'>
                <h2>خدمات طبيه <br><b>يمكنك الوثوق بها</b></h2>
                <p>نحن ملتزمون بالتميز في رعاية المرضى وجودة وموثوقية الخبرة في الرعاية الصحية</p>
                <p>تقدم عيادتنا خدمات عالية الجودة</p>
                </div>";
            } else {
                echo "<div class='content'>
                <h2>خدمات طبيه <br><b>يمكنك الوثوق بها</b></h2>
                <p>اذا كنت تعاني من بعض الالام ف اجب على بعض الاسئله قد تساعد في تشخيص مرضك</p>
                <p>ويجب العلم أن جميع النتائج الصادرة هي نتائج تجربة ويفضل مراجعة جدول المواعيد لمراجعة الطبيب المختص</p>
                <button><a href='predict.php'> اجب الان </a></button>
                </div> ";
            }
            ?>
        </div>
    </div>
    <!-- End Landing -->
    <?php
    include_once 'footer.php';
    ?>
</body>

</html>