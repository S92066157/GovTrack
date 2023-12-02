<?php

include ('../../connect.php');

session_start();
$taskID = null;
$TaskCompleted = 1;
$countSubTask = 0;
$currentSubTask = 0;
$nextSubTask = 0;
$mainTaskStatus = "";


    $Uid = $_SESSION['customerUID'];
    $taskID = $_SESSION['customerTaskID'];
    $user = $_SESSION['user_name'];

    $date = date('Y-m-d');

    $sql = "select currentsubTask, subtaskCount, taskStatus from user_registration
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

    if($currentSubTask == $countSubTask) {

        $nextSubTask = "Done";

        $sql2 = "UPDATE user_registration SET currentsubTask = ? WHERE uniqueID = ?";
        $stmt3 = $conn->prepare($sql2);
        $stmt3->bind_param("ss", $nextSubTask , $Uid);



        $sql4 = "INSERT INTO usertasks (uniqueID, taskID, subtaskID, taskDate, empusername) VALUES (?,?,?,?,?)";
        $stmt4 = $conn->prepare($sql4);
        $stmt4->bind_param("siiss", $Uid, $taskID, $currentSubTask , $date , $user);

        if( $stmt3->execute() && $stmt4->execute() ) {
            $response = array(
                'message' => "All Stages are Completed",
                'data' => "Done" );
    
                header('Content-Type: application/json');
                echo json_encode($response);
        }
            $stmt3->close();
            $stmt4->close();
    }

    else if ($currentSubTask == "Done"){
        $response = array(
            'message' => "All Stages are Completed",
            'data' => "Done" );

            header('Content-Type: application/json');
            echo json_encode($response);
    }


    else {

        $sql3 = "INSERT INTO usertasks (uniqueID, taskID, subtaskID, taskDate, empusername) VALUES (?,?,?,?,?)";
        $stmt2 = $conn->prepare($sql3);
        $stmt2->bind_param("siiss", $Uid, $taskID, $currentSubTask , $date , $user);

        $nextSubTask = $currentSubTask + 1;
        
        
        $sql2 = "UPDATE user_registration SET currentsubTask = ? WHERE uniqueID = ?";
        $stmt1 = $conn->prepare($sql2);
        $stmt1->bind_param("is", $nextSubTask , $Uid);

    
        if ($stmt1->execute() && $stmt2->execute() ) {

            $response = array(
            'message' => "Task marked as complete successfully.",
            'data' => $nextSubTask );
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