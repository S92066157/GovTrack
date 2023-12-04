<?php
include 'connect.php';
session_start();

$id = "";
            $name = "";
            $email = "";
            $contact = "";
            $address = "";
            $nic = "";
            $user = $_SESSION['user_name'];

if (!$conn) {
    die("Connection Unsuccessful - " . mysqli_connect_error());
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $sql = "SELECT uniqueID, name, email, contact, nic, address FROM user_registration WHERE uniqueID = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
			$id = $row["uniqueID"];
            $name = $row["name"];
            $email = $row["email"];
            $contact = $row["contact"];
            $address = $row["address"];
            $nic = $row["nic"];
			
			
			$_SESSION['cusUniqueID'] = $row['uniqueID'];
			
			
        }
    } else {
		echo '<script>alert("No results")</script>'; 

    }
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer - Frontoffice</title>

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
        .buttonSet1 {
            display: flex;
            flex-direction: row; }

            .buttonSet1 button{
            width: 60px;
            height: 100%;
            margin:  0px 5px;
            }
            .content .inputs table {
                margin: auto;
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
                <button onclick="location.href='logout.php'" >LOGOUT</button>
            </div>
            
            
                </div>
                <div class="content">
            
                    <div class="inputs">
                        <form action="" method="post">
                        
                            <br> 
                        <table>
                            <tr style="margin: 0;"> 
                                <td>Reference NO : </td>
                                <td style="display:flex; flex-direction: row; margin: none;">
                                    <input type="text" id="id" name="id" style="width: 60%; margin: 0;" required>
                                    <div class="buttonSet1"> 
                                    <button type="submit">Search</button>
                                    <button type="button" onclick="clearForm()">Clear</button>
                                    </div>
                                    </form>
                                </td>
                            </tr>
                        </table>


                        <fieldset>
                            <legend>Customer's Details (Read-only) </legend>
                        <table>
                            <br>
                            <tr>
                                <td>Customer Name: </td>
                                <td><input type="text" id="name" value="<?php echo $name; ?>"  readonly ></td>
                            </tr>
                            <tr>
                                <td>Customer NIC: </td>
                                <td><input type="text" id="nic" value="<?php echo $nic; ?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Contact No: </td>
                                <td><input type="text" id="contact" value="<?php echo $contact; ?>" readonly></td>
                            </tr>  
                            
                            <tr>
                                <td>Email: </td>
                                <td><input type="email" id="email" value="<?php echo $email; ?>" readonly></td>
                            </tr> 
                            <tr>
                                <td>Address: </td>
                                <td><input type="text" id="address" value="<?php echo $address; ?>" readonly></td>
                            </tr>          
                                                  
                        </table>

                        <br>
                    </fieldset>



                <form action="updateSuccess_front.php" method="post">
                    <br>
                    <fieldset>
                        <legend>Update Customer's Details</legend>
                    <table>
                        <br>
                        <tr>
                            <td>New Contact NO: </td>
                            <td><input type="text" id="cusContactNew" name="cusContactNew" value="<?php echo $contact; ?>"></td>
                        </tr>
                        <tr>
                            <td>New Address: </td>
                            <td><input type="text" id="cusAddressNew"  name="cusAddressNew"  value="<?php echo $address; ?>"></td>
                        </tr> 
                        <tr>
                            <td>New Email: </td>
                            <td><input type="email" id="cusEmailNew"  name="cusEmailNew" value="<?php echo $email; ?>"></td>
                        </tr>                     
                    </table>
                    <br>
                    
                </fieldset>
                            <br>
                        <fieldset class="opeTask">
                            <legend>User's Task</legend>
                            <button type="button" onclick="discard()" >Discard</button>
                            <button type="submit" onclick="confirmButtonClick(event)" >Update</button>
                        </fieldset>
                    </div>
                    </form>
                </div>
    </div>
    
    <script>

function clearForm() {
    document.getElementById("id").value = "";
    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("nic").value = "";
    document.getElementById("contact").value = "";
    document.getElementById("address").value = "";
    document.getElementById("cusContactNew").value = "";
    document.getElementById("cusAddressNew").value = "";
    document.getElementById("cusEmailNew").value = "";
}

function discard() {
    let text = "Are you sure you want to discard? \n This will direct you to Dashboard";
    if (confirm(text)) {
        clearForm();
        window.location.href = 'dashboard_frontoffice.php';
        return false;
    } else {
        return false;
    }
}

function validatePhoneNumber(phoneNumber) {
    const phoneRegex = /^0\d{9}$/;
    return phoneRegex.test(phoneNumber);
}

function validateEmail(email) {
    const EmailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return EmailRegex.test(email);
}

function confirmButtonClick(event) {
    var result = confirm("This will update customer data in the task.\nAre you sure to do this action?");
    if (!result) {
        event.preventDefault();
    }
}

function confirmButtonClick(event) {
    var result = confirm("This will save the data and create a new task and cannot be undone.\nAre you sure you want to proceed?");
    if (!result) {
        event.preventDefault();
    } else {
        const email = document.getElementById("cusEmailNew").value;
        const phoneNumber = document.getElementById("cusContactNew").value;
        const address = document.getElementById("cusAddressNew").value;

        // Check if any of the fields is empty
        if (email.trim() === '' || phoneNumber.trim() === '' || address.trim() === '') {
            alert("Please fill in all the required fields!");
            event.preventDefault();
        } else {
            // Validate phone number and email
            if (!validatePhoneNumber(phoneNumber)) {
                alert("Please enter a valid 10-digit phone number");
                event.preventDefault();
            } 
            if (!validateEmail(email)) {
                alert("Please enter a valid Email");
                event.preventDefault();
            }
        }
    }
}

var currentDate = new Date();
var options = { year: 'numeric', month: 'short', day: 'numeric' };
var dateElement = document.getElementById("currentDate");
dateElement.textContent = "Date: " + currentDate.toLocaleDateString('en-US', options);


    </script>


</body>
</html>
