<?php

include('../connect.php');

session_start();



$sql0 = "SELECT COUNT(username) as frontoffice FROM users WHERE usertype = 'frontoffice';";

$stmt0 = $conn->prepare($sql0);
$stmt0->execute();
$result0 = $stmt0->get_result();
$row0 = $result0->fetch_assoc();
$stmt0->close();
$frontofficeCount = $row0['frontoffice'];


$sql1 = "SELECT COUNT(username) as backoffice FROM users WHERE usertype = 'backoffice';";

$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row1 = $result1->fetch_assoc();
$stmt1->close();
$backofficeCount = $row1['backoffice'];


$totalUserCount = $frontofficeCount + $backofficeCount;

$sql2 = "SELECT COUNT(username) as activefront FROM users WHERE usertype = 'frontoffice' and isbeingUsed = 1;";

$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row2 = $result2->fetch_assoc();
$stmt2->close();
$activeFrontofficeCount = $row2['activefront'];


$sql3 = "SELECT COUNT(username) as activeBack FROM users WHERE usertype = 'backoffice' and isbeingUsed = 1;";

$stmt3 = $conn->prepare($sql3);
$stmt3->execute();
$result3 = $stmt3->get_result();
$row3 = $result3->fetch_assoc();
$stmt3->close();
$activeBackofficeCount = $row3['activeBack'];


$totalActive = $activeFrontofficeCount + $activeBackofficeCount;


$sql4 = "SELECT Count(uniqueID) as onGoing FROM user_registration WHERE taskStatus = 1 AND currentsubTask != 'Done'";

$stmt4 = $conn->prepare($sql4);
$stmt4->execute();
$result4 = $stmt4->get_result();
$row4 = $result4->fetch_assoc();
$stmt4->close();
$onGoingTaskCount = $row4['onGoing'];


$sql5 = "SELECT Count(uniqueID) as completed FROM user_registration WHERE taskStatus = 1 AND currentsubTask = 'Done'";

$stmt5 = $conn->prepare($sql5);
$stmt5->execute();
$result5 = $stmt5->get_result();
$row5 = $result5->fetch_assoc();
$stmt5->close();
$completedTaskCount = $row5['completed'];


$sql6 = "SELECT Count(uniqueID) as hold FROM user_registration WHERE taskStatus = 0";

$stmt6 = $conn->prepare($sql6);
$stmt6->execute();
$result6 = $stmt6->get_result();
$row6 = $result6->fetch_assoc();
$stmt6->close();
$holdTaskCount = $row6['hold'];


$sql7 = "SELECT Count(uniqueID) as feedbackSubmitted FROM user_registration WHERE taskStatus = 1 AND currentsubTask = 'Done' AND feedbackgiven = 1";

$stmt7 = $conn->prepare($sql7);
$stmt7->execute();
$result7 = $stmt7->get_result();
$row7 = $result7->fetch_assoc();
$stmt7->close();
$feedbackGivenTaskCount = $row7['feedbackSubmitted'];

$totalTaskCount = $onGoingTaskCount + $completedTaskCount + $holdTaskCount;


?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Status</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

  <style>
    .background-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    .overlay {
      position: absolute;
      width: 100%;
      height: 100%;
      left: 0;
      top: 0;
      background: radial-gradient(#009ac2, #001F27);
      mix-blend-mode: multiply;
      z-index: -100;
    }

    a {
      text-decoration: none;
      color: black;
      margin: none;
    }


    .users,
    .tasks,
    .reports,
    .status {
      background-color: rgb(160, 160, 147);
      margin: 3% 20%;
      border-radius: 20px;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand">GOVTrack</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="adminDashboard.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Users
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="addUser.php">Add New User</a></li>
              <li><a class="dropdown-item" href="editUser.php">Edit Existing User</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Tasks.php">Tasks</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reports.php">Reports</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="Status.php">System Status</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="background-container">
    <div class="overlay"></div>
  </div>

  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12 my-2">
        <h3 class="text-white text-center">System Status</h3>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-8 col-xs-8 col-md-4 col-lg-8  mx-auto text-center">

        <table border="0" class="table table-striped">


          <tr>
            <td> Users Type </td>
            <td> Front-office </td>
            <td> Back-office </td>
            <td> Total </td>
          </tr>
          <tr>
            <td> Registered Users Count </td>
            <td>
              <?php echo $frontofficeCount ?>
            </td>
            <td>
              <?php echo $backofficeCount ?>
            </td>
            <td>
              <?php echo $totalUserCount ?>
            </td>

          </tr>
          <tr>
            <td> Active Users Count </td>
            <td>
              <?php echo $activeFrontofficeCount ?>
            </td>
            <td>
              <?php echo $activeBackofficeCount ?>
            </td>
            <td>
              <?php echo $totalActive ?>
            </td>
          </tr>
        </table>

        <table border="0" class="table table-striped">

          <tr>
            <td> Task Status </td>
            <td> in Progress </td>
            <td> in Hold</td>
            <td> Completed </td>
            <td> Feedback Given </td>
            <td> Total </td>
          </tr>
          <tr>
            <td> Task Count </td>
            <td>
              <?php echo $onGoingTaskCount ?>
            </td>
            <td>
              <?php echo $holdTaskCount ?>
            </td>
            <td>
              <?php echo $completedTaskCount ?>
            </td>
            <td>
              <?php echo $feedbackGivenTaskCount ?>
            </td>
            <td>
              <?php echo $totalTaskCount ?>
            </td>
          </tr>
        </table>
        <p class="text-white">Note -- The total task count does not include tasks for which feedback has been given.
        </p>
        <p class="text-white">Total Task Count = in Progress + in Hold + Completed</p>
      </div>
    </div>


  </div>
</body>

</html>