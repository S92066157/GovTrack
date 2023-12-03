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

        $sql = "SELECT name , uniqueID , taskdescription ,empusername, dateAdded from user_registration
        INNER JOIN tasks
        ON user_registration.taskID = tasks.taskID 
        INNER JOIN users
        ON user_registration.empusername = users.username
        WHERE usertype = 'frontoffice' AND dateAdded = '$date';";

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
            'message' => "There is no any completed task by frontoffice officers in selected date",
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