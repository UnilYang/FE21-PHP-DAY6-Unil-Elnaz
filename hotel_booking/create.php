<?php
session_start();
require_once "actions/db_connect.php";

if (isset($_SESSION['user']) !="") {
    header("Location: login/home.php");
    exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: login/user_index.php");
    exit;
}

$hotelbrand = "";
$result = mysqli_query($connect, "SELECT * FROM hotelbrand");

while ($row = $result->fetch_array(MYSQLI_ASSOC)){
        $hotelbrand .=
        "<option value='{$row['hotId']}'>{$row['hot_Name']}</option>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once 'components/boot.php'?>  
    <title>Add Room</title>
    <style>
        .fieldset {
            margin: auto;
            margin-top: 100px;
            width: 60%;
        }
    </style>
</head>
<body>
        <div class="fieldset">
            <h2 class='legend'>Add Room</h2>
            <form action="actions/a_create.php" method="post" enctype="multipart/form-data">
                <table class='table'>
                    <tr>
                        <th>Room Name</th>
                        <td><input class='form-control' type="text" name="room_name" placeholder="Room Name"/></td>
                    </tr>
                    <tr>
                        <th>Room Type</th>
                            <td><input class='form-control' type="text" name="room_type" placeholder="Room Type"/>
                            </td>
                    </tr>
                    <tr>
                        <th>Room Price</th>
                            <td><input class='form-control' type="number" name="room_price" placeholder="Room Price"/>
                            </td>
                    </tr>
                    <tr>
                        <th>Room Picture</th>
                            <td><input class='form-control' type="file" name="room_picture" />
                            </td>
                    </tr>
                    <tr>
                        <th>Hotel Brand</th>
                            <td>
                                <select class='form-control' name="hotelbrand" aria-label="Default select example">
                                    <?php echo $hotelbrand;?>
                                    <option selected value='none'>Undefined</option>
                                </select>
                            </td>
                    </tr>
                    <tr>
                            <td><button class='btn btn-success' type="submit">Insert Room</button>
                            </td>
                            <td><a href="index.php"><button class='btn btn-warning' type="button">Home</button></a>
                            </td>
                    </tr>

            </form>       
        </div>
    
</body>
</html>