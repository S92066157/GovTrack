<?php

include ('../../connect.php');

session_start();

$uID = $_SESSION['uniqueID'];
$contactNumber = '';



// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else {

    if(isset($_POST['contactNo'])) {

        $userContactNo = $_POST['contactNo'];

        $sqlContact = "SELECT contact from customer_registration WHERE uniqueID = '$uID';";

        $resultContact = mysqli_query($conn, $sqlContact);

        if (mysqli_num_rows( $resultContact) == 1) { 
            while ($row = mysqli_fetch_assoc($resultContact)) {
                $contactNumber = $row['contact'];
            }
        }

        else {
            echo "No Result";
        }

        if($userContactNo == $contactNumber) {
            
            $response = array(
                'message' => "Operation Success!" );
                header('Content-Type: application/json');
                echo json_encode($response);
             
        }
        else {
            
            $response = array(
                'message' => "Provided contact number may not matched with records" );
                header('Content-Type: application/json');
                echo json_encode($response);
        }

    }   

    else {
        echo "Phone number not received";
    }
}

$conn->close();
?>