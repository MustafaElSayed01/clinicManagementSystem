<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../CSS/login.css" />
    <link rel="stylesheet" href="../CSS/all.min.css" />
    <link rel="stylesheet" href="../CSS/normalize.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>تسجيل الدخول</title>
</head>

<body>
    <div class='container'>
        <div class='forms'>
            <div class='form-content'>
                <div class='login-form'>
                    <div class='title'>تسجيل الدخول</div>
                    <form autocomplete="off" class=" form" id="logIn" action="../handlers/handleLogin.php" method="POST">
                        <div class='input-boxes'>
                            <div class='input-box'>
                                <i class='fas fa-user'></i>
                                <input type='text' name='userID' placeholder='اسم المستخدم' required autofocus />
                            </div>
                            <div class='input-box'>
                                <i class='fas fa-lock'></i>
                                <input type='password' name='userPW' placeholder='كلمه المرور' required />
                            </div>
                            <div class='type'>
                                <input type='radio' name='roles' value='4' checked />
                                <label>مريض</label>
                                <input type='radio' name='roles' value='1' />
                                <label>دكتور</label>
                                <input type='radio' name='roles' value='2' />
                                <label>ممرض</label>
                                <input type='radio' name='roles' value='3' />
                                <label>استقبال</label>
                                <input type='radio' name='roles' value='100' />
                                <label>مسؤول</label>
                            </div>
                            <div class='button input-box'>
                                <input type="submit" value="تسجيل دخول" name="login" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="JS/loginValidation.js"></script>
</body>

</html>