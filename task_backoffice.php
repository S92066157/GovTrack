<?php
include 'connect.php';
session_start();

$usertype = $_SESSION['usertype'];
$user = $_SESSION['user_name'];

if (!isset($usertype)) {
    header('location:index.php');
} elseif ($usertype == "frontoffice") {
    header('location:dashboard_frontoffice.php');
}

$id = "";
$name = "";
$email = "";
$contact = "";
$address = "";
$nic = "";
$currentSubtask = 0;
$taskID = "";
$taskDes = "None";
$_SESSION['currentSubTask'] = "None";
$_SESSION['customerUID'] = "None";
$user = $_SESSION['user_name'];
$subTasks = array();
$taskStatus = "";

if (!$conn) {
    die("Connection Unsuccessful - " . mysqli_connect_error());
} else {

    if (isset($_POST['id'])) {
        $Uid = $_POST['id'];

        if ($Uid == "") {
            echo '<script>alert("Reference number cannot be empty.\nPlease try again")</script>';
        } else {

            $quaryTaskID = "SELECT uniqueID, taskID , currentSubtask FROM user_registration WHERE uniqueID = '$Uid'";

            $resultTaskID = mysqli_query($conn, $quaryTaskID);

            if (mysqli_num_rows($resultTaskID) == 1) {
                while ($row = mysqli_fetch_assoc($resultTaskID)) {
                    $_SESSION['customerUID'] = $row["uniqueID"];
                    $taskID = $row["taskID"];
                    $_SESSION['customerTaskID'] = $taskID;
                    $_SESSION['currentSubTask'] = $row["currentSubtask"];

                }
            }

            $queryTaskDes = "SELECT subTaskID, subTaskDescription FROM subtasks WHERE mainTaskID = '$taskID'";
            $resultTaskDes = mysqli_query($conn, $queryTaskDes);

            if (mysqli_num_rows($resultTaskDes) > 0) {
                while ($row = mysqli_fetch_assoc($resultTaskDes)) {
                    $subTaskID = $row["subTaskID"];
                    $taskDescription = $row["subTaskDescription"];
                    array_push($subTasks, array("id" => $subTaskID, "description" => $taskDescription));
                }
            }



            $sql = "SELECT uniqueID, name, email, contact, nic ,address , taskdescription , currentsubtask, taskStatus FROM user_registration
        inner join tasks on 
        user_registration.taskid = tasks.taskid WHERE uniqueID = '$Uid'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row["uniqueID"];
                    $name = $row["name"];
                    $email = $row["email"];
                    $contact = $row["contact"];
                    $address = $row["address"];
                    $nic = $row["nic"];
                    $taskDes = $row["taskdescription"];
                    $currentSubtask = $row["currentsubtask"];
                    $taskStatus = $row["taskStatus"];


                    if ($taskStatus == "0") {
                        echo '<script>alert("This Task is Currently in Hold")</script>';
                    }
                }
            } else {
                echo '<script>alert("No results")</script>';
            }
        }

    }

}


mysqli_close($conn);

function clear()
{
    $id = "";
    $name = "";
    $email = "";
    $contact = "";
    $address = "";
    $nic = "";
    $taskid = "";
    $taskDes = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Backoffice</title>

    <style>
        body {
            height: 99vh;
            width: 95vw;
            font-weight: bolder;
            margin: auto;

        }

        /* div {
            border: 1px solid;
        } */

        body button {
            background-color: rgb(236, 182, 182);
            border-radius: 5px;
            cursor: pointer;
        }

        .bodyContent {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 60%;
            margin: auto;
            border: 2px solid black;
        }


        .heading {
            flex: 0.5;
            display: flex;
            flex-direction: row;

        }

        .content {
            flex: 4;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: aqua;

        }

        .content button {
            width: 30%;
            height: 10%;
            margin: 10px auto;
            text-align: center;
            font-weight: bold;
            border: none;
            box-shadow: none;
            border: 1px solid black;
        }

        .workstationInfo,
        .head,
        .logout {
            flex: 1;

        }

        .workstationInfo {
            display: flex;
            flex-direction: column;

        }

        .workstationInfo p {
            font-weight: bold;
            margin: 0;
            text-align: left;
            margin: 2% auto 0 5%;


        }

        .logout {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logout button {
            width: 50%;
            height: 50%;
            margin: 10px auto;
            text-align: center;
            font-weight: bold;
            border: none;
            box-shadow: none;
            border: 1px solid black;
        }


        .content span {
            display: flex;
            flex-direction: row;
            margin: 10px;
        }

        td {
            text-align: left;
        }

        .buttonSet1 {
            display: flex;
            flex-direction: row;
        }

        .buttonSet1 button {
            width: 60px;
            height: 100%;
            margin: 0px 5px;
        }



        .operatorTask {
            width: 100%;
        }

        .operatorTask td {
            justify-content: center;
            align-items: center;
        }



        .operatorTask button {
            width: fit-content;
        }

        .taskStages button {
            width: fit-content;
            height: fit-content;
            margin: 0;
        }

        .taskStages td,
        .taskStages p {
            margin: 0;
            padding: 0;
        }

        #curTask {
            text-align: center;
            background-color: rgb(236, 182, 182);
            margin: 0;
        }

        .opeTask {
            margin: 0;
        }
    </style>
</head>

<body>

    <div class="bodyContent">

        <div class="heading">

            <div class="workstationInfo">

                <p>User ID :
                    <?php echo $user; ?>
                </p>
                <p id="currentDate"></p>

            </div>
            <div class="head">

                <p
                    style="text-align: center; font-weight: bold; font-size: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">
                    GovTrack</p>
            </div>
            <div class="logout">
                <button onclick="location.href='logout.php'">LOGOUT</button>
            </div>


        </div>
        <div class="content">
            <div class="inputs">
                <form id="SearchUser" action="" method="post">

                    <br>
                    <table>
                        <tr style="margin: 0;">
                            <td>Reference NO : </td>
                            <td style="display:flex; flex-direction: row; margin: none;">
                                <input type="text" id="id" name="id" style="width: 60%; margin: 0;">
                                <div class="buttonSet1">
                                    <button type="submit">Search</button>
                </form>

                <button type="button" onclick="clearForm()">Clear</button>

            </div>

            </td>
            </tr>
            </table>

            <form id="customerData">
                <fieldset>
                    <legend>Customer's Details</legend>
                    <table>
                        <tr>
                            <td>Unique ID: </td>
                            <td><input type="text" id="cusUniqueID" value="<?php echo $_SESSION['customerUID']; ?>"
                                    readonly></td>
                        </tr>
                        <tr>
                            <td>Customer Name: </td>
                            <td><input type="text" id="cusName" value="<?php echo $name; ?>" readonly></td>
                        </tr>
                        <tr>
                            <td>Customer NIC: </td>
                            <td><input type="text" id="cusNIC" value="<?php echo $nic; ?>" readonly></td>
                        </tr>
                        <tr>
                            <td>Contact No: </td>
                            <td><input type="text" id="cusContact" value="<?php echo $contact; ?>" readonly></td>
                        </tr>
                    </table>
                </fieldset>
            </form>

            <div class="taskStages">
                <fieldset>
                    <legend>Task's Details</legend>

                    <p id="taskName">Task :
                        <?php echo $taskDes; ?>
                    </p>

                    <fieldset id="stagesofTask">
                        <legend>Stages</legend>

                        <table id="TaskDetailsArea">
                            <?php foreach ($subTasks as $task): ?>
                                <tr>
                                    <td>
                                        <?php echo $task['id'] . "."; ?>
                                    </td>
                                    <td>
                                        <?php echo $task['description']; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>


                        <table id="Errors">

                        </table>
                        <br>
                        <p id="curTask">
                            <?php echo "Current Stage :" . $_SESSION['currentSubTask']; ?>
                        </p>
                    </fieldset>

                    <fieldset id="errors" style="display: none;">
                        <legend>Errors</legend>

                        <table>

                            <tr>
                                <td><label> 1. Error in documents</label></td>
                                <td><input type="checkbox" id="error1" name="error1" value="1" onchange="errors()"></td>
                                <td><input type="text" name="eRemark1" id="eRemark1" placeholder="Enter remark.....">
                                </td>
                            </tr>
                            <tr>
                                <td><label> 2. Missing Documents</label></td>
                                <td><input type="checkbox" id="error2" name="error2" onchange="errors()" value="2"></td>
                                <td><input type="text" name="eRemark2" id="eRemark2" placeholder="Enter remark.....">
                                </td>
                            </tr>
                            <tr>
                                <td><label> 3. Other Error</label></td>
                                <td><input type="checkbox" id="error3" name="error3" onchange="errors()" value="3"></td>
                                <td><input type="text" name="eRemark3" id="eRemark3" placeholder="Enter remark.....">
                                </td>
                            </tr>

                        </table>

                    </fieldset>
            </div>

            <br>
            <div class="operatorTask">

                </fieldset>

                <fieldset class="opeTask">
                    <legend>User's Task</legend>


                    <div id="buttonSet1">
                        <table>
                            <tr>
                                <td> <button type="button" id="btnFlagError" onclick="flagError()">Flag Error</button>
                                </td>
                                <td> <button type="button" id="btnTrfBack" onclick="undoTask()">Transfer Stage
                                        Back</button></td>
                                <td> <button type="button" id="btnTrfNext" onclick="completeTask()">Transfer Next
                                        Stage</button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div id="buttonSet2" style="display: none">
                        <table>
                            <tr>
                                <td><button type="button" onclick="operatorTasks()">Back</button> </td>
                                <td><button type="button" onclick="getErrorStatus()">Check Submitted Errors</button>
                                </td>
                                <td><button type="button" id="submitErrors" onclick="ErrorAdd()">Submit/Remove
                                        Errors</button></td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    </div>

    <script>


        var chboxError1 = document.getElementById('error1');
        var chboxError2 = document.getElementById('error2');
        var chboxError3 = document.getElementById('error3');

        var txtboxError1 = document.getElementById('eRemark1');
        var txtboxError2 = document.getElementById('eRemark2');
        var txtboxError3 = document.getElementById('eRemark3');

        function clearForm() {
            // Use JavaScript to reset the form
            document.getElementById('SearchUser').reset();
            document.getElementById('cusUniqueID').value = "";
            document.getElementById('cusName').value = "";
            document.getElementById('cusNIC').value = "";
            document.getElementById('cusContact').value = "";
            document.getElementById('curTask').innerHTML = "Current Stage :None";

            clearAll();
            buttonDisable();
            operatorTasks();
        }


        function buttonDisable() {

            var curTaskInfo = document.getElementById('curTask');
            var buttonNext = document.getElementById('btnTrfNext');
            var buttonBack = document.getElementById('btnTrfBack');
            var buttonFlagError = document.getElementById('btnFlagError');

            txtboxError1.disabled = true;
            txtboxError2.disabled = true;
            txtboxError3.disabled = true;

            var btnErrorSubmit = document.getElementById('submitErrors');
            var valText = "Current Stage :Done";
            var valText2 = "Current Stage :None";


            if (curTaskInfo.textContent.includes(valText) || curTaskInfo.textContent.includes(valText2)) {
                buttonNext.disabled = true;
                buttonBack.disabled = true;
                buttonFlagError.disabled = true;
            }
            else {
                buttonNext.disabled = false;
                buttonBack.disabled = false;
                buttonFlagError.disabled = false;
            }
        }


        function errors() {

            if (chboxError1.checked == true) {
                txtboxError1.disabled = false;

            }
            else {
                txtboxError1.disabled = true;
            }

            if (chboxError2.checked == true) {
                txtboxError2.disabled = false;

            }
            else {
                txtboxError2.disabled = true;
            }

            if (chboxError3.checked == true) {
                txtboxError3.disabled = false;

            }
            else {
                txtboxError3.disabled = true;
            }


        }


        function operatorTasks() {


            document.getElementById('buttonSet1').style.display = 'block';
            document.getElementById('stagesofTask').style.display = 'block';

            document.getElementById('buttonSet2').style.display = 'none';
            document.getElementById('errors').style.display = 'none';

        }

        function flagError() {

            getErrorStatus();


            var txtTaskname = document.getElementById('taskName');

            if (txtTaskname.textContent.includes("None")) {
                alert("Please load a task by entering reference number first");
            }
            else {

                document.getElementById('buttonSet1').style.display = 'none';
                document.getElementById('stagesofTask').style.display = 'none';

                document.getElementById('buttonSet2').style.display = 'block';
                document.getElementById('errors').style.display = 'block';
            }

        }

        window.onload = function () {
            buttonDisable();
            getErrorStatus();

        }

        window.onunload = function(event) {
  event.returnValue = "Write something clever here..";
};


        var currentDate = new Date();
        var options = { year: 'numeric', month: 'short', day: 'numeric' };
        var dateElement = document.getElementById("currentDate");
        dateElement.textContent = "Date: " + currentDate.toLocaleDateString('en-US', options);
    </script>

    <script src="JS/javascriptsBackOffice.js"></script>
</body>

</html>