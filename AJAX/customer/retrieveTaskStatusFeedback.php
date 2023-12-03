<?php

include 'connect.php';

session_start();

$cusUID = $_SESSION['uniqueID'];

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    if (!empty($cusUID)) {
        $sql = "SELECT currentSubTask FROM user_registration WHERE uniqueID = '$cusUID';";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['currentSubTask'] == "Done") {
                    $sql1 = "SELECT feedbackgiven FROM user_registration WHERE uniqueID = '$cusUID';";
                    $result1 = mysqli_query($conn, $sql1);

                    if (mysqli_num_rows($result1) == 1) {
                        while ($row1 = mysqli_fetch_assoc($result1)) {
                            if ($row1['feedbackgiven'] == 1) {
                                $response = array(
                                    'message' => "Feedback has been already given",
                                    'status' => 0
                                );
                                header('Content-Type: application/json');
                                echo json_encode($response);
                            } else {
                                $response = array(
                                    'status' => 1
                                );
                                header('Content-Type: application/json');
                                echo json_encode($response);
                            }
                        }
                    }
                } else {
                    $response = array(
                        'message' => "To provide feedback all tasks need to be completed",
                        'status' => 0
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            }
        }
    } else {
        $response = array(
            'message' => "Customer UniqueID not found.\nPlease re-authenticate"
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

$conn->close();
?>
