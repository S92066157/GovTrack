<?php

include 'connect.php';

session_start();

$uID = $_SESSION['uniqueID'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <style>
        body {
            height: 90vh;
            width: 90vw;
            background-color: rgb(222, 217, 255);
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
            flex: 2;


        }

        .content {
            flex: 3;
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
            font-size: 16px;
            font-weight: bold;
            padding: 5px;
        }

        button {
            width: 20%;
            height: 10%;
            margin: 10px auto;
            text-align: center;
            font-weight: bold;
            background-color: grey;
            border: none;
            box-shadow: none;
            border: 1px solid black;
            font-size: 16px;
            font-weight: bold;
            padding: 5px;
        }

        h3 {
            text-align: center;
            margin: 5px;
        }

        button:hover {
            background-color: lightgray;
        }
    </style>
</head>

<body>

    <div class="bodyContent">

        <div class="heading">
            <p
                style="text-align: center; font-weight: bold; font-size: 80px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">
                GovTrack</p>

            <form action="#" method="post">
                <div class="content">

                    <input type="text" id="contactNo" name="contactNo" placeholder="Contact Number" required>

                    <h3>Entered Reference NO :
                        <?php echo $uID; ?>
                    </h3>

                    <button type="button" onclick="inputValidation()" class="btn"> SUBMIT </button>

                    <h3> Enter Contact number and SUBMIT </h3>

                    <button type="submit" onclick="location.href='customer.php'" class="btn"> Back to Home</button>

                </div>
            </form>
        </div>
    </div>


    <script>
        function inputValidation() {

            var contactNumber = document.getElementById('contactNo').value;

            if (contactNumber == "") {

                alert("Contact Number connot be empty.\nPlease try again !");
            }
            else {

                checkContactDetails();
            }
        }
    </script>

    <script src="JS/javascriptsCustomer.js"></script>
</body>

</html>