<?php

include 'connect.php';

session_start();

$usertype = $_SESSION['usertype'];
$user = $_SESSION['user_name'];
$userID = $_SESSION['userid'];

if(!isset($usertype)){
   header('location:welcome.html');
}
elseif ($usertype == "backoffice") {
	header('location:back_officers.php');
}


?>




<?php
// Assuming you have already established a database connection.
// Replace DB_HOST, DB_USERNAME, DB_PASSWORD, and DB_NAME with your actual database credentials.

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the data to update from the form or any other source
    $name = $_POST["name"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $user = $_SESSION['user_name'];
	$userid = $_POST["userid"];

    // Perform validation if necessary.

    // Insert data into the database.
    $conn = new mysqli("localhost", "root", "ABCD", "govtrackdb");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Assuming you have a column called 'id' as a primary key in your table
    $userID = 1; // Replace this with the actual user ID you want to update.

    // Prepare the update query
    $sql = "UPDATE user_registration SET name = ?, email = ?, contact = ?, address = ?, empUsername = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $email, $contact, $address, $user, $_SESSION['userid']);

    if ($stmt->execute()) {
        // Update successful.
		
		$message[] = 'Update data Success';
       
    } else {
        // Update failed.
		$message[] = "Error: " . $stmt->error;
      
    }

    $stmt->close();
    $conn->close();
}
?>







<!DOCTYPE html>
<html>
<head>
    <title>Front Officer Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        header {
            background-color: #007BFF;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
        }

        nav a:hover {
            background-color: #007BFF;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        h1 {
            color: black;
        }

        p {
            color: #333;
            line-height: 1.6;
        }

        .alert {
            padding: 10px;
            background-color: #f44336;
            color: #fff;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .tasks {
            background-color: #fff;
			display: block;
			justify-content: center;
			padding: 50px 0px 50px 170px;
		
			
        }
		
		.tasks input[type="submit"] {
			padding : 20px;
			font-size: 30px;
			text-align: center;
			
		}

        .warning {
            background-color: #ff9800;
        }

        .info {
            background-color: #2196F3;
        }
		
		 input {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
			width: 450px;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
		
		
		input:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>GovTRACK</h1>
    </header>
    <nav>
      <a href="front_officers.php">Home</a>
        <!--  <a href="#">Customers</a>
        <a href="#">Appointments</a>
        <a href="#">Reports</a> -->
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
             
		
		<div class="tasks">
		
		
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

		<div class="tasks">
            
			<a href="front_officers.php"><input type="submit" value="Back to Home"></a>
		
			
        </div>
           
			
        </div>
        <!-- Add more content and functionalities here -->
    </div>
</body>
</html>


