<?php

include('../../connect.php');

session_start();


// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username'])) {

    $username = $_POST['username'];

    $sql = "UPDATE users SET isbeingUsed = 0 WHERE username = '$username';";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute()) {
        echo "User state has been reset successfully";
    } else {
        echo "Operation Unsuccessful";
    }

} else {
    echo "required Data not received";
}

$conn->close();
?>