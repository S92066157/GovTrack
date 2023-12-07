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
    $isbeingUsed = 0;
    

   $sql = "INSERT INTO users (username, password, usertype, firstname, lastname , isbeingUsed) VALUES ('$username', '$password', '$userRole' , '$firstname', '$lastname' , '$isbeingUsed')";

   $stmt = $conn->prepare($sql);

   if($stmt->execute()) {
    echo "User Successfully Created";
   }
   else {
    echo "User creation was not Successful";
   }
    
} else {
    echo "required Data not received";
}

$conn->close();
?>
