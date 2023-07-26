<?php

include 'connect.php';

session_start();

$usertype = $_SESSION['usertype'];

if(!isset($usertype)){
   header('location:welcome.html');
}
elseif ($usertype == "frontoffice") {
	header('location:front_officers.php');
}


?>



<!DOCTYPE html>
<html>
<head>
    <title>Back Officer Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        header {
            background-color: #007BFF;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
        }

        nav a:hover {
            background-color: #007BFF;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        h1 {
            color: black;
        }

        p {
            color: #333;
            line-height: 1.6;
        }

        .alert {
            padding: 10px;
            background-color: #f44336;
            color: #fff;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .success {
            background-color: #4CAF50;
        }

        .warning {
            background-color: #ff9800;
        }

        .info {
            background-color: #2196F3;
        }
    </style>
</head>
<body>
    <header>
        <h1>GovTRACK</h1>
    </header>
    <nav>
        <a href="#">Home</a>
        <a href="#">Customers</a>
        <a href="#">Appointments</a>
        <a href="#">Reports</a>
       <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <h1>Dashboard</h1>
        <p>Welcome to the Back Officer's dashboard. Here you can manage customer data, schedule appointments, generate reports, and more.</p>
        <div class="alert success">
            <p><strong>Success!</strong> You have successfully logged in.</p>
        </div>
        <!-- Add more content and functionalities here -->
    </div>
</body>
</html>