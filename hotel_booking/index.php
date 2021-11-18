<?php
session_start();
require_once "actions/db_connect.php";

// if (isset($_SESSION['user']) !="") {
//     header("Location: login/home.php");
//     exit;
// }
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: login/user_index.php");
    exit;
}

$sql ="SELECT * 
FROM hotel_booking
JOIN hotelbrand on hotelbrand.hotId = hotel_booking.fk_hotId";
$result = mysqli_query($connect,$sql);
$tbody="";

// CF CTO Solution ===>>>

$class= "hide";
if(isset($_SESSION["adm"])){
  $class="show";
}

// <<<===

// $editbtn = "hide";
// $deletebtn = "hide";
// $addbtn = "hide";
// if(isset($_SESSION["adm"])){
//     $editbtn = "show";
//     $deletebtn = "show";
//     $addbtn = "show";
// }


if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
      //bootstrap copy from HTML

      // Sayuri Solution ===>>>
        // if(isset($_SESSION['adm'])){
        // $button = '<a href="update.php?id=' .$row['id'].'"><button class="btn btn-primary btn-sm m-2" type="button">Edit</button></a><a href="delete.php?id=' .$row['id'].'"><button class="btn btn-danger btn-sm m-2" type="button">Delete</button></a>';

        // $button2 = '  <a href="create.php"><button class="btn btn-danger"type="button">Add product</button></a>';
        // } else {
        //   $button = '<a href=".php?id=' .$row['id'].'"><button class="btn btn-primary btn-sm m-2" type="button">Order</button></a>';
        // }
      // <<<===


       $tbody .= "<tr>
                <td><img class='img-thumbnail' src='pictures/".$row['room_picture']."'</td>
                <td>".$row['hot_Name']."</td>
                <td>".$row['room_name']."</td>
                <td>".$row['room_type']."</td>
                <td>".$row['room_price']."</td>
                <td class= ".$class."><a href='update.php?id=".$row['room_id']."'><button class='btn btn-warning btn-sm ".$class."' type='button'>Edit</button></a>
                <a href='delete.php?id= ".$row['room_id']."'><button class='btn btn-danger btn-sm ".$class."'type='button'>Delete</button></a>
                <a href='create.php'><button class='btn btn-primary btn-sm ".$class."' type='button'>Add Room</button></a>
                </td>
                </tr>";
    };
} else {
    $tbody = "<tr><td colspan='5'><center>No Data Available</center></td></tr>";
}
mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    <?php require_once "components/boot.php"?>
    <style type="text/css">
        .manageRoom {
            margin: auto;
        }
        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
        .hide {
          display: none; /* $user $admin -> hidden */
        }
        .show {
          display: block; /* $user $admin -> visible */
        }
        td {
            text-align: center;
            vertical-align: middle;
        }
        tr {
            text-align: center;
        }
        a{
            text-decoration: none;
        }
        </style>
</head>
<body>
    <div class="manageRoom w-75 mt-3">
        <div class='mb-3'>
            <a href="login/logout.php?logout"><button class="btn btn-danger" type="button">Sign Out</button></a>
            </div>
            <p class='h2'>Rooms</p>
                <table class='table table-striped'>
                    <thead class='table-primary'>
                        <tr>
                            <th>Picture</th>
                            <th>Hotel Name</th>
                            <th>Room Name</th>
                            <th>Type</th>
                            <th>Price(€)/night</th>
                            <th class="<?php echo $class;?>">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?=$tbody;?>
                    </tbody>
                </table>
            </div>                      
</body>
</html>