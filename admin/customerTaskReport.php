<?php

include ('../connect.php');

session_start();

$uID = $_SESSION['uniqueIDCustomer'];
$taskName = "";
$cusName = "";


if (!$conn) {
    die("Connection Unsuccessful - " . mysqli_error());
}



$sql = 'select taskdescription , name from tasks
        inner join user_registration on user_registration.taskid = tasks.taskid
        where uniqueID = ?';


$stmt = mysqli_prepare($conn, $sql);

// Bind parameters
mysqli_stmt_bind_param($stmt, 's', $uID);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get result set
$result = mysqli_stmt_get_result($stmt);


// Close the statement
mysqli_stmt_close($stmt);


if ($result->num_rows == 1) {
    while ($row = $result->fetch_assoc()) {

        $taskName = $row["taskdescription"];
        $cusName = $row["name"];

    }
} else {
    $taskName = "ERROR";
}

// Use prepared statement to avoid SQL injection
$sql1 = 'SELECT taskdescription, subtaskdescription, taskdate  , ut.empUsername as empName
                FROM user_registration ur
                CROSS JOIN subtasks st  
                LEFT JOIN usertasks ut 
                    ON ur.uniqueID = ut.uniqueID AND st.subtaskid = ut.subtaskid
                INNER JOIN tasks 
                    ON tasks.taskid = ur.taskid
                WHERE ur.uniqueID = ? AND st.maintaskid = ur.taskid';

// Create a prepared statement
$stmt1 = mysqli_prepare($conn, $sql1);

// Bind parameters
mysqli_stmt_bind_param($stmt1, 's', $uID);

// Execute the statement
mysqli_stmt_execute($stmt1);

// Get result set
$result1 = mysqli_stmt_get_result($stmt1);


// Close the statement
mysqli_stmt_close($stmt1);


// Use prepared statement to avoid SQL injection
$sql2 = "SELECT errorName , dateAdded , remark , submittedBy from taskerrors
        INNER JOIN ERRORS ON taskerrors.errorID = errors.id
        WHERE uniqueID = ? ;";

// Create a prepared statement
$stmt2 = mysqli_prepare($conn, $sql2);

// Bind parameters
mysqli_stmt_bind_param($stmt2, 's', $uID);

// Execute the statement
mysqli_stmt_execute($stmt2);

// Get result set
$result2 = mysqli_stmt_get_result($stmt2);


// Close the statement
mysqli_stmt_close($stmt2);

mysqli_close($conn);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background: radial-gradient(#009ac2, #001F27);
            mix-blend-mode: multiply;
            z-index: -100;
        }

        a {
            text-decoration: none;
            color: black;
            margin: none;
        }

        .firstrow input {
            margin-right: 1%;
        }

        h3 {
            font-size: 16px;
            font-weight: bold;
        }

        .heading p {
            text-align: center;
            margin: 0px;
            padding: 0px;
            font-weight: bold;
            font-size: 60px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .cusDetails h3 {
            margin: 5px;
        }


        .table2 {
            display: flex;
            align-items: center;
            justify-content: center;
        }


        fieldset {

            margin: auto 5%;
        }

        .table2 table {
            padding: 20px;
            background-color: rgb(230, 243, 249);
            justify-content: center;
            align-items: center;
        }

        /* div {
            border: 2px solid black;
        } */

        .secondTable {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand">GOVTrack</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="admindashboard.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Users
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="adduser.php">Add New User</a></li>
                            <li><a class="dropdown-item" href="edituser.php">Edit Existing User</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tasks.php">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="reports.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="status.php">System Status</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="background-container">
        <div class="overlay"></div>
    </div>

    <div class="container-fluid">

    <div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 my-2">
                <h2 class="text-white text-center ">Customer task status</h2>
            </div>
        </div>

       
        <div style="background-color: white; border: 3px solid black;">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 cusDetails">
                    <h3> Customer Name :
                        <?php echo $cusName; ?>
                    </h3>
                    <h3> Reference No :
                        <?php echo $uID; ?>
                    </h3>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">

                    <div class="row">
                        <h3 class="text-center">Progress of task</h3>
                    </div>


                    <fieldset>
                        <legend>
                            <h3>Task :
                                <?php echo $taskName; ?>
                            </h3>
                        </legend>

                        <!-- <table border="0" class="table table-bordered"> -->
                        <table border="0" class="table table-striped">

                            <?php
                            if ($result1->num_rows > 0) {

                                echo ' <tr><th class="text-center col-3">Sub Task</th><th class="text-center col-3" >Date Completed</th><th class="text-center col-3" >EMP Username</th></tr>';

                                while ($row = $result1->fetch_assoc()) {
                                    echo "<tr>";
                                    echo '<td>' . $row["subtaskdescription"] . "</td>";
                                    echo '<td class="text-center">' . $row["taskdate"] . "</td>";
                                    echo '<td class="text-center">' . $row["empName"] . "</td>";
                                    // Add more td tags for additional columns
                                    echo "</tr>";

                                }
                            } else {
                                echo "<tr>  <td colspan='2'>No data found</td></tr>";
                            }
                            ?>
                        </table>
                    </fieldset>

                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 secondTable">


                    <div class="row">
                        <h3 class="text-center p-3">Error Details </h3>
                    </div>

                    <div class="table2 p-3" style="display: flex; flex-direction: row;">
                        <br>




                        <?php
                        if ($result2->num_rows > 0) {

                            echo '<table border="0" class="table table-striped" style="margin: auto;"> <tr><th class="text-center">Error Name</th> <th class="text-center" >Date Added</th><th class="text-center" >Remark</th><th class="text-center" >EMP Username</th></tr>';

                            while ($row = $result2->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["errorName"] . "</td>";
                                echo '<td class="text-sm-left text-lg-center">' . $row["dateAdded"] . "</td>";
                                echo '<td class="text-sm-left text-lg-center">' . $row["remark"] . "</td>";
                                echo '<td class="text-sm-left text-lg-center">' . $row["submittedBy"] . "</td>";
                                echo "</tr>";
                            }
                            echo '</table>';

                        } else {
                            echo 'Currently there is no any error';
                        }
                        ?>

                    </div>

                   
            </div>
        </div>
        </div>
        <div class="text-center">
      <button class="btn btn-primary mt-2" onclick="location.href='customerTask.php'" >BACK</button>
    </div>
    </div>
    
</body>

</html>