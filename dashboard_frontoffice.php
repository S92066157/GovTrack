<?php

include 'connect.php';

session_start();

$usertype = $_SESSION['usertype'];
$user = $_SESSION['user_name'];

if(!isset($usertype)){
   header('location:index.php');
}
elseif ($usertype == "backoffice") {
	header('location:task_backoffice.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Frontoffice</title>

    <style>
        body{
            height: 600px;
            width: 1350px;

        }

        body button {
            background-color: rgb(236, 182, 182);
            cursor: pointer;
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
                <button  onclick="location.href='logout.php'">LOGOUT </button>
            </div>
                </div>
                <div class="content">
            
                    
                    <button id="addCustomer" onclick="window.location.href='addcustomer_front.php';">Add New Customer</button>
                    <button id="updateCustomer" onclick="window.location.href='updatecustomer_front.php';">Update Existing Customer</button>
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