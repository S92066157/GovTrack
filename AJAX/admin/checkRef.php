<?php

include ('../../connect.php');

session_start();


// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else {

    if(isset($_POST['uniqueID'])) {
        $uID = $_POST['uniqueID'];

        $sqlCount = "SELECT name , uniqueID from user_registration WHERE uniqueID = '$uID';";

        $resultCount= mysqli_query($conn, $sqlCount);

        if (mysqli_num_rows( $resultCount) == 1) { 
            while ($row = mysqli_fetch_assoc($resultCount)) {
                
                $_SESSION['uniqueIDCustomer'] = $row['uniqueID'];

                $response = array(
                    'message' => "Operation Success. You will redirected to result page",
                    'status'=> 1);
                    header('Content-Type: application/json');
                    echo json_encode($response);

            }
        }

        else {
        
          $response = array(
            'message' => "Provided reference number was not matched with the records in the system database",
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