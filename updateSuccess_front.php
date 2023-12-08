
<?php

include 'connect.php';

session_start();

$usertype = $_SESSION['usertype'];
$cusUID = $_SESSION['cusUniqueID'];

if(!isset($usertype)){
   header('location:index.php');
}
elseif ($usertype == "backoffice") {
	header('location:task_backoffice.php');
}


?>


<?php


// Assuming you have already established a database connection.
// Replace DB_HOST, DB_USERNAME, DB_PASSWORD, and DB_NAME with your actual database credentials.

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the data to update from the form or any other source
   
    $email = $_POST["cusEmailNew"];
    $contact = $_POST["cusContactNew"];
    $address = $_POST["cusAddressNew"];
    $user = $_SESSION['user_name'];
    


    // Perform validation if necessary.

    // Insert data into the database.
   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the update query using prepared statement
    $sql = "UPDATE customer_registration SET  email = ?, contact = ?, address = ?, empUsername = ? 
	WHERE uniqueID = ?";
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bind_param("sssss", $email, $contact, $address, $user, $cusUID);

    // Execute the statement
    if ($stmt->execute()) {
        // Update successful.
		
		$message[] = 'Customer details of following reference has been successfully updated.';
       
    } else {
        // Update failed.
		$message[] = "Error: " . $stmt->error;
      
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Success</title>

    <style>
       body {
            height: 99vh;
            width: 95vw;
            font-weight: bolder;
            margin: auto;

        }

        body button {
            background-color: rgb(236, 182, 182);
            border-radius: 5px;
            font-weight: bold;
        }

            .bodyContent {
                display: flex;
                flex-direction: column;
                height: 100%;
                width: 60%;
                margin: auto; 
                border: 2px solid black;
            }


         .heading {
            flex:0.5;
            display: flex;
            flex-direction: row;
            
        }
        .content {
            flex : 5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: aqua;
           
        }

        
        .content button {
            width: 30%;
            height: 10%;
            margin: 10px auto;
            text-align: center;
            font-weight: bold;
            border: none;
            box-shadow: none;
            border: 1px solid black;
        }

        .workstationInfo , .head , .logout{
            flex:1;
           
        }

        .workstationInfo p {
            font-weight: bold;
            margin: 0;
            text-align: left;
            margin: 2% auto 0 5%;
        
        }

        .logout {
            display: flex;
            flex-direction: column;
            align-items: center;
        }


        .logout button {
            width: 50%;
            height: 50%;
            margin: 10px auto;
            text-align: center;
            font-weight: bold;
            border: none;
            box-shadow: none;
            border: 1px solid black;
        }
        

        .content span {
            display: flex;
            flex-direction: row;
            margin: 10px;
        }

        td {
            text-align: right;
        }


        .opeTask {
            display: flex;
            flex-direction: row;
            
        }

        #message {
			color: red;
			display: inline-block;
		}
    </style>
</head>
<body>

    <div class="bodyContent">

        <div class="heading">

            <div class="workstationInfo">

                <p>User ID : <?php echo $user; ?> </p>
                <p id="currentDate"></p>

            </div>
            <div class="head">
                 
                <p style="text-align: center; font-weight: bold; font-size: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">GovTrack</p>
            </div>
            <div class="logout">
                <button onclick="location.href='logout.php'"> LOGOUT </button>
            </div>            
        </div>

        <div class="content">
                                
                 <h2>Customer details of following reference has been successfully updated.</h2>  

                    <h2>REFERENCE NO : <span id="message"> <?php echo $cusUID ?> </span> </h2>
                    <button onclick="location.href='dashboard_frontoffice.php'"> BACK TO HOME </button>

                     <!-- below function was removed from the project
                    <h3 style="margin-bottom: -100px;color: red;">Customer will be notified this via SMS</h3> -->
                    
        </div>
    </div>

    <script>
     var currentDate = new Date();
        var options = { year: 'numeric', month: 'short', day: 'numeric' };
        var dateElement = document.getElementById("currentDate");
        dateElement.textContent = "Date: " + currentDate.toLocaleDateString('en-US', options);
    </script>
    
</body>
</html>