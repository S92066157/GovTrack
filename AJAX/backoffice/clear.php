<?php

include ('../../connect.php');

session_start();

unset($subTasks);
unset($id, $name, $email, $contact, $address, $nic, $currentSubtask, $taskID, $taskDes, $_SESSION['currentSubTask'], $_SESSION['customerUID']);
         
?>