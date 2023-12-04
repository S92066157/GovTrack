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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Frontoffice</title>

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
            margin: 0px 0px 0px 20px;

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
                <button onclick="location.href='logout.php'">LOGOUT</button>

            </div>


        </div>
        <div class="content">

            <form action="addSuccess_front.php" method="post" id="cusDetails">

                <div class="inputs">
                    <fieldset>

                        <legend>Customer's Details</legend>
                        <br> <br>
                        <table>

                            <tr>
                                <td>Customer Name: </td>
                                <td><input type="text" id="name" name="name" required></td>
                            </tr>
                            <tr>
                                <td>Customer Email: </td>
                                <td><input type="email" id="email" name="email" required></td>
                            </tr>
                            <tr>
                                <td>Customer NIC: </td>
                                <td><input type="text" id="nic" name="nic" required></td>
                            </tr>
                            <tr>
                                <td>Contact No: </td>
                                <td><input type="text" id="contact" name="contact" required></td>
                            </tr>
                            <tr>
                                <td>Address: </td>
                                <td><input type="text" id="address" name="address" required></td>
                            </tr>
                            <td>
                                Requirement:
                            </td>
                            <td>
                                <select name="taskID" id="taskID" style="width: 100%;" required>
                                </select>
                            </td>



                        </table>

                        <br> <br>

                    </fieldset>


                    <br>
                    <fieldset class="opeTask">
                        <legend>User's Task</legend>
                        <button onclick="discard()">Discard</button>
                        <button type="submit" onclick="confirmButtonClick(event)">Save</button>
                    </fieldset>

            </form>
        </div>

    </div>
    </div>


    <script>
        function discard() {
            let text = "Are you sure you want to discard?\nThis will direct you to Dashboard";
            if (confirm(text)) {
                resetFormFields();
                window.location.href = 'dashboard_frontoffice.php';
                return false;
            } else {
                return false;
            }
        }

        function resetFormFields() {
            document.getElementById("name").value = "";
            document.getElementById("email").value = "";
            document.getElementById("nic").value = "";
            document.getElementById("contact").value = "";
            document.getElementById("address").value = "";
            document.getElementById("taskID").value = "1";
        }

        function validatePhoneNumber(phoneNumber) {
            // Regular expression to match 10 digits
            const phoneRegex = /^0\d{9}$/;
            return phoneRegex.test(phoneNumber);
        }

        function validateNIC(NIC) {
            // Regular expression
            const NICRegex = /^(\d{9}[vV]|\d{10})$/;
            return NICRegex.test(NIC);
        }

        function validateEmail(email) {
            // Regular expression
            const EmailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return EmailRegex.test(email);
        }

function confirmButtonClick(event) {
    var result = confirm("This will save the data and create a new task and cannot be undone.\nAre you sure you want to proceed?");
    
    if (!result) {
        event.preventDefault();
    } else {
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const NIC = document.getElementById("nic").value;
        const phoneNumber = document.getElementById("contact").value;
        const address = document.getElementById("address").value;

        // Check if any of the fields is empty
        if (name.trim() === '' || email.trim() === '' || NIC.trim() === '' || phoneNumber.trim() === '' || address.trim() === '') {
            alert("Please fill in all the required fields!");
            event.preventDefault();
        } else {
            // Validate phone number, NIC, and email
            if (!validatePhoneNumber(phoneNumber)) {
                alert("Please enter a valid 10-digit phone number");
                event.preventDefault();
            } 
            if (!validateNIC(NIC)) {
                alert("Please enter a valid NIC number");
                event.preventDefault();
            } 
            if (!validateEmail(email)) {
                alert("Please enter a valid Email");
                event.preventDefault();
            }
        }
    }
}



        fetch('AJAX/frontoffice/getTaskFront.php')
            .then(response => response.json())
            .then(data => {
                var select = document.getElementById('taskID');

                // Loop through the data and create option elements
                data.forEach(item => {
                    var option = document.createElement('option');
                    option.value = item.taskid;
                    option.textContent = item.taskdescription;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching data:', error));


        var currentDate = new Date();
        var options = { year: 'numeric', month: 'short', day: 'numeric' };
        var dateElement = document.getElementById("currentDate");
        dateElement.textContent = "Date: " + currentDate.toLocaleDateString('en-US', options);



    </script>





</body>

</html>
