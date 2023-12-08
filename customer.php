
<?php

include 'connect.php';

session_start();

if(isset($_POST['submit'])){

   $uniqueID = $_POST['uniqueID'];
   
   $result = mysqli_query($conn, "SELECT * FROM `customer_registration` WHERE uniqueID = '$uniqueID' ") or die('query failed');

   if(mysqli_num_rows($result) > 0){

    header('location:customer2.php');

    $_SESSION['uniqueID'] = $uniqueID;
    
   }else{
      $message[] = 'Incorrect Unique ID';
   }}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer END - Home</title>

    <style>
        body{
            height: 90vh;
            width: 90vw;
            background-color: lightblue;
            margin: auto;
        }


        body button {
            cursor: pointer;
        }

            .bodyContent {
                display: flex;
                flex-direction: column;
                height: 90vh;
                width: 90vw;
                margin: auto; 
            }


         .heading {
            flex:2;
            
            
        }
        .content {
            flex : 3;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            
        }

        form input {
            width: 20%;
            height: 10%;
            margin: 10px auto;
            text-align: center;

        }
        button  {
            width: 20%;
            height: 10%;
            margin: 10px auto;
            text-align: center;
            font-weight: bold;
            background-color: grey;
            border: none;
            box-shadow: none;
            border: 1px solid black;
        }
        
        h4 {
            text-align: center;
            margin: 5px;
        }

    </style>
</head> 
<body>

    <div class="bodyContent">

        <div class="heading">
            <p style="text-align: center; font-weight: bold; font-size: 80px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">GovTrack</p>
            
                <form action="" method="post">
                <div class="content">
				
                
            
            <input type="text" id="uniqueID" name="uniqueID" placeholder="Reference Number" required>
            
            <button type="submit" name="submit"  class="btn">Submit</button>

            <button type="button" onclick="location.href='customerfrogotref.php'" class="btn"> Forget Reference</button>


            </div>
            </form>

            <h4 style="text-align:center;">  <?php
                if(isset($message)){
                foreach($message as $message){
                    echo '
                    <div class="message">
                        <span>'.$message.'</span>
                    </div>
                    ';
                }
            }
            ?> 
            </h4>

            
        </div>
                    <h4> Enter Reference number of your task and click on Submit button </h4>
                        <h4> Click on Frogot reference if you lost your reference number </h4>
			
    </div>
</body>
</html>