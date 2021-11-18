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

require_once "components/db_connect.php";

if($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM hotel_booking WHERE room_id = $id";
    $result = $connect->query($sql);
    $data = $result->fetch_assoc();
    if ($result->num_rows == 1) {
        $name = $data['room_name'];
        $type = $data['room_type'];
        $price = $data['room_price'];
        $picture = $data['room_picture'];
    } else {
        header("location: error.php");        
    }
    $connect->close();
} else {
    header("location: error.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BigLibrary-Delete Media</title>
    <?php require_once "components/boot.php"?>
    <style type= "text/css">
        .fieldset {
            margin: auto;
            margin-top: 100px;
            width: 70%;
        }
        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
    </style>
</head>
<body>
<div class='fieldset'>
        <h2 class='legend mb-3'>Delete Request<img class='img-thumbnail rounded-circle' src='pictures/<?php echo $picture ?>' alt="<?php echo $name ?>"></h2>
        <h5>You have selected the data below:</h5>
        <table class="table w-75 mt-3">
            <tr>
                <td><?php echo $name?></td>
            </tr>
        </table>

        <h3 class="mb-4">Do you really want to delete this product?</h3>
            <form action="actions/a_delete.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id ?>" />
                <input type="hidden" name="picture" value="<?php echo $picture ?>" />
                <button class="btn btn-danger" type="submit">Yes, delete it!</button>
                <a href="index.php"><button class="btn btn-warning" type="button">No, go back!</button></a>
            </form>
    </div>
</body>
</html>