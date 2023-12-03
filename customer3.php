<?php

include 'connect.php';

session_start();

$uID = $_SESSION['uniqueID'];
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
$sql1 = 'SELECT taskdescription, subtaskdescription, taskdate 
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
$sql2 = "SELECT errorName , dateAdded , remark from taskerrors
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
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            margin: auto;
            width: 80%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgb(222, 218, 255);
            font-weight: bolder;
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

        .cusDetails {
            margin: 0;
            padding: 0;
        }

        .cusDetails h3 {
            margin: 10px;
        }


        .table2 {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .buttons {
            margin: 5px auto;
        }

        /* div {
            border: 1px solid black;
        } */

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

        .marginLeft {
            margin-left: 3%;
        }

        #feedback {
            display: none;
        }

        #buttonSet2 {
            display: none;
        }

        #buttonSet1 {
            display: flex;
        }

        .progressTask {
            display: none;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 heading">
                <p>GovTrack</p>
            </div>
        </div>

        <div class="row" style="background-color: rgb(255, 255, 255); border: 3px solid black;">
            <div class="col-sm-12 col-md-12 col-lg-12">


                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 cusDetails">
                        <h3> Welcome,
                            <?php echo $cusName; ?>
                        </h3>
                        <h3> Reference No :
                            <?php echo $uID; ?>
                        </h3>
                        <hr>
                    </div>
                </div>

                <div class="row" id="progressTask">
                    <div class="col-sm-12 col-md-12 col-lg-5">

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

                                echo ' <tr><th class="text-center col-3">Sub Task</th><th class="text-center col-3" >Date Completed</th></tr>';

                                while ($row = $result1->fetch_assoc()) {
                                    echo "<tr>";
                                    echo '<td>' . $row["subtaskdescription"] . "</td>";
                                    echo '<td class="text-center">' . $row["taskdate"] . "</td>";
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
                    <div class="col-sm-12 col-md-12 col-lg-7 secondTable">


                        <div class="row">
                            <h3 class="text-center p-3">Error Details </h3>
                        </div>

                        <div class="table2 p-3" style="display: flex; flex-direction: row;">
                            <br>

                            <?php
                        if ($result2->num_rows > 0) {

                            echo '<table border="0" class="table table-striped" style="margin: auto;"> <tr><th class="text-center">Error Name</th> <th class="text-center" >Date Added</th><th class="text-center" >Remark</th></tr>';

                            while ($row = $result2->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["errorName"] . "</td>";
                                echo '<td class="text-sm-left text-lg-center">' . $row["dateAdded"] . "</td>";
                                echo '<td class="text-sm-left text-lg-center">' . $row["remark"] . "</td>";

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

                <div class="row" id="feedback">
                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                        <h3>Customer Feedback</h3>

                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-8 mb-2 text-bolder marginLeft">
                                <select class="form-select"
                                            id="feedbackList" name="feedbackList">
                                            <option selected>Select Feedback (1 to 5)</option>
                                            <option value="1">Not Satisfied</option>
                                            <option value="2">Dissatisfied</option>
                                            <option value="3">Neutral</option>
                                            <option value="4">Satisfied</option>
                                            <option value="5">Very Satisfied</option>
                                        </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10  col-md-10 col-lg-8 marginLeft">
                                <textarea name="feedbackText" id="feedbackText" rows="10"
                                class="form-control"
                                placeholder="Enter your feedback here"></textarea>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="row">
                    <hr>
                    <div class="col-sm-12 col-md-12 col-lg-12 mb-1" id="buttonSet1">
                        <button type="button" onclick="checkTaskStatuFeedback()" id="buttonSet1"
                            class="mx-auto btn btn-primary buttons"> Provide Feedback </button>
                        <button type="button" class="mx-auto btn btn-primary buttons"
                            onclick="location.href='customer.php'">
                            Back to Home</button>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12 mb-3" id="buttonSet2">
                        <button type="button" onclick="postFeedback()"
                            class="mx-auto my-auto btn btn-primary buttons">Submit Feedback</button>
                        <button type="button" onclick="back()"
                            class="mx-auto my-auto btn btn-primary buttons">Back</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="javascripts.js"></script>

</body>

</html>