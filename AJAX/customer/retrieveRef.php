<?php

include ('../../connect.php');

session_start();


$cusRetrievedUID = "";



// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else {

    if(isset($_POST['contactNo']) && isset($_POST['nic'])) {


        $userContactNo = $_POST['contactNo'];
        $userNIC = $_POST['nic'];

        $sqlCusDetails = "SELECT uniqueID from user_registration WHERE NIC = '$userNIC' AND contact = '$userContactNo';";

        $resultCusDetails = mysqli_query($conn, $sqlCusDetails);

        if (mysqli_num_rows( $resultCusDetails) == 1) { 
            while ($row = mysqli_fetch_assoc($resultCusDetails)) {
                $cusRetrievedUID = $row['uniqueID'];

                $response = array(
                    'message' => "Operation Success!",
                    'UniqueID' => $cusRetrievedUID );
                    header('Content-Type: application/json');
                    echo json_encode($response);

            }
        }

        else {
            $response = array(
                'message' => "Provided details not matched with the records in the system database" );
                header('Content-Type: application/json');
                echo json_encode($response);
        }
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