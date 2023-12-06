<?php

include ('../../connect.php');

session_start();

$cusRetrievedUID = "";

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else {

    if(isset($_POST['usertype'])) {

        $usertype = $_POST['usertype'];

        $query = "SELECT username FROM users WHERE usertype = '$usertype';";
        $result = mysqli_query($conn, $query);
        
        // Process the result and output as JSON
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        header('Content-Type: application/json');
        echo json_encode($data);        
        
    }   
    
    else {
        
        $response = array(
            'message' => "Required details not received" );
            header('Content-Type: application/json');
            echo json_encode($response);
    }
}

$conn->close();
?>