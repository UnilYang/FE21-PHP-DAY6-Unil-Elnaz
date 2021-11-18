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
require_once "file_upload.php";

if($_POST) {
    $name = $_POST["room_name"];
    $type = $_POST["room_type"];
    $price = $_POST["room_price"];
    $hotelbrand = $_POST["hotelbrand"];
    $uploadError = ''; // input it after creating the file_upload
    $picture = file_upload($_FILES["room_picture"]); // input it after creating the file_upload

    if($hotelbrand == 'none'){
        $sql = "INSERT INTO hotel_booking (room_name, room_type, room_price, room_picture, fk_hotId) VALUES ('$name', '$type', $price, '$picture->fileName', null)";
    } else{
        $sql = "INSERT INTO hotel_booking (room_name, room_type, room_price, room_picture, fk_hotId) VALUES ('$name', '$type', $price, '$picture->fileName', $hotelbrand)";
    }

    if (mysqli_query($connect, $sql) === true) {
        $class = "success";
        $message = "The entry below was successfully created <br>
            <table class='table w-50'>
                <tr>
                    <td> $name </td>
                    <td> $type </td>
                    <td> $price </td>
                </tr>
            </table>
            <hr>";
        $uploadError = ($picture->error !=0)? $picture->ErrorMessage:""; // input it after creating the file_upload
            } else {
                $class = "danger";
                $message = "Error while creating record. Try again: <br>".$connect->error;
                $uploadError = ($picture->error !=0)? $picture->ErrorMessage:'';
            }
            mysqli_close($connect);
        } else {
            header("location: ../error.php"); // input ../error.php
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <?php require_once '../components/boot.php'?> <!-- input '../components/boot.php' -->
</head>
<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Create Request Response</h1>
        </div>
    </div>
    <div class="alert alert-<?=$class;?>" role="alert">
        <p><?php echo ($message) ?? "";?></p> <!-- input it after creating the file_upload & error -->
        <p><?php echo ($uploadError) ?? "";?></p> <!-- input it after creating the file_upload & error -->
        <a href='../index.php'><button class="btn btn-primary" type='button'>Home</button></a>
    </div> 
</body>
</html>