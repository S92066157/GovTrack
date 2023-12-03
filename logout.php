<?php

include 'connect.php';

session_start();

$currentUsername = $_SESSION['user_name'];
$usertype = $_SESSION['usertype'];

if($usertype == "frontoffice" || $usertype == "backoffice") {
    $sql = "UPDATE users SET isbeingUsed = 0 WHERE username = '$currentUsername';";

    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        session_unset();
        session_destroy();
    
        header('location:index.php');
    } else {
        echo '<script> alert("Unknown Error Occured !"); </script>';
    }
}
else {
        session_unset();
        session_destroy();
    
        header('location:admin/adminlogin.php');
}






?>