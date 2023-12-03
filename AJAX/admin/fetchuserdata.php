<?php

include('../../connect.php');

session_start();


// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

    if (isset($_POST['username'])) {

        $username = $_POST['username'];

        if (!empty($username)) {

            $sql = "SELECT firstname, lastname, usertype FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);

            // Execute the statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            // Fetch the result as an associative array
            $row = $result->fetch_assoc();

            // Close the statement
            $stmt->close();

            $rowCount = $result->num_rows;

            if ($rowCount == 1) {

                $usertype = $row['usertype'];

                if ($usertype == 'admin') {

                    $response = array(
                        'message' => "The userdata of the administrator account cannot be fetched in this form."
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                } else {

                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $usertype = $row['usertype'];

                    $response = array(
                        'username' => $username,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'usertype' => $usertype
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } else {
                $response = array(
                    'message' => "User is not existing in the system"
                );
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        } else {

            $response = array(
                'message' => "Username field is empty. Please try again!"
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        }

    } else {

        $response = array(
            'message' => "Required details not received"
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

$conn->close();
?>