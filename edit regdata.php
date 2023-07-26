
<?php
include 'connect.php';
session_start();

$id = "";
            $name = "";
            $email = "";
            $contact = "";
            $address = "";

if (!$conn) {
    die("Connection Unsuccessful - " . mysqli_connect_error());
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $sql = "SELECT id, name, email, contact, address FROM user_registration WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
			$id = $row["id"];
            $name = $row["name"];
            $email = $row["email"];
            $contact = $row["contact"];
            $address = $row["address"];
			
			$_SESSION['userid'] = $row['id'];
			
			
        }
    } else {
        echo "No results";
    }
}

mysqli_close($conn);
?>



<!DOCTYPE html>
<html>
<head>
    <title>Edit Registration Details of user</title>
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
		
		.bodycontent {
			width: 60%;
			margin: auto;
		}
		
		.input-container {
            position: relative;
		
        }

        .button-in-front {
            position: absolute;
            top: 60%;
            left: 400px; 
			width: 100px;
            transform: translateY(-50%);
            background-color: #007BFF;
            color: white;
            padding: 8px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .text-input {
            padding-left: 30px; 
            width: 200px; 
            height: 30px; 
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
		
		.footer {
			font-size: 20px;
			text-align: center;
			height: 10%;
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
    <h2>Edit Registration Details</h2>
	
	
<div class="bodycontent">
	
	<fieldset>
    <legend> Task Reference</legend>
	
    <form action="" method="post">

	 
  <div class="input-container">
	<label for="name">Unique ID:</label>
        <input type="text" id="id" name="id" required>
        <button class="button-in-front">Load Details</button>
        
    </div>
	
	
	</form>
  </fieldset>
  
  <br> <br>
  
  <fieldset>
    <legend> User Details</legend>
  
   <form action="update.php" method="post">
        
        <!-- <label style = "font-weight: bold; " > Unique ID : <?php echo $_SESSION['userid']; ?> </label> -->
		<br>
		
		<label for="name">Unique ID: ( READ ONLY )</label>
        <input type="text" id="userid" name="userid" value="<?php echo $id; ?>" required  readonly>

		
        <label for="name">Customer Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

        <label for="contact">Contact Number:</label>
        <input type="tel" id="contact" name="contact" value="<?php echo $contact; ?>"required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>

        		
		<br><br>

        <input type="submit" value="Save">
        <!-- Add more content and functionalities here -->
		
		</form>
		
		</fieldset>
    </div>
	
	<div class ="footer">

	<p> All rights Reserved </p>
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