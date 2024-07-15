<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
<meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='../CSS/navbar.css'>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
</head>

<body>
    <header>
        <!-- Start Navbar -->
        <div class='nav-container'>
            <a href='index.php'> <img src='../img/Logo-01.png' alt='Logo' width='50px' /></a>
            <nav>
                <i class='fas fa-bars toggle-menu'></i>
                <ul>
                    <li><a class='active' href='index.php'>الصفحة الرئيسية</a></li>
                    <li><a href='profile.php'>الملف الشخصي</a></li>
                    <li><a href='timeTable.php'>جدول العيادة</a></li>
                    <li><a href='../handlers/handleLogout.php'>تسجيل الخروج</a></li>
                </ul>
                <form action='search.php' method='POST'>
                    <input type='text' name='target'>
                    <input type='submit' value='ابحث' name='search'>
                </form>
            </nav>
        </div>
    </header>
    <!-- End Navbar -->

</body>

</html>