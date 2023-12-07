<?php

include('../../connect.php');

session_start();

$uID = $_SESSION['customerUID'];
$user = $_SESSION['user_name'];

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['error1']) && isset($_POST['error2']) && isset($_POST['error3']) && isset($_POST['error1Remark']) && isset($_POST['error2Remark']) && isset($_POST['error3Remark'])) {

    $textError1 = $_POST['error1'];
    $textError2 = $_POST['error2'];
    $textError3 = $_POST['error3'];
    $Error1 = 1;
    $Error2 = 2;
    $Error3 = 3;
    $error1Remark = $_POST['error1Remark'];
    $error2Remark = $_POST['error2Remark'];
    $error3Remark = $_POST['error3Remark'];
    $date = date('Y-m-d');


    $sqlcurrentStage = "SELECT currentSubTask FROM user_registration
    WHERE uniqueID = '$uID';";

    $resultCurrentStage = mysqli_query($conn, $sqlcurrentStage);

    if (mysqli_num_rows($resultCurrentStage) > 0) {
        while ($row = mysqli_fetch_assoc($resultCurrentStage)) {
            $currentStage = $row['currentSubTask'];
        }
    }

    if ($currentStage == "Done") {
        echo "Errors cannot be added since this task is already Completed";
    } else {


        if ($textError1 == 1 || $textError2 == 1 || $textError3 == 1) {

            $sql0 = "UPDATE user_registration SET taskStatus = 0 WHERE uniqueID = '$uID';";

            $stmt0 = $conn->prepare($sql0);

            if ($stmt0->execute()) {
                echo "Task Status Updated - HOLD.\n";
            } else {
                echo "Task Status Update Unsuccessful " . $stmt0->error . "\n";
            }

        } else if ($textError1 == 0 && $textError2 == 0 && $textError3 == 0) {
            $sql6 = "UPDATE user_registration SET taskStatus = 1 WHERE uniqueID = '$uID';";

            $stmt6 = $conn->prepare($sql6);

            if ($stmt6->execute()) {
                echo "Task Status Updated - UNHOLD.\n";
            } else {
                echo "Task Status Update Unsuccessful " . $stmt6->error . "\n";
            }
        }


        if ($textError1 == 1) {

            $sqlExisting1 = "SELECT * FROM taskerrors WHERE uniqueID = '$uID' AND errorID  = '$Error1';";


            $resultExisting1 = mysqli_query($conn, $sqlExisting1);

            if (mysqli_num_rows($resultExisting1) > 0) {
                echo "Error in document already submitted.\n";
            } else {

                //added date manually due to online database
                $sql = "INSERT INTO taskerrors(uniqueID, errorID, isErrorOccured, submittedBy, remark , dateAdded) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssisss", $uID, $Error1, $textError1, $user, $error1Remark, $date);

                if ($stmt->execute()) {
                    echo "Error in document submitted.\n";
                } else {
                    echo "Operation Unsuccessful " . $stmt->error . "\n";
                }
            }
        } else {

            $sql3 = "DELETE FROM taskerrors WHERE uniqueID = ? AND errorID = ?;";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param("si", $uID, $Error1);

            if ($stmt3->execute()) {
                echo "Removed - Error in document.\n";
            } else {
                echo "Operation Unsuccessful " . $stmt3->error . "\n";
            }

        }

        if ($textError2 == 1) {

            $sqlExisting2 = "SELECT * FROM taskerrors WHERE uniqueID = '$uID' AND errorID  = '$Error2';";


            $resultExisting2 = mysqli_query($conn, $sqlExisting2);

            if (mysqli_num_rows($resultExisting2) > 0) {
                echo "Missing document error already submitted.\n";
            } else {

                //added date manually due to online database
                $sql1 = "INSERT INTO taskerrors(uniqueID, errorID, isErrorOccured , submittedBy, remark, dateAdded) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param("ssisss", $uID, $Error2, $textError2, $user, $error2Remark, $date);

                if ($stmt1->execute()) {
                    echo "Missing document error submitted\n";
                } else {
                    echo "Operation Unsuccessful " . $stmt1->error . "\n";
                }
            }

        } else {
            $sql4 = "DELETE FROM taskerrors WHERE uniqueID = ? AND errorID = ?;";
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bind_param("si", $uID, $Error2);

            if ($stmt4->execute()) {
                echo "Removed - Missing document.\n";
            } else {
                echo "Operation Unsuccessful " . $stmt4->error . "\n";
            }
        }

        if ($textError3 == 1) {

            $sqlExisting3 = "SELECT * FROM taskerrors WHERE uniqueID = '$uID' AND errorID  = '$Error3';";


            $resultExisting3 = mysqli_query($conn, $sqlExisting3);

            if (mysqli_num_rows($resultExisting3) > 0) {
                echo "Other error already submitted.\n";
            } else {

                //added date manually due to online database
                $sql2 = "INSERT INTO taskerrors(uniqueID, errorID, isErrorOccured, submittedBy, remark, dateAdded) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param("ssiss", $uID, $Error3, $textError3, $user, $error3Remark, $date);

                if ($stmt2->execute()) {
                    echo "Other Error Submitted\n";
                } else {
                    echo "Operation Unsuccessful " . $stmt2->error . "\n";
                }

            }
        } else {
            $sql5 = "DELETE FROM taskerrors WHERE uniqueID = ? AND errorID = ?;";
            $stmt5 = $conn->prepare($sql5);
            $stmt5->bind_param("si", $uID, $Error3);

            if ($stmt5->execute()) {
                echo "Removed - Other Error.\n";
            } else {
                echo "Operation Unsuccessful " . $stmt5->error . "\n";
            }
        }

    }

} else {
    echo "Error";
}

$conn->close();
?>