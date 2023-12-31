<?php

include ('../../connect.php');

session_start();


// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else {

    if(isset($_POST['date'])) {
        $date = $_POST['date'];

        $data = array();

        $sql = "SELECT name, ut.uniqueid as uID, taskdescription, subtaskdescription, ut.empUsername as empName, taskdate from usertasks ut
        INNER JOIN tasks
        ON ut.taskid = tasks.taskID
        INNER JOIN users
        ON users.username = ut.empUsername
        INNER JOIN subtasks
        ON ut.subTaskID = subtasks.subtaskid and ut.taskID = subtasks.mainTaskID
        INNER JOIN user_registration
        ON user_registration.uniqueID = ut.uniqueID
        WHERE usertype = 'backoffice' and taskdate = '$date';";

        $result= mysqli_query($conn, $sql);

       

        if (mysqli_num_rows( $result) > 0) { 
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $jsonData = json_encode($data);

            echo $jsonData;
        }

        else {
        
          $response = array(
            'message' => "There is no any completed task by backoffice officers in selected date",
            'status'=> 0);
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }   
    else {
        
        $response = array(
            'message' => "Required details not received",
            'status'=> 0);
            header('Content-Type: application/json');
            echo json_encode($response);
    }
}

$conn->close();
?>