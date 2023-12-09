<?php

include('../connect.php');

session_start();

$usertype = $_SESSION['usertype'];

if (!isset($usertype) || $usertype != 'admin') {
  header('location:adminlogin.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports</title>
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

    .card,
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
            <a class="nav-link active" href="reports.php">Reports</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Status.php">System Status</a>
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
        <h3 class="text-white text-center">Reports</h3>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-8 col-xs-8 col-md-4 col-lg-4 card mx-auto text-center">
        <a href="customerTask.php">
          <div>
            <img src="img/reportTask.svg" class="my-2" height="100px" alt="">
            <h1>Customer task status</h1>
          </div>
        </a>
      </div>


      <div class="col-sm-8 col-xs-8 col-md-4 col-lg-4 card mx-auto text-center">
        <a href="taskbyDate.php">
          <div>
            <img src="img/date.svg" class="my-2" height="100px" alt="">
            <h1>Tasks by date</h1>
          </div>
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-8 col-xs-8 col-md-4 col-lg-4 card mx-auto text-center">
        <a href="taskByUser.php">
          <div>
            <img src="img/users.svg" class="my-2" height="100px" alt="">
            <h1>Task by user</h1>
          </div>
        </a>
      </div>



      <div class="col-sm-8 col-xs-8 col-md-4 col-lg-4 card mx-auto text-center">
        <a href="taskbyDateUser.php">
          <div>
            <img src="img/users.svg" class="my-2" height="100px" alt="">
            <h1>Date + User</h1>
          </div>
        </a>
      </div>
    </div>



  </div>
</body>

</html>