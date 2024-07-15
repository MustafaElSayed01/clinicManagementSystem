<?php
session_start();
include_once 'connect.php';
if (isset($_POST['login']) && !empty($_POST['userID']) && !empty($_POST['userPW']) && !empty($_POST['roles'])) {
    $userID = trim(htmlspecialchars($_POST['userID']));
    $userPW = trim(htmlspecialchars($_POST['userPW']));
    $role = trim(htmlspecialchars($_POST['roles']));
    if (!empty($userID) && !empty($userPW) && !empty($role)) {
        if ($role == '100') {
            $query = "SELECT * FROM admin WHERE userID = $userID";
            $queryResult = mysqli_query($conn, $query);
            if ($queryResult->num_rows > 0) {
                $user_data = mysqli_fetch_assoc($queryResult);
                if (password_verify($userPW, $user_data['userPW'])) {

                    if ($user_data['isLogged'] == '0') {
                        $_SESSION['NID'] = $user_data['nationalID'];
                        $_SESSION['Role'] = $user_data['role'];
                        $logged = "UPDATE admin SET isLogged = '1' WHERE userID = $userID";
                        $loginResult = mysqli_query($conn, $logged);
                        header('Location:../Views/index.php');
                        die();
                    } else {
                        echo " <script>alert(' برجاء تسجيل الخروج من جميع الأجهزه الأخرى والمحاولة لاحقا  ');</script> ";
                        header('Refresh:1 ; URL = ../Views/login.php');
                        die();
                    }
                } else {
                    echo " <script>alert(' برجاء التأكد من صحة كلمة المرور والمحاولة لاحقا  ');</script> ";
                    header('Refresh:1 ; URL = ../Views/login.php');
                    die();
                }
            } else {
                echo " <script>alert(' اسم المستخدم هذا غير مسجل  ');</script> ";
                header('Refresh:1 ; URL = ../Views/login.php');
                die();
            }
        } else {
            $query = "SELECT * FROM users WHERE userID = $userID";
            $queryResult = mysqli_query($conn, $query);
            if ($queryResult->num_rows > 0) {
                $user_data = mysqli_fetch_assoc($queryResult);
                if (password_verify($userPW, $user_data['userPW'])) {
                    if ($user_data['role'] == $role) {
                        if ($user_data['isLogged'] == '0') {
                            $_SESSION['NID'] = $user_data['userID'];
                            $_SESSION['Role'] = $user_data['role'];
                            $logged = "UPDATE users SET isLogged = '1' WHERE userID = $userID";
                            $loginResult = mysqli_query($conn, $logged);
                            header('Location:../Views/index.php');
                            die();
                        } else {
                            echo " <script>alert(' برجاء تسجيل الخروج من جميع الأجهزه الأخرى والمحاولة لاحقا  ');</script> ";
                            header('Refresh:1 ; URL = ../Views/login.php');
                            die();
                        }
                    } else {
                        echo " <script>alert(' برجاء اختيار شخصيه صحيحة والمحاولة لاحقا  ');</script> ";
                        header('Refresh:1 ; URL = ../Views/login.php');
                        die();
                    }
                } else {
                    echo " <script>alert(' برجاء التأكد من صحة كلمة المرور والمحاولة لاحقا  ');</script> ";
                    header('Refresh:1 ; URL = ../Views/login.php');
                    die();
                }
            } else {
                echo " <script>alert(' برجاء التوجه الى العيادة لطلب الاكونت الخاص بك للتسجيل  ');</script> ";
                header('Refresh:1 ; URL = ../Views/login.php');
                die();
            }
        }
    }
}
