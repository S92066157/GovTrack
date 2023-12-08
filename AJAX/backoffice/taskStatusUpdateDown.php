<?php

include ('../../connect.php');

session_start();
$taskID = null;
$TaskCompleted = 1;
$countSubTask = 0;
$currentSubTask = 0;
$taskStatus = 1;
$mainTaskStatus = "";


    $Uid = $_SESSION['customerUID'];
    $taskID = $_SESSION['customerTaskID'];

    $date = date('Y-m-d');

    $sql = "select currentsubTask, subtaskCount, taskStatus from customer_registration
    where uniqueID = '$Uid';";


    $result= mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            $countSubTask = $row["subtaskCount"];
            $currentSubTask = $row["currentsubTask"];
            $mainTaskStatus = $row["taskStatus"];
        }
    }

    if($mainTaskStatus == "0") {
        
        $response = array(
            'message' => "HOLD Task - Cannot Update Status",
            'data' => $currentSubTask );
            header('Content-Type: application/json');
            echo json_encode($response);
    } 

    else {

    if($currentSubTask == 2) {


        $response = array(
            'message' => "There is no any step to Undo",
            'data' => $currentSubTask );

            header('Content-Type: application/json');
            echo json_encode($response);
    }

    else if ($currentSubTask == "Done"){
        $response = array(
            'message' => "There is no way to send this task back since it was already completed",
            'data' => "Done" );

            header('Content-Type: application/json');
            echo json_encode($response);
    }

    else {

        $currentSubTask -=1;

        $sql3 = "DELETE from usertasks where uniqueID = ? and subTaskID = ?;";
        $stmt2 = $conn->prepare($sql3);
        $stmt2->bind_param("si", $Uid, $currentSubTask );
        
        $_SESSION['currentSubTask'] = $currentSubTask;

        $sql2 = "UPDATE customer_registration SET currentsubTask = ? WHERE uniqueID = ?";
        $stmt1 = $conn->prepare($sql2);
        $stmt1->bind_param("is", $currentSubTask , $Uid);
        
    
        if ($stmt1->execute() && $stmt2->execute() ) {

            $response = array(
            'message' => "Task marked as incomplete successfully.",
            'data' => $currentSubTask );
            header('Content-Type: application/json');
            echo json_encode($response);
            
        } else {

            $response = array(
                'message' => "Error",
                'data' => $currentSubTask );
                header('Content-Type: application/json');
                echo json_encode($response);            
        }
    
        $stmt1->close();
        $stmt2->close();
        $conn->close();
    }
    }
?>