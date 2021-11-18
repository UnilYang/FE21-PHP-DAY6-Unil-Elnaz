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

if($_GET['id']) { // input 'id' not 'room_id'
    $id = $_GET['id']; // input 'id' not 'room_id'
    $sql = "SELECT * FROM hotel_booking WHERE room_id = $id";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $name = $data['room_name'];
        $type = $data['room_type'];
        $price = $data['room_price'];
        $picture = $data['room_picture'];
        $hotelbrand = $data['fk_hotId'];

        $resultHot = mysqli_query($connect, "SELECT * FROM hotelbrand");
        $hotList = "";
        if(mysqli_num_rows($resultHot) > 0){
            while ($row = $resultHot->fetch_array(MYSQLI_ASSOC)){
                if($row['hotId'] == $hotelbrand){
                    $hotList .= "<option selectd value='{$row['hotId']}'>{$row['hot_Name']}</option>";
                }else{
                    $hotList .= "<option value='{$row['hotId']}'>{$row['hot_Name']}</option>";
                }}
            }else{
                $hotList = "<li>There are no hotel brands registered</li>";
            }
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
    <title>BigLibrary-Edit Media</title>
    <?php require_once "components/boot.php"?>
    <style type= "text/css">
        .fieldset {
            margin: auto;
            margin-top: 100px;
            width: 60%;
        }
        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
    </style>
</head>
<body>
    <div class='fieldset'>
        <h2 class='legend'>Update Request<img class='img-thumbnail rounded-circle' src='pictures/<?php echo $picture ?>' alt="<?php echo $name ?>"></h2>
        <form action="actions/a_update.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>Room Name</th>
                    <td><input class="form-control" type="text" name="room_name" placeholder="Room Name" value="<?php echo $name ?>"/></td>
                </tr>
                <tr>
                    <th>Room Type</th>
                    <td><input class="form-control" type="text" name="room_type" placeholder="Room Type" value="<?php echo $type ?>"/></td>
                </tr>
                <tr>
                    <th>Room Price</th>
                    <td><input class="form-control" type="number" name="room_price" step="any" placeholder="Room Price" value="<?php echo $price ?>"/></td>
                </tr>
                <tr>
                    <th>Room Picture</th>
                    <td><input class="form-control" type="file" name="room_picture" /></td>
                </tr>
                <tr>
                    <th>Hotel Brand</th>
                    <td>
                        <select class="form-select" name="hotelbrand" aria-label="Default select example">
                            <?php echo $hotList;?>
                        </select>
                        </td>
                </tr>
                <tr>
                    <input type="hidden" name="room_id" value="<?php echo $data['room_id'] ?>" />
                    <input type="hidden" name="room_picture" value= "<?php echo $data['room_picture'] ?>" />
                    <td><button class="btn btn-success" type="submit">Save Change</button></td>
                    <td><a href="index.php"><button class="btn btn-warning" type="button">Back</button></a></td>
                </tr>
            </table>
        </form>
    </div> 
</body>
</html>