<?php

    require 'db.php';

    session_start();

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }

    if(isset($_POST['submit'])){

        $vsota = $mysqli->escape_string(trim($_POST['vsota']));
        $desc = $mysqli->escape_string(trim($_POST['desc']));

        $currentDir = getcwd();
        $uploadDirectory = "/images/";
        $errors = [];
        $fileExtensions = ['jpeg','jpg','png'];

        $fileName = $_FILES['picfile']['name'];
        $fileSize = $_FILES['picfile']['size'];
        $fileTempName = $_FILES['picfile']['tmp_name'];
        $fileType = $_FILES['picfile']['type'];
        $fileExtension = substr($fileName, strrpos($fileName, '.')+1);
        
        // Explode - Vzame 2 parametra, uno piko in ime datoteke, to pomeni da bo naredlo tabelo in bo ločlo ime tam ko najde piko
        // npr jezus.jpg in če uporabiš explode bo tam ko je pika ju ločlo in bo naredlo tabelo in na prvem indeksu bo jezus na druem pa jpg
        // End - vzame zadni indeks v tabeli torej dobiš tst jpg
        // stringtolowercase - ti vse črke spremeni v male

        $potHash = bin2hex(random_bytes(5));

        $uploadPath = $currentDir . $uploadDirectory . basename($fileName);

        if(!in_array($fileExtension, $fileExtensions)){
            $errors[] = "Invalid picture format, please use only .jpeg, .jpg, or .png formats.";
        }

        if($fileSize > 2000000){
            $errors[] = "File exceeds the maximum size limit of 2MB";
        }

        else{
            $didUpload = move_uploaded_file($fileTempName, $uploadPath);
            if ($didUpload){
                rename('images/' . basename($fileName), 'images/' . $potHash . "." . $fileExtension);
                $potDoSlike = $potHash . "." . $fileExtension;
                $sql = "INSERT INTO racuni (vsota, datum, pot, opis, user_id)". "VALUES('$vsota', NOW(), '$potDoSlike', '$desc', '{$_SESSION['user_id']}')";
                if($mysqli->query($sql)){
                    header("location: insert.php?success=1");
                }
                else{
                    $errors[] = "Couldn't execute the query.";
                    trigger_error("ERROR." . mysqli_error($mysqli), E_USER_ERROR);
                }
            }
            else{
                $errors[] = "Oops! Something went wrong!";
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
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Questrial|Rajdhani" rel="stylesheet">
    <link href="css/insert.css" rel="stylesheet" type="text/css" media="screen">
    <title>Insert Values</title>
</head>
<body>
<div id="navbar">
            <ul class="navbar">
                <?php 
                    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
                    echo "<div class='dropdown'>
                            <li>
                                <img src='slike/user_icon.png' alt='Slika' width='50px' height='50px' class='user_icon'>
                                <div class='dropdown_content'>
                                    <a href='account.php'>Account</a>
                                    <a href='logout.php'>Logout</a>
                                </div>
                            </li>
                            </div>
                            <li><a href='index.php'>Home</a></li>
                            <li><a href='insert.php'>Add Values</a></li>
                            <li><a href='table.php'>Table</a></li>
                            ";
                            if(isset($_SESSION['admin']) && $_SESSION['admin']){
                                echo "<li><a href='users.php'>Users</a></li>";
                                echo "<li><a href='pending.php'>Pending</a></li>";
                            }
 
                        }
                    else{
                        echo "
                        <li><a href='register.php' class='reg'>Register</a></li>
                        <li><a href='login.php' class='log'>Login</a></li>
                        ";
                    }         
                    ?>

            </ul>

        </div>

    <h1 class="naslov">Add values </h1>


    <div class="vsebina">
    <form action="insert.php" method="POST" enctype="multipart/form-data">
        <div>
        <p class="contentp">Value:</p>
        <input class='inpt' type="number" min="0.01" step="0.01" name="vsota" placeholder="e.g. 20" required>
        </div>
        <div>
            <p class="contentp">Date and time:</p>
            <input class='inpt' type="date" name="date" required><br>
        </div>
        <div>
            <p class="contentp">Purchase description:</p>
            <textarea class='txtarea' name="desc" placeholder="e.g. Milk" ></textarea><br>
        </div>
        <div>
            <input type="file" class="stranpejt" name="picfile" id="picfile" accept=".jpeg, .jpg, .png" required><br>
            <label class="upload-label" for="picfile">Add receipt</label><br>
        </div>
        <div>
            <br>
            <button class="button" type="submit" name="submit">Upload</button><br>
        </div>
        <div>
        <?php
                    if(!empty($errors)){
                        foreach($errors as $error){
                            echo "<p class='error' style='color: white;'>" . $error . "</p>";

                        }
                   }

                   if(isset($_GET['success'])){

                    if($_GET['success'] == 1){
                        echo "<p>You have successfully uploaded your receipt!</p>";
                    }
    
                    else if($_GET['success'] == 0){
                        echo "<p>Oops! Something went wrong!</p>";
                    }
                }
            ?>   
        </div>
    </form>
    </div>

    <!-- Footer -->

    <div class="footer">

        <p class="footer_paragraph">Brina Jehart © 2019</p>

    </div>

</body>
</html>