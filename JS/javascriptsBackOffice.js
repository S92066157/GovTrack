
// Plain JavaScript code to handle button clicks and send AJAX request
function completeTask() {


    if (confirm("This will marks current stage of this task as completed.\nAre you sure to do this ?")) {

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure it: POST-request to taskStatusUpdate.php
        xhr.open("POST", "AJAX/backoffice/taskStatusUpdateUp.php", true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response from the server if needed
                //var responseText = xhr.responseText;

                var response = JSON.parse(xhr.responseText);
                alert(response.message);
                document.getElementById("curTask").innerHTML = "Current Stage :" + response.data;
            }
        };

        xhr.send();
    }
}


function undoTask() {


    if (confirm("This will transfer this task stage back.\n Are you sure to do this ?")) {

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        
        xhr.open("POST", "AJAX/backoffice/taskStatusUpdateDown.php", true);


        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
             
                var response = JSON.parse(xhr.responseText);
                alert(response.message);
                document.getElementById("curTask").innerHTML = "Current Stage :" + response.data;
            }
        };

        // Send the request with the subtask ID as data
        xhr.send();

    }

}


function clearAll() {
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    xhr.open("POST", "AJAX/backoffice/clear.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var buttonNext = document.getElementById('btnTrfNext');
            var buttonBack = document.getElementById('btnTrfBack');
            var buttonFlagError = document.getElementById('btnFlagError');
            var checkbox1 = document.getElementById("error1");
            var checkbox2 = document.getElementById("error2");
            var checkbox3 = document.getElementById("error3");

            document.getElementById('SearchUser').reset();
            document.getElementById('taskName').innerHTML = "Task :None";
            document.getElementById('cusUniqueID').value = "";
            document.getElementById('cusName').value = "";
            document.getElementById('cusNIC').value = "";
            document.getElementById('cusContact').value = "";
            document.getElementById('curTask').innerHTML = "Current Stage :None";
            document.getElementById('TaskDetailsArea').innerHTML = "<table></table>";
            buttonNext.disabled = true;
            buttonBack.disabled = true;
            buttonFlagError.disabled = true;
            checkbox1.checked = false;
            checkbox2.checked = false;
            checkbox3.checked = false;

        }
    };

    // Send the request with the subtask ID as data
    xhr.send();

}



function ErrorAdd() {

    if (confirm("You are going to submit error/s of this task ?\nAre you sure to do this?")) {

        var err1Value = 0;
        var err2Value = 0;
        var err3Value = 0;

        var err1Remark = document.getElementById('eRemark1').value;
        var err2Remark = document.getElementById('eRemark2').value;
        var err3Remark = document.getElementById('eRemark3').value;

        var err1 = document.getElementById('error1');
        var is_e1Checked = err1.checked;

        var err2 = document.getElementById('error2');
        var is_e2Checked = err2.checked;

        var err3 = document.getElementById('error3');
        var is_e3Checked = err3.checked;


        if(err1Remark.length === 0) {
            err1Remark = "None";
        }

        if(err2Remark.length === 0){
            err2Remark = "None";
        }

        if(err3Remark.length === 0) {
            err3Remark = "None";
        }


        console.log(err1Remark);

        if (is_e1Checked) {
            err1Value = 1;
        }

        if (is_e2Checked) {
            err2Value = 1;
        }

        if (is_e3Checked) {
            err3Value = 1;
        }


        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response from the server
                console.log(xhr.responseText);
                alert(xhr.responseText);


            }
        };

        xhr.open("POST", "AJAX/backoffice/addRemoveErrors.php", true);

        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.send("error1=" + encodeURIComponent(err1Value) + 
		"&error2=" + encodeURIComponent(err2Value) + 
		"&error3=" + encodeURIComponent(err3Value) + 
		"&error1Remark=" + encodeURIComponent(err1Remark) +
		"&error2Remark=" + encodeURIComponent(err2Remark) +
		"&error3Remark=" + encodeURIComponent(err3Remark));
    }
}


function getErrorStatus() {

    var checkbox1 = document.getElementById("error1");
    var checkbox2 = document.getElementById("error2");
    var checkbox3 = document.getElementById("error3");

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "AJAX/backoffice/fetchTaskStatus.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
         

            var response = JSON.parse(xhr.responseText);

            document.getElementById('eRemark1').value = response.remark1;
            document.getElementById('eRemark2').value = response.remark2;
            document.getElementById('eRemark3').value = response.remark3;

            if (response.error1 == 1) {
                checkbox1.checked = true;
            }

            if (response.error2 == 1) {
                checkbox2.checked = true;
            }

            if (response.error3 == 1) {
                checkbox3.checked = true;
            }

            if (response.error1 == 0) {
                checkbox1.checked = false;
            }

            if (response.error2 == 0) {
                checkbox2.checked = false;
            }

            if (response.error3 == 0) {
                checkbox3.checked = false;
            }
        }
    };

    // Send the request with the subtask ID as data
    xhr.send();
}
