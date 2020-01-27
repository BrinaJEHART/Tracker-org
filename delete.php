
<?php

require 'db.php';

session_start();

$commentID = $mysqli->escape_string($_GET['id']);  
$admin = $_SESSION['admin'];
$result = $mysqli->query("SELECT * FROM komentarji WHERE id='$commentID'");
$comments = $result->fetch_assoc();

if((isset($_SESSION['user_id']) && $comments['user_id'] == $_SESSION['user_id']) || (isset($_SESSION['admin']) && $_SESSION['admin']))
{
    $sql = "DELETE FROM komentarji WHERE id='$commentID'";
    if($mysqli->query($sql)){
        echo "Your comment was successfully deleted.";
        header ("location:table.php");
    }
    else{
        echo "Oops! Something went wrong.";
        header ("location:table.php");
    }
}
else{
    header ("location:table.php");
}

?>