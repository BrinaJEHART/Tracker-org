<?php
    require 'db.php';

    session_start();

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
        header("location: index.php");
    }

    $errors = [];
    if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])){

        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $email = $_POST['email'];

        if(strlen($password) < 8){
            $errors[] = 'Password must be at least 8 characters long.';
        }
        else if($password != $password2){
            $errors[] = 'The passwords do not match.';
        }
        else if((strlen($username) < 4) || (strlen($username) > 16)){
            $errors[] = 'Username must be between 4 and 16 characters long.';
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Invalid email format";
        }
        else{
            $username = $mysqli->escape_string(trim($_POST['username']));
            $email = $mysqli->escape_string(trim($_POST['email']));
            $password = $mysqli->escape_string(password_hash(trim($_POST['password']), PASSWORD_BCRYPT));

            $result = $mysqli->query("SELECT * FROM users WHERE username='$username'") or die($mysqli->error());

            $user = $result->fetch_assoc();

            if($result->num_rows > 0){
                $errors[] = "Account already exists!";
            }
            else{
                $sql = "INSERT INTO users (username, password, email, time_created)". "VALUES ('$username', '$password', '$email', NOW())";
                if($mysqli->query($sql)){
                    $successmsg = "Account created!";
                    header("location: login.php");
                }
                else{
                    $errors[] = "Account creation failed!";
                }
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
    <link href="css/register.css" rel="stylesheet" type="text/css" media="screen">
    <title>Register</title>
</head>

<body>
    <div class="formdiv">
        <form method="POST" action="register.php" enctype="multipart/form-data">
            <div class="inputbox">
                <p>Username</p>
                <input type="text" name="username" placeholder="e.g. Brina" required>
            </div>
            <div class="inputbox">
                <p>Password</p>
                <input type="password" name="password" placeholder="e.g. mijav#1" required>
            </div>
            <div class="inputbox">
                <p>Confirm password</p>
                <input type="password" name="password2" placeholder="e.g. mijav#1" required>
            </div>
            <div class="inputbox">
                <p>E-mail:</p>
                <input type="email" name="email" required>
            </div>
            <div class="container">
                <button class="btn btn--skew btn-default" type="submit">
                    <span>Register</span>
                </button>
            </div>
            <div class="bck">
                <a href="index.php">Go back</a>
            </div>
            <div>
            <?php
                    if(!empty($errors)){
                        foreach($errors as $error){
                            echo "<p class='error' style='color: white;'>" . $error . "</p>";

                        }
                   }
                ?>           
            </div>
        </form>
    </div>
</body>

</html>