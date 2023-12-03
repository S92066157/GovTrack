function checkContactDetails() {
    var xhr = new XMLHttpRequest();
    var inputContactNo = document.getElementById('contactNo').value;

    xhr.open("POST", "AJAX/customer/contactDetails.php", true);

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {


            var response = JSON.parse(xhr.responseText);

            if (response.message == "Operation Success!") {
                alert(response.message + "\nYou will be redirected to details page");
                window.location.href = "customer3.php";
            }
            else {
                alert(response.message + "\nPlease try again !");
            }

        }
    };


    xhr.send("contactNo=" + encodeURIComponent(inputContactNo));
}



function retrieveRef() {
    var xhr = new XMLHttpRequest();
    var contactNumber = document.getElementById('contactNo').value;
    var nic = document.getElementById('nic').value;
    var output = document.getElementById('refNumber');
    var buttonCopy = document.getElementById('btnCopy');



    xhr.open("POST", "AJAX/customer/retrieveRef.php", true);


    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var response = JSON.parse(xhr.responseText);

            if (response.message == "Operation Success!") {
                alert(response.message + "\nYou can find your reference number below");

                buttonCopy.style.display = 'block';
                output.innerHTML = response.UniqueID;
            }
            else {
                alert(response.message + "\nPlease try again !");
            }
        }
    };

    xhr.send("contactNo=" + encodeURIComponent(contactNumber) + "&nic=" + encodeURIComponent(nic));
}

function exit() {

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "logout.php", true);

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
        }
    };
    
    xhr.send();

}

function checkTaskStatuFeedback()  {
    var xhr = new XMLHttpRequest();

    var progressDiv = document.getElementById('progressTask');
    var feedbackDiv = document.getElementById('feedback');
    var btnPrimary = document.getElementById('buttonSet1');
    var btnSecondary = document.getElementById('buttonSet2');


    xhr.open("POST", "AJAX/customer/retrieveTaskStatusFeedback.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            // Handle the successful response from the server
             var response = JSON.parse(xhr.responseText);
            
            
            if (response.status == 1) {
                progressDiv.style.display = 'none';
                btnPrimary.style.display = 'none';
                
                feedbackDiv.style.display = 'flex';
                btnSecondary.style.display = 'flex';
                
            }
            else {
                alert(response.message);
            }

        }
    };

    // Send the request with the encoded contactNo parameter
    xhr.send();
}



function back(){
    var progressDiv = document.getElementById('progressTask');
    var feedbackDiv = document.getElementById('feedback');
    var btnPrimary = document.getElementById('buttonSet1');
    var btnSecondary = document.getElementById('buttonSet2');

                progressDiv.style.display = 'flex';
                btnPrimary.style.display = 'flex';
                
                feedbackDiv.style.display = 'none';
                btnSecondary.style.display = 'none';

}

function postFeedback(){
    var xhr = new XMLHttpRequest();

    var rating = document.getElementById('feedbackList').value;
    var feedbackText = document.getElementById('feedbackText').value;

    xhr.open("POST", "AJAX/customer/postFeedback.php", true);

    // Set the Content-Type header for POST requests
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the onreadystatechange callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            // Handle the successful response from the server
             var response = JSON.parse(xhr.responseText);
            
            alert(response.message); 
            back();
        }
    };

    // Send the request with the encoded contactNo parameter
    xhr.send("rating=" + encodeURIComponent(rating) + "&feedback=" + encodeURIComponent(feedbackText));
}


//Function for test External JS file
function test2() {
    alert("External JS file working");
}