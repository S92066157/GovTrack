<?php

include 'connect.php';

session_start();


$cusUID = $_SESSION['uniqueID'];



// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else {

    if(isset($_POST['rating']) && isset($_POST['feedback']) ) {

        $rating = $_POST['rating'];
        $feedback = $_POST['feedback'];

        $sql0 = "INSERT INTO customerfeedback ( uniqueID, ratings, feedback) VALUES ( '$cusUID', '$rating', '$feedback');";
        $stmt0 = $conn->prepare($sql0);

        $sql1 = "UPDATE user_registration SET feedbackGiven = 1 WHERE uniqueID ='$cusUID';";
        $stmt1 = $conn->prepare($sql1);

        if ($stmt0->execute() && $stmt1->execute()){

            $response = array(
                'message' => "Feedback successfully posted !");
                header('Content-Type: application/json');
                echo json_encode($response);
    
            }
        else{
                $response = array(
                    'message' => "Feedback submission unsuccessful");
                    header('Content-Type: application/json');
                    echo json_encode($response);
            }        
    }   
    else {
        
        $response = array(
            'message' => "Required data not received");
            header('Content-Type: application/json');
            echo json_encode($response);
    }
}

$conn->close();
?>