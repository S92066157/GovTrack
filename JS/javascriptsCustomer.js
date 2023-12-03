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

//Function for test External JS file
function test2() {
    alert("External JS file working");
}