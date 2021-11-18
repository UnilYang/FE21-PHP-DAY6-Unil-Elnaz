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
    $name = $_POST['room_name'];
    $type = $_POST['room_type'];
    $price = $_POST['room_price'];
    $hotelbrand = $_POST['hotelbrand'];
    $id = $_POST['room_id'];
    $uploadError = "";
    // remove the data with unlink function
    $picture = file_upload($_FILES["room_picture"]);
    if($picture->error === 0) {
        ($_POST["room_picture"] == "room.png")?: unlink("../pictures/$_POST[room_picture]");
        $sql = "UPDATE hotel_booking SET room_name='$name', room_type='$type', room_price='$price', room_picture='$picture->fileName', fk_hotId = $hotelbrand WHERE room_id = $id";
        } else {
            $sql = "UPDATE hotel_booking SET room_name='$name',room_type='$type',room_price='$price', fk_hotId = $hotelbrand WHERE room_id = $id";
        }
        if (mysqli_query($connect, $sql) === TRUE) {
            $class = "success";
            $message = "The record was successfully updated";
            $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
        } else {
            $class = "danger";
            $message = "Error while updating record : <br>".mysqli_connect_error();
            $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
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
    <title>Update</title>
    <?php require_once "../components/boot.php"?>
</head>
<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Update request response</h1>
        </div>
        <div class="alerts alert-<?php echo $class;?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../update.php?id=<?=$id;?>'><button class="btn btn-warning" type='button'>Back</button></a>
            <a href='../index.php?id=<?=$id;?>'><button class="btn btn-success" type='button'>Home</button></a>
        </div>
    </div>
</body>
</html>