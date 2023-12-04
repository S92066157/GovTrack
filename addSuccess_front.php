<?php

include 'connect.php';

session_start();

$usertype = $_SESSION['usertype'];
$user = $_SESSION['user_name'];


if (!isset($usertype)) {
    header('location:index.php');
} elseif ($usertype == "backoffice") {
    header('location:task_backoffice.php');
}


?>

<?php


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $taskID = $_POST["taskID"];
    $user = $_SESSION['user_name'];
    $date = date('Y-m-d');
    $nic = $_POST["nic"];
    $uniqueID = $taskID . "-" . $nic . "-" . $date;

    // Insert data into the database.   

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO `user_registration` ( uniqueID, name, NIC, email, contact, address, taskID, empUsername, dateAdded) VALUES (?,?,?,?,?,?,?,?,?)";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $uniqueID, $name, $nic, $email, $contact, $address, $taskID, $user, $date);

    if ($stmt->execute()) {
        // Registration successful.
        $message[] = 'Customer details have been successfully added.';
    } else {
        // Registration failed.

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
    <title>Adding Success</title>

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
            flex: 0.5;
            display: flex;
            flex-direction: row;

        }

        .content {
            flex: 5;
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

        .workstationInfo,
        .head,
        .logout {
            flex: 1;

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
                <p>User ID :
                    <?php echo $user; ?>
                </p>
                <p id="currentDate"></p>

            </div>
            <div class="head">

                <p
                    style="text-align: center; font-weight: bold; font-size: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">
                    GovTrack</p>
            </div>
            <div class="logout">
                <button onclick="location.href='logout.php'">
                    LOGOUT
                </button>
            </div>
        </div>

        <div class="content">

            <h2>
                <?php
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '
                    <div class="message">
                        <span>' . $message . '</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>
                    ';
                    }
                }
                ?>
            </h2>

            <h2>REFERENCE NO : <span id="message">
                    <?php echo $uniqueID ?>
                </span></h2>

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