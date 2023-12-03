<?php

include('../../connect.php');

$sql = 'SELECT MAX(taskID) as MaxTask FROM tasks;';
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$maxTaskID = $row['MaxTask'];
$nextTaskID = $maxTaskID + 1;

// Receive data from XHR request
$data = json_decode(file_get_contents('php://input'), true);

// Process and save data to the database
foreach ($data as $inputId => $value) {

    // Perform database Operations

    if (empty($value)) {
        echo "input can not be empty\n";
        exit();
    } else {

        if ($inputId == 0) {
            $sql0 = "INSERT INTO tasks (taskid, taskDescription) VALUES ('$nextTaskID', '$value');";
            $stmt0 = $conn->prepare($sql0);
            if ($stmt0->execute()) {
                echo "New main task added successfully\n";
            } else {
                echo "Adding new main task unsuccessful\n";
            }
        } else {
            $sql = "INSERT INTO subtasks (maintaskid, subtaskid, subtaskDescription) VALUES ('$nextTaskID', '$inputId' , '$value');";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute()) {
                echo 'subtask' . $inputId . "was successfully Added\n";
            } else {
                echo 'Adding subtask' . $inputId . "was unsuccessful\n";
            }
        }
    }
}

// Respond to the client

?>
