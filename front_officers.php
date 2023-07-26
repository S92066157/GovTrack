
<?php

include 'connect.php';

session_start();

$usertype = $_SESSION['usertype'];
$user = $_SESSION['user_name'];

if(!isset($usertype)){
   header('location:welcome.html');
}
elseif ($usertype == "backoffice") {
	header('location:back_officers.php');
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
			padding: 50px 0px 50px 30%;
		
			
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
      <a href="#">Home</a>
        <!--  <a href="#">Customers</a>
        <a href="#">Appointments</a>
        <a href="#">Reports</a> -->
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
	
	<h2> Welcome , <?php echo $user; ?> </h2>
 
        <p>Welcome to the front officer's dashboard. Here you can insert and manage customer data.</p>
        
		
		<div class="tasks">
            
			<a href="registration.php"><input type="submit" value="Insert New Customer"></a>
			<br><br><br>
			
			<a href="edit regdata.php"><input type="submit" value="Edit Existing Customer"></a>
			
			
        </div>
        <!-- Add more content and functionalities here -->
    </div>
</body>
</html>