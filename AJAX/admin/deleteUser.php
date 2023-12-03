<?php

include ('../../connect.php');

session_start();



// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username'])) {


    $username = $_POST['username'];
    
    $select_user = mysqli_query($conn,  "SELECT usertype FROM users WHERE username = '$username';") or die('query failed');

    if (mysqli_num_rows($select_user) == 1) {

        $row = mysqli_fetch_assoc($select_user);

        $usertype = $row['usertype'];

        if($row['usertype'] == 'admin'){ 
            echo "Admin user can not be deleted";
        } 
        else {
    
            $sql = "DELETE FROM users WHERE username = '$username'";
            $stmt = $conn->prepare($sql);
        
           if($stmt->execute()) {
            echo "User deleted successfully";
           }
           else {
            echo "User deletion was not Successful";
           }
    
        }

    }
    else {
        echo "No data existing in the system for this username";
    } 
    
} else {
    echo "required Data not received";
}

$conn->close();
?>