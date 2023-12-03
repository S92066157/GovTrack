<?php

include ('../../connect.php');

session_start();



// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['userRole']) && isset($_POST['firstname']) && isset($_POST['lastname'])) {


    $username = $_POST['username'];
    $password = $_POST['password'];
    $userRole = $_POST['userRole'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    

   $sql = "UPDATE users SET firstname = ? , lastname = ? , password = ? , usertype = ? WHERE username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $firstname, $lastname, $password, $userRole, $username);

   if($stmt->execute()) {
    echo "User details update successfully";
   }
   else {
    echo "User data update was not Successful";
   }
    
} else {
    echo "required Data not received";
}

$conn->close();
?>
