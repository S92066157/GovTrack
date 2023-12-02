<?php

include ('../../connect.php');

session_start();

$uID = $_SESSION['customerUID'];
$mainTaskStatus = "";
$error1 = 0;
$error2 = 0;
$error3 = 0;
$remark1 = "";
$remark2 = "";
$remark3 = "";

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else {


$sql = "SELECT taskStatus from user_registration WHERE uniqueID = '$uID';";

    $resultTaskStatus = mysqli_query($conn, $sql);

    if (mysqli_num_rows( $resultTaskStatus) == 1) { 
        while ($row = mysqli_fetch_assoc($resultTaskStatus)) {
            $mainTaskStatus = $row['taskStatus'];
    }
}



if ($mainTaskStatus == 1) {
    $response = array(
        'error1' => 0 ,
        'error2' => 0 ,
        'error3' => 0 ,
        'remark1' => $remark1,
        'remark2' => $remark2,
        'remark3' => $remark3 );
        header('Content-Type: application/json');
        echo json_encode($response);
}

    else {


                $sql1 = "SELECT errorID , isErrorOccured , remark from taskerrors WHERE uniqueID = '$uID';";

                $resultErrors = mysqli_query($conn, $sql1);

                            if (mysqli_num_rows($resultErrors) > 0) {
                                while ($row = mysqli_fetch_assoc($resultErrors)) {
                                    if ($row['errorID'] == 1 && $row['isErrorOccured'] == 1 ) {
                                        $error1 = 1;
                                        $remark1 = $row['remark'];

                                    } elseif ($row['errorID'] == 2 && $row['isErrorOccured'] == 1) {
                                        $error2 = 1;
                                        $remark2 = $row['remark'];

                                    } elseif ($row['errorID'] == 3 && $row['isErrorOccured'] == 1) {

                                        $error3 = 1;
                                        $remark3 = $row['remark'];
                                    }
                                }
                            }

                            $response = array(
                                'error1' => $error1,
                                'error2' => $error2,
                                'error3' => $error3,
                                'remark1' => $remark1,
                                'remark2' => $remark2,
                                'remark3' => $remark3

                            );

                            header('Content-Type: application/json');
                            echo json_encode($response);
  
            
    }
}


$conn->close();
?>