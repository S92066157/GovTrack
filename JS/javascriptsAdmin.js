
//function for check username availability - in Create new user in Administrator
function checkUsernameAvailibility() {

    var username = document.getElementById('username').value;
    var userStatus = document.getElementById('userAvailability');

    var xhr = new XMLHttpRequest();

    // Configure it: POST-request to with php file
    xhr.open("POST", "../ajax/admin/fetchusername.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = JSON.parse(xhr.responseText);

            userStatus.innerText = response.message;
        }
    };
    
    xhr.send("username=" + encodeURIComponent(username));
}

function createNewUser() {

    var username = document.getElementById('username').value;
    var password = document.getElementById("password").value;
    var userRole = document.getElementById("userRole").value;
    var firstname = document.getElementById("fName").value;
    var lastname = document.getElementById("lName").value;

    var xhr = new XMLHttpRequest();

    // Configure it: POST-request to with php file
    xhr.open("POST", "../ajax/admin/createNewUser.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = xhr.responseText;

            document.getElementById('userAvailability').innerText = " ";
            alert(response);
            document.getElementById("userReg").reset();

        }
    };

    xhr.send("username=" + encodeURIComponent(username) +
        "&password=" + encodeURIComponent(password) +
        "&userRole=" + encodeURIComponent(userRole) +
        "&firstname=" + encodeURIComponent(firstname) +
        "&lastname=" + encodeURIComponent(lastname));

}


function updateUser() {

    var username = document.getElementById('username').value;
    var password = document.getElementById("password").value;
    var userRole = document.getElementById("userRole").value;
    var firstname = document.getElementById("fName").value;
    var lastname = document.getElementById("lName").value;

    var xhr = new XMLHttpRequest();


    // Configure it: POST-request to with php file
    xhr.open("POST", "../ajax/admin/updateUserData.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = xhr.responseText;
            alert(response);
            document.getElementById("userReg").reset();

        }
    };

    xhr.send("username=" + encodeURIComponent(username) +
        "&password=" + encodeURIComponent(password) +
        "&userRole=" + encodeURIComponent(userRole) +
        "&firstname=" + encodeURIComponent(firstname) +
        "&lastname=" + encodeURIComponent(lastname));
}


function deleteUser() {

    var username = document.getElementById('username').value;

    var xhr = new XMLHttpRequest();

    // Configure it: POST-request to with php file
    xhr.open("POST", "../ajax/admin/deleteUser.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = xhr.responseText;

            alert(response);
            console.log(response);

            document.getElementById("userReg").reset();

        }
    };

    xhr.send("username=" + encodeURIComponent(username));
}


function loadUserData() {

    var username = document.getElementById('username').value;
    var userRole = document.getElementById("userRole");
    var firstname = document.getElementById("fName");
    var lastname = document.getElementById("lName");

    var xhr = new XMLHttpRequest();


    // Configure it: POST-request to with php file
    xhr.open("POST", "../ajax/admin/fetchuserdata.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = JSON.parse(xhr.responseText);

            if (response.hasOwnProperty("message")) {
                alert(response.message);
            }
            else {
                firstname.value = response.firstname;
                lastname.value = response.lastname;
                userRole.value = response.usertype;
            }

        }
    };
    xhr.send("username=" + encodeURIComponent(username));
}



function loadUserDataDelete() {

    var username = document.getElementById('username').value;
    var userRole = document.getElementById("userRole");
    var firstname = document.getElementById("fName");
    var lastname = document.getElementById("lName");

    var xhr = new XMLHttpRequest();

    // Configure it: POST-request to with php file
    xhr.open("POST", "../ajax/admin/fetchuserdata.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = JSON.parse(xhr.responseText);

            if (response.hasOwnProperty("message")) {
                alert(response.message);
            }
            else {
                firstname.value = response.firstname;
                lastname.value = response.lastname;
                userRole.value = response.usertype;
                if (confirm("Are you sure to delete below indicated user?\nUsername : " + response.username)) {
                    deleteUser();
                }
                else {
                    alert("Operation aborted by User");
                }
            }
        }
    };

    xhr.send("username=" + encodeURIComponent(username));

}


function retrieveTaskDetails() {

    var uniqueID = document.getElementById('uniqueID').value;

    var xhr = new XMLHttpRequest();

    // Configure it: POST-request to with php file
    xhr.open("POST", "../ajax/admin/checkRef.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = JSON.parse(xhr.responseText);

            if (response.status == 1) {
                alert(response.message);
                window.location.href = "customerTaskReport.php";
            }
            else {
                alert(response.message);
            }

        }
    };

    xhr.send("uniqueID=" + encodeURIComponent(uniqueID));
}



function retrieveDetailsbyDateFront() {

    var date = document.getElementById('date').value;
    var table = document.getElementById('resultTableFront');
    var heading = document.getElementById('frontHeading');

    var xhr = new XMLHttpRequest();

    // Configure it: POST-request to with php file
    xhr.open("POST", "../ajax/admin/checkbyDateFront.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = JSON.parse(xhr.responseText);

            if (response.status == 0) {
                alert(response.message);
                heading.innerText = "";
                table.innerHTML = "";
            }


            else {
                heading.innerText = "Task by frontoffice officers"
                table.innerHTML = "<th> Customer name </th><th> UniqueID </th><th> Task Description</th> <th> Date </th><th> EMP Username </th>";

                response.forEach(function (item) {
                    table.innerHTML += '<tr><td>' + item.name + '</td><td>' + item.uniqueID + '</td><td>' + item.taskdescription + '</td><td>' + item.dateAdded + '</td><td>' + item.empusername + '</td><tr>';
                });

            }
        }
    };

    xhr.send("date=" + encodeURIComponent(date));
}

function retrieveDetailsbyDateBack() {

    var date = document.getElementById('date').value;
    var table = document.getElementById('resultTableBack');
    var heading = document.getElementById('backHeading');


    var xhr = new XMLHttpRequest();


    // Configure it: POST-request to with php file
    xhr.open("POST", "../ajax/admin/checkbyDateBack.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = JSON.parse(xhr.responseText);

            console.log(response);

            if (response.status == 0) {
                alert(response.message);
                heading.innerText = "";
                table.innerHTML = "";
            }
            else {
                heading.innerText = "Task by Backoffice officers"
                table.innerHTML = "<th> Customer name </th><th> UniqueID </th><th> Task Description</th> <th> Subtask Description</th> <th> Task Date </th><th> EMP Username </th>";

                response.forEach(function (item) {
                    table.innerHTML += '<tr><td>' + item.name + '</td><td>' + item.uID + '</td><td>' + item.taskdescription + '</td><td>' + item.subtaskdescription + '</td><td>' + item.taskdate + '</td><td>' + item.empName + '</td><tr>';
                });

            }

        }
    };

    xhr.send("date=" + encodeURIComponent(date));
}


function loadUsernames() {

    var usertype = document.getElementById('usertype').value;
    var username = document.getElementById('username');

    var xhr = new XMLHttpRequest();


    // Configure it: POST-request to with php file
    xhr.open("POST", "../ajax/admin/getUsernames.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = JSON.parse(xhr.responseText);
            username.innerHTML = '<option value="0" selected disabled>Choose User Name</option>';

            // Loop through the data and create option elements
            response.forEach(item => {
                var option = document.createElement('option');
                option.value = item.username;
                option.textContent = item.username;
                username.appendChild(option);
            });

        }
    };

    xhr.send("usertype=" + encodeURIComponent(usertype));
}

function loadtaskbyUser() {

    var username = document.getElementById('username').value;
    var table = document.getElementById('resultTable');
    var heading = document.getElementById('heading');

    var xhr = new XMLHttpRequest();

    // Configure it: POST-request to with php file
    xhr.open("POST", "../ajax/admin/checkbyUsername.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = JSON.parse(xhr.responseText);

            // console.log(response);

            if (response.status == 0) {
                alert(response.message);
                heading.innerText = "No Result";
                table.innerHTML = "";
            }
            else {
                heading.innerText = "Task by " + username;
                table.innerHTML = "<th> Customer name </th><th> UniqueID </th><th> Task Description</th> <th> Date </th><th> EMP Username </th>";

                response.forEach(function (item) {
                    table.innerHTML += '<tr><td>' + item.name + '</td><td>' + item.uID + '</td><td>' + item.taskdescription + '</td><td>' + item.taskdate + '</td><td>' + item.empName + '</td><tr>';
                });

            }

        }
    };
   
    xhr.send("username=" + encodeURIComponent(username));
}


//Function for test External JS file
function test2() {
    alert("External JS file working");
}