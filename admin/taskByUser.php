<?php

include('../connect.php');

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task by User</title>
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

    .firstrow input {
      margin-right: 1%;
    }

    .customMarginLeft {
      margin-left: 5%;
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
        <h2 class="text-white text-center">Task by User</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-8 col-xs-8 col-md-4 col-lg-8 mx-auto text-center">

        <form id="userSelection" method="post">
          <div class="align-items-center mt-1 firstrow">
            <h5 class="text-white"> select user type and username </h5>

            <div class="row">
              <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8 mt-2 text-center mx-auto d-lg-flex">
                <select style="margin-right: 10px;" class="form-select" id="usertype" onchange="loadUsernames()"
                  id="usertype">
                  <option value="0" selected disabled>Choose User Type</option>
                  <option value="frontoffice">Front-office</option>
                  <option value="backoffice">Back-office</option>
                </select>

                <select class="form-select" name="username" id="username">
                  <option value="0" selected disabled>Choose User Name</option>
                </select>
              </div>
            </div>
        </form>
        <div class="row">
          <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8 mt-4 text-center mx-auto">
            <input type="button" class="btn btn-primary " onclick="loadtaskbyUser()" value="SEARCH">
            <input type="button" onclick="location.href='reports.php'" class="btn btn-danger" value="BACK">
          </div>
        </div>

       
      </div>
    </div>
    <div class="row">
          <div class="col-sm-8 col-xs-8 col-md-10 col-lg-10 mx-auto text-center">
            <h5 id="heading" class="mt-3 text-white"> </h5>
            <table id="resultTable" class="table table-striped mt-3">
            </table>
          </div>
        </div>
  </div>


  <script src="../JS/javascriptsAdmin.js"></script>
</body>

</html>