<?php

include 'connect.php';

session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['username']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['usertype'] == 'frontoffice'){

		$_SESSION['usertype'] = $row['usertype'];
		$_SESSION['user_name'] = $row['username'];
	
         //$_SESSION['username'] = $row['name'];
         //$_SESSION['user_email'] = $row['email'];
         //$_SESSION['user_id'] = $row['id'];
         header('location:front_officers.php');

      }elseif($row['usertype'] == 'backoffice'){
		  
		 $_SESSION['usertype'] = $row['usertype'];

         //$_SESSION['user_name'] = $row['name'];
         //$_SESSION['user_email'] = $row['email'];
         //$_SESSION['user_id'] = $row['id'];
         header('location:back_officers.php');

      }
	  elseif($row['usertype'] == 'admin'){

        $_SESSION['usertype'] == null;

      }

   }else{
      $message[] = 'Incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Officer's Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .login-container {
            width: 400px;
            margin: 100px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007BFF;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
			
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
		
		form {
		padding-left: 10%;
		}

        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

    <div class="login-container">
        <h1>Officer Login</h1>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <div class="error-message"> <!-- Show error message here if login fails -->
                <!-- Sample error message for demonstration purposes -->
                <?php
                if (isset($_GET['login_error']) && $_GET['login_error'] === '1') {
                    echo "Invalid username or password.";
                }
                ?>
            </div>

            <input type="submit" name="submit" value="Login Now" class="btn">
        </form>
    </div>
</body>
</html>