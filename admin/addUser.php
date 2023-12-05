<?php

include('../connect.php');

session_start();



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add User</title>
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

    .customMarginLeft {
      margin-left: 1%;
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
            <a class="nav-link" aria-current="page" href="admindashboard.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Users
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="adduser.php">Add New User</a></li>
              <li><a class="dropdown-item" href="edituser.php">Edit Existing User</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="tasks.php">Tasks</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reports.php">Reports</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="status.php">System Status</a>
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
        <h3 class="text-white text-center">Add New User</h3>
      </div>
    </div>

    <div class="row">


      <div class="col-sm-10 col-md-10 col-lg-8 mx-auto text-white mt-2">

        <form id="userReg">

          <div class="mb-2">
            <label for="fName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="fName" required>
          </div>

          <div class="mb-2">
            <label for="lName" class="form-label">Last Name</label>
            <input type="lName" class="form-control" id="lName" required>
          </div>

          <div class="mb-2">
            <label for="username" class="form-label">Username</label>
            <input type="username" class="form-control" id="username" aria-describedby="usernameHelp" required>

            <div class="col-auto mt-2">
              <button type="button" class="btn btn-warning" onclick="checkUsernameAvailibility()">Check
                Username Availability</button>

              <span class="form-text text-white">
                <p class="d-inline customMarginLeft" id="userAvailability"></p>
              </span>

            </div>

          </div>
          <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" required>
          </div>
          <div class="col-auto">
            <button type="button" class="btn btn-warning" id="passwordVisibility" onclick="showPassword()">Show
              Password</button>
            <span id="passwordhelp" class="form-text text-white">
              Must be 8-20 characters long.
            </span>

          </div>
          <select class="form-select mt-3" id="userRole" aria-label="Default select" required>
            <option disabled selected>Select User Role</option>
            <option value="frontoffice">Frontoffice User</option>
            <option value="backoffice">Backoffice User</option>
          </select>

          <div class="col-lg-6 mx-auto text-center mt-4 d-flex ">
            <button type="button" onclick="formSubmit()" class="btn btn-primary mx-auto d-block ">Create User</button>
            <button type="button" class="btn btn-danger mx-auto d-block " onclick="resetForm()">Clear Form</button>
            <button type="button" class="btn btn-warning mx-auto d-block"
              onclick="location.href='users.php'">Back</button>
          </div>

        </form>



      </div>
    </div>


  </div>


  <script>
    function resetForm() {

      document.getElementById("userReg").reset();
    }

    function formSubmit() {

      var firstname = document.getElementById("fName");
      var lastname = document.getElementById("lName");
      var password = document.getElementById("password");
      var userRole = document.getElementById("userRole");
      var UsernameAvailibility = document.getElementById("userAvailability");

      if (firstname.value.length == 0 || lastname.value.length == 0) {

        alert("First name and Last name required");
      }
      else {

        if (password.value.length >= 8 && password.value.length <= 20) {

          if (userRole.value == "backoffice" || userRole.value == "frontoffice") {

            if (UsernameAvailibility.innerText == "Username is Available") {
              //method to upload data
              createNewUser();
            }

            else {
              alert("Please Recheck username");
            }

          }

          else {
            alert("Please select User role");
          }
        }
        else {
          alert("Password Must be 8-20 characters long.");
        }
      }
    }


    //function for show password in plain text 
    function showPassword() {
      var passwordField = document.getElementById("password");
      var btnPasswordVisibility = document.getElementById("passwordVisibility");

      if (passwordField.type === "password") {
        passwordField.type = "text";
        btnPasswordVisibility.textContent = "Hide Password";
      } else {
        passwordField.type = "password";
        btnPasswordVisibility.textContent = "Show Password";
      }

    }



  </script>

  <script src="../JS/javascriptsAdmin.js"></script>
</body>

</html>