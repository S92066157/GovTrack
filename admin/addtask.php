<?php

include ( '../connect.php' );

session_start();

?>

<!DOCTYPE html>
<html lang='en'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Add New Task</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'
    integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'
    integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL'
    crossorigin='anonymous'></script>

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
      margin-left: 2%;
    }

    .firstrow input {
      margin-right: 1%;
    }
  </style>
</head>

<body>

  <nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
    <div class='container-fluid'>
      <a class='navbar-brand'>GOVTrack</a>
      <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNavDropdown'
        aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
      </button>
      <div class='collapse navbar-collapse' id='navbarNavDropdown'>
        <ul class='navbar-nav'>
          <li class='nav-item'>
            <a class='nav-link' aria-current='page' href='adminDashboard.php'>Home</a>
          </li>
          <li class='nav-item dropdown'>
            <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' role='button'
              data-bs-toggle='dropdown' aria-expanded='false'>
              Users
            </a>
            <ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
              <li><a class='dropdown-item' href='addUser.php'>Add New User</a></li>
              <li><a class='dropdown-item' href='editUser.php'>Edit Existing User</a></li>
            </ul>
          </li>
          <li class='nav-item'>
            <a class='nav-link active' href='Tasks.php'>Tasks</a>
          </li>
          <li class='nav-item'>
            <a class='nav-link' href='reports.php'>Reports</a>
          </li>
          <li class='nav-item'>
            <a class='nav-link' href='Status.php'>System Status</a>
          </li>
          <li class='nav-item'>
            <a class='nav-link' href='../logout.php'>Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class='background-container'>
    <div class='overlay'></div>
  </div>

  <div class='container-fluid'>

    <div class='row'>
      <div class='col-sm-12 col-md-12 col-lg-12 my-1'>
        <h3 class='text-white text-center mb-1'>Add New Task</h3>
      </div>
    </div>

    <div class='row mx-2'>
      <div class='col-sm-10 col-md-10 col-lg-8 mx-auto text-white mt-1'>

        <form id='addtask'>
          <div class='d-flex align-items-center mb-2 firstrow'>
            <!-- Second Row: Input Field and Buttons -->
            <input type='text' class='form-control mr-1 task' placeholder='Main task' id='0' required>
            <input type='button' class='btn btn-primary  ml-2' onclick='addSubtask()' value='Add Subtask'>
            <input type='button' class='btn btn-warning  ml-2' onclick='removeLastSubtask()' value='Remove Subtask'>
          </div>

          <div class='row'>

            <div class='col-sm-10 col-md-10 col-lg-8 mx-auto text-white '>

              <div id='subtaskContainer'>

              </div>

            </div>

          </div>

        </form>
      </div>
    </div>

    <div class='col-lg-6 mx-auto text-center mt-3 d-flex '>
      <button type='button' onclick='saveData()' class='btn btn-primary mx-auto d-block '>Create New Task</button>
      <button type='button' class='btn btn-danger mx-auto d-block ' onclick='resetForm()'>Clear Form</button>
      <button type='button' class='btn btn-warning mx-auto d-block' onclick="location.href='tasks.php'">Back</button>
    </div>

    </form>

  </div>
  </div>

  </div>

  <script>
    var number = 0;

    function resetForm() {

      document.getElementById('addtask').reset();
    }

    function addSubtask() {
      // Create a new text input field
      var input = document.createElement('input');

      if (number == 10) {
        alert('maximum subtask count is 10');
      } else {
        number += 1;
        var placeholderName = 'subtask' + number;
        input.type = 'text';
        input.name = number;
        input.id = number;
        input.placeholder = placeholderName;
        input.className = 'form-control mt-1 task';

        // Create a div to contain the input field
        var div = document.createElement('div');
        div.appendChild(input);

        // Append the div to the subtask container
        document.getElementById('subtaskContainer').appendChild(div);
      }
    }

    function removeLastSubtask() {
      if (number == 1) {
        alert('There must be at least one subtask');
      } else if (number == 0) {
        alert('No any subtask to remove');
      } else {
        number -= 1;

        var subtaskContainer = document.getElementById('subtaskContainer');
        var subtasks = subtaskContainer.querySelectorAll('div');

        // Check if there are any subtasks to remove
        if (subtasks.length > 0) {
          // Remove the last added subtask
          subtaskContainer.removeChild(subtasks[subtasks.length - 1]);
        }
      }

    }

    function saveData() {
      // Collect data from dynamic inputs
      var inputs = document.getElementsByClassName('task');
      var data = {
      };
      var isEmpty = false;

      for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        var inputId = input.id || input.name || i;
        // Use id, name, or a generated identifier

        var inputValue = input.value.trim();

        if (inputValue === '') {
          isEmpty = true;
        } else {
          data[inputId] = inputValue;
        }
      }

      // Display an alert if any input is empty
      if (isEmpty) {
        alert('All input fields are required');
        return;
        // Stop execution if any input is empty
      }
      else if(number == 0){
        alert('There must be at least one subtask for the main task.');
        return;
      }

      // Send data to the server using XHR
      var xhr = new XMLHttpRequest();
      xhr.open('POST', '../ajax/admin/saveTask.php', true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var response = xhr.responseText;
          alert(response);
          // document.getElementById( 'addtask' ).reset();
          window.location.href = 'addtask.php';
        }
      }
        ;
      xhr.send(JSON.stringify(data));
    }

  </script>

  <script src='../JS/javascriptsAdmin.js'></script>
</body>

</html>