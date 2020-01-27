<?php

    require 'db.php';

    session_start();

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
        header("location: index.php");
    }

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $result = $mysqli->query("SELECT * FROM users WHERE username='$username'") or trigger_error("ERROR:". mysqli_error($mysqli), E_USER_ERROR);

        if($result->num_rows == 0){
            $usererror = "User doesn't exist!";
        }
        else{
            $user = $result->fetch_assoc();

            if(password_verify($_POST['password'], $user['password'])){
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['admin'] = $user['admin'];
                header("location: index.php");
            }
            else{
                $passerror = "Incorrect password!";
            }
        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/login.css" rel="stylesheet" type="text/css" media="screen">
    <title>Login</title>
</head>

<body>

    <div class="formdiv">
        <form method="POST" action="login.php" enctype="multipart/form-data">
            <div class="inputbox">
                <p>Username</p>
                <input type="text" name="username" required>
            </div>
            <div class="inputbox">
                <p>Password</p>
                <input type="password" name="password" required>
            </div>
            <div class="container">
                <button class="btn btn--skew btn-default" type="submit">
                    <span>Login</span>
                </button>
            </div>
            <div class="reg">
                <a href="register.php">Register</a>
            </div>
            <div class="errormsg">
            <!-- Errors -->
            <?php if(!empty($usererror)){
                        echo "<p class='error'>" . $usererror . "</p>";
                }
            ?>
            <?php if(!empty($passerror)){
                        echo "<p class='error'>". $passerror. "</p>";
                }
            ?>
            <?php if(!empty($errors)){
                foreach ($errors as $error){
                        echo "<p class='error'>" . $error . "</p>";
                    }
                }
            ?>
            </div>
        </form>
    </div>

    

</body>

</html>