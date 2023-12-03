<?php

include('../../connect.php');


$query = "SELECT taskid, taskdescription FROM tasks";
$result = mysqli_query($conn, $query);

// Process the result and output as JSON
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
