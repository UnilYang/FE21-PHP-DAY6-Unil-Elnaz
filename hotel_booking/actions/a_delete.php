<?php
session_start();

if (isset($_SESSION['user']) !="") {
    header("Location: ../login/home.php");
    exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../login/user_index.php");
    exit;
}

require_once "../components/db_connect.php";

if($_POST) {
    $id = $_POST['id']; // need to input as 'id' 
    $picture = $_POST['picture']; // need to input as 'picture' 
    ($picture == "room.png")?: unlink("../pictures/$picture"); // need to input as "room.png" &  "../pictures/$picture"
    
    $sql = "DELETE FROM hotel_booking WHERE room_id = $id";
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "Successfully Deleted!";
    } else {
        $class = "danger";
        $message = "The entry was not deleted due to: <br>".$connect->error;
    }
    mysqli_close($connect);
} else {
    header("location: ../error.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <?php require_once "../components/boot.php"?>
</head>
<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Delete Request Response</h1>
        </div>
        <div class="alerts alert-<?=$class;?>" role="alert">
            <p><?=($message);?></p> <!-- input ?($message) ??"";? -->
            <a href='../index.php'><button class="btn btn-success" type='button'>Home</button></a>
        </div>
    </div>
</body>
</html>