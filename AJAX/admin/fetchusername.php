<?php

include ('../../connect.php');

session_start();


$cusRetrievedUID = "";



// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else {

    if(isset($_POST['username'])) {

        $newusername = $_POST['username'];

        if(empty($newusername)){

            $response = array(
                'message' => "New Username cannot be empty. Please try again !");
                header('Content-Type: application/json');
                echo json_encode($response);
        }

        elseif (strlen($newusername) < 5){
            $response = array(
                'message' => "Username must be 5 characters or more. Please try again.");
                header('Content-Type: application/json');
                echo json_encode($response);
        }

        else{

            $sql = "SELECT username from users WHERE username ='$newusername';";

        $result= mysqli_query($conn, $sql);

        if (mysqli_num_rows( $result) > 0) { 
            

                $response = array(
                    'message' => "Username is already taken. Please try another");
                    header('Content-Type: application/json');
                    echo json_encode($response);

            }
        
        else {
            $response = array(
                'message' => "Username is Available" );
                header('Content-Type: application/json');
                echo json_encode($response);
         }
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