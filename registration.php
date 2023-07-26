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
    <title>User Registration Form</title>
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
			
        }
		
		.tasks input[type="submit"] {
			padding : 20px;
			font-size: 30px;
			font-alignment: center;
			
		}

        .warning {
            background-color: #ff9800;
        }

        .info {
            background-color: #2196F3;
        }
		
		 input {
            color: black;
            cursor: pointer;
			width: 300px;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
		
				
		form {
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 350px;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
		
		select {
            width: 370px;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
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
	<h3> User :<?php echo " ".$user; ?> </h3>
    <h2 style = "text-align: center;">Customer Registration</h2>
    <form action="db.php" method="post">
        <label for="name">Customer Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="contact">Contact Number:</label>
        <input type="tel" id="contact" name="contact" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="taskID">Select Task:</label>
        <select id="taskID" name="taskID" required>
            <option value="task1">New Driving License</option>
            <option value="task2">ReNew Driving License</option>
            <option value="task3">Get Missplaced License</option>
            <!-- Add more options as needed -->
        </select>
		
		<br><br>

        <input type="submit" value="Register">
        <!-- Add more content and functionalities here -->
    </div>
	
	
	<script>
        document.getElementById("registrationForm").onsubmit = function(event) {
            event.preventDefault();
            generateTaskID();
            // You can now proceed with form submission if needed.
            // For demonstration purposes, we'll just log the form data to the console.
            const formData = new FormData(document.getElementById("registrationForm"));
            for (const entry of formData.entries()) {
                console.log(entry[0] + ": " + entry[1]);
            }
        };

        function generateTaskID() {
            const contactNumber = document.getElementById("contact").value;
            const currentDate = new Date().toISOString().slice(0, 10); // Format: YYYY-MM-DD
            const taskID = contactNumber + "-" + currentDate;
            document.getElementById("taskID").value = taskID;
        }
    </script>
</body>
</html>