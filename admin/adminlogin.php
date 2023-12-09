<?php

include ('../connect.php');

session_start();

if (isset($_POST['submit'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);


    $select_users = mysqli_query($conn, "SELECT * FROM users  WHERE BINARY username = '$username' AND BINARY password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) == 1) {

        $row = mysqli_fetch_assoc($select_users);

                if ($row['usertype'] == 'frontoffice' || $row['usertype'] == 'backoffice') {
                   

                    $message[] = 'Only Administrator can use this page to login to the system';
                    
                 } elseif ($row['usertype'] == 'admin') {
                    $_SESSION['usertype'] = $row['usertype'];
                    $_SESSION['user_name'] = $row['username'];
                    header('location:adminDashboard.php');

                } else {

                    $message[] = "User type not found";
                }

    } else {
        $message[] = 'Incorrect username or password!';
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> GoveTrack Administrator Login Page</title>
    <link rel="stylesheet" href="adminlogin.css">
    <style>

.button-style {
    background-color: #4caf50;
    color: white;
}

.button-style:hover {
    background-color: #45a049; 
}
    </style>
    
</head>
<body>
    <div class="header-image"></div>
    <div class="login-container">
        
        <h2>Administrator Login</h2>
            <form id="loginForm" method="POST" action="">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" name="submit" value="Login"  class="button-style">
                <input type="button" name="submit" value="Other Users"  onclick="location.href='../index.php'" class="button-style">
                
            </form>
        
    </div>
    <div class="footer-image"></div>


    <h4 style="text-align:center;"> 
                <?php
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '
      <div class="message">
         <span>' . $message . '</span>
      </div>
      ';
                    }
                }
                ?>
            </h4>

</body>
</html>
