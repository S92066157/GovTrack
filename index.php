<?php
include 'connect.php';

session_start();

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($username) || empty($pass)) {
        $message[] = 'Inputs cannot be empty. Please retry !';
    } else {
        $select_users = mysqli_query($conn, "SELECT * FROM users  WHERE username = '$username' AND password = '$pass'") or die('query failed');

        if (mysqli_num_rows($select_users) == 1) {
            $row = mysqli_fetch_assoc($select_users);

            if ($row['usertype'] != 'admin') {
                if ($row['isBeingUsed'] == 0) {
                    $currentUsername = $row['username'];
                    $_SESSION['user_name'] = $currentUsername;

                    $sql = "UPDATE users SET isbeingUsed = 1 WHERE username = '$currentUsername';";
                    $stmt = $conn->prepare($sql);

                    if ($stmt->execute()) {
                        if ($row['usertype'] == 'frontoffice') {
                            $_SESSION['usertype'] = $row['usertype'];
                            $_SESSION['user_name'] = $row['username'];
                            header('location:dashboard_frontoffice.php');
                        } elseif ($row['usertype'] == 'backoffice') {
                            $_SESSION['usertype'] = $row['usertype'];
                            $_SESSION['user_name'] = $row['username'];
                            header('location:task_backoffice.php');
                        } else {
                            $message[] = "User type not found";
                        }
                    } else {
                        $message[] = "User State change unsuccess";
                    }
                } else {
                    $message[] = 'user is being used in another location ';
                }
            } else {
                $message[] = "User can not use in this context";
            }
        } else {
            $message[] = 'Incorrect username or password!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <style>
       body {
            height: 99vh;
            width: 95vw;
            font-weight: bolder;
            margin: auto;

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
        }
    </style>
</head>

<body>
    <div class="bodyContent">
        <div class="heading">
            <p style="text-align: center; font-weight: bold; font-size: 80px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">
                GovTrack
            </p>

            <form action="" method="post">
                <div class="content">
                    <input type="text" id="username" name="username" placeholder="Username">
                    <input type="password" id="password" name="password" placeholder="Password">
                    <input type="submit" name="submit" value="LOGIN" class="btn">
                    <input type="button" name="submit" value="Administrator Login" onclick="location.href='admin/adminlogin.php'" class="btn">
                </div>
            </form>

            <h4 style="text-align:center;">
                <?php
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '
      <div class="message">
         <span>' . $message . '</span>
      </div>
      ';
                    }
                }
                ?>
            </h4>
        </div>
    </div>
</body>

</html>
