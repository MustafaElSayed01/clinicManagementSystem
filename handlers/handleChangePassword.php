<?php
session_start();
include_once 'connect.php';
if(isset($_SESSION['NID']) && ($_SESSION['Role'])){
    $ID = $_SESSION['NID']; 
    $role = $_SESSION['Role'];
    if ($role == '100'){
        if(isset($_POST['updatePassword'])){
            $cPW = trim(htmlspecialchars($_POST['cPassword']));
            $nPW = trim(htmlspecialchars($_POST['nPassword']));
            if($cPW === $nPW){
                echo " <script>alert(' لا يمكن جعل كلمة المرور الجديده هي نفسها الحالية ');</script> ";
                header('Refresh:1 ; URL = ../Views/changePassword.php');
                    die();
            }
            $getUserInfo = " SELECT userPW FROM admin WHERE userID = $ID ";
            $queryResult = mysqli_query($conn, $getUserInfo);
            if ($queryResult->num_rows > 0) {
                $userData = mysqli_fetch_assoc($queryResult);
                if (password_verify($cPW, $userData['userPW'])){
                    $hashedPW = password_hash($nPW, PASSWORD_DEFAULT);
                    $updatePW = "UPDATE admin SET userPW = '$hashedPW' WHERE userID = $ID ";
                    $queryResult = mysqli_query($conn, $updatePW);
                } else { 
                    echo " <script>alert(' كلمة المرور الحالية غير صحيحة, برجاء اعادة المحاولة ');</script> ";
                    header('Refresh:1 ; URL = ../Views/changePassword.php');
                        die();
                }
            }
            echo " <script>alert(' تم تغيير كلمة المرور بنجاح ');</script> ";
            header('Refresh:1 ; URL = ../Views/profile.php');
                die();
        }
    } else {
        if(isset($_POST['updatePassword'])){
            $cPW = trim(htmlspecialchars($_POST['cPassword']));
            $nPW = trim(htmlspecialchars($_POST['nPassword']));
            if($cPW === $nPW){
                echo " <script>alert(' لا يمكن جعل كلمة المرور الجديده هي نفسها الحالية ');</script> ";
                header('Refresh:1 ; URL = ../Views/changePassword.php');
                    die();
            }
            $getUserInfo = " SELECT userPW FROM users WHERE userID = $ID ";
            $queryResult = mysqli_query($conn, $getUserInfo);
            if ($queryResult->num_rows > 0) {
                $userData = mysqli_fetch_assoc($queryResult);
                if (password_verify($cPW, $userData['userPW'])){
                    $hashedPW = password_hash($nPW, PASSWORD_DEFAULT);
                    $updatePW = "UPDATE users SET userPW = '$hashedPW' WHERE userID = $ID ";
                    $queryResult = mysqli_query($conn, $updatePW);
                } else { 
                    echo " <script>alert(' كلمة المرور الحالية غير صحيحة, برجاء اعادة المحاولة ');</script> ";
                    header('Refresh:1 ; URL = ../Views/changePassword.php');
                        die();
                }
            }
            echo " <script>alert(' تم تغيير كلمة المرور بنجاح ');</script> ";
            header('Refresh:1 ; URL = ../Views/profile.php');
                die();
        }
        
    }
} 
?>