<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frogot Reference</title>

    <style>
        body {
            height: 90vh;
            width: 90vw;
            background-color: rgb(222, 217, 255);
            margin: auto;
        }


        body button {
            cursor: pointer;
        }

        .bodyContent {
            display: flex;
            flex-direction: column;
            height: 90vh;
            width: 90vw;
            margin: auto;
        }


        .heading {
            flex: 2;


        }

        .content {
            flex: 3;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

        }

        form input {
            width: 20%;
            height: 10%;
            margin: 10px auto;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            padding: 5px;

        }

        button {
            width: 20%;
            height: 10%;
            margin: 10px auto;
            text-align: center;
            font-weight: bold;
            background-color: grey;
            border: none;
            box-shadow: none;
            border: 1px solid black;
            font-size: 16px;
            font-weight: bold;
            padding: 5px;
        }

        h2,
        h3 {
            text-align: center;
            margin: 5px;
        }

        button:hover {
            background-color: lightgray;
        }
    </style>
</head>

<body>

    <div class="bodyContent">

        <div class="heading">
            <p
                style="text-align: center; font-weight: bold; font-size: 80px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">
                GovTrack</p>

            <form action="" method="post">
                <div class="content">



                    <input type="text" id="nic" name="nic" placeholder="NIC Number" required>
                    <input type="text" id="contactNo" name="contactNo" placeholder="Contact Number" required>

                    <button type="button" name="button" onclick="inputValidation()" class="btn">Submit</button>

                    <button type="button" onclick="location.href='customer.php'" class="btn"> Back to Home</button>

                    <h2 id="refNumber"> </h2>

                    <button type="button" id="btnCopy" name="btnCopy" onclick="copyText()" class="btn"
                        style="display: none;">Copy Reference</button>
                </div>

            </form>


        </div>
        <h3> Enter NIC and Contact number that you have provide during registration and click on Submit button </h3>


    </div>


    <script>
        function inputValidation() {

            var contactNumber = document.getElementById('contactNo').value;
            var nic = document.getElementById('nic').value;

            if (contactNumber == "" || nic == "") {
                alert("Input fields cannot be empty.\nPlease try again !");
            }
            else {
                retrieveRef();
            }
        }


        function copyText() {
            // Get the text from the paragraph
            var textToCopy = document.getElementById("refNumber").innerText;

            // Create a textarea element to hold the text temporarily
            var textarea = document.createElement("textarea");
            textarea.value = textToCopy;

            // Append the textarea to the document
            document.body.appendChild(textarea);

            // Select the text in the textarea
            textarea.select();

            // Execute the copy command
            document.execCommand("copy");

            // Remove the textarea from the document
            document.body.removeChild(textarea);

            // Provide some feedback to the user (optional)
            alert("Text copied to clipboard: " + textToCopy);
        }

    </script>

    <script src="JS/javascriptsCustomer.js"></script>
</body>

</html>