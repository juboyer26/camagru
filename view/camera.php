<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: signin.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gallary</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .column {
            float: left;
            width: 33.33%;
            padding: 5px;
        }
    </style>
</head>

<body class="bgImg">
    <div class="topnavi" id="">
       <a href="gallery.php">
            <h3 style="margin:0; color:white">Camagru</h3>
        </a>
        <div style="float:right; padding: 5px">
            <a id="gall" href="gallery.php">Gallery</a>
            <a href="profile.php">Profile</a>
            <a href="" class="active">Camera</a>
            <a class="nav-link" href="../controller/logout.php">
                Logout
            </a>
        </div>
    </div>

    <br> <br> <br>
    <div class="container-fluid">
        <div class="row">
            <div class="column">
                <div class="booth">
                    <video autoplay="true" class="embed-responsive" id="videoElement" width="400" height="300"></video>
                </div>
                <div style="margin-left: 40%; margin-top: 10px">
                    <input type="submit" class="booth-capture-button" value="SnapShot" id="capture">
                </div>
            </div>

            <div class="column">
                <div class="row">
                    <div class="col">
                        <div class="booth">
                            <canvas name="image" id="canvas" width="400" height="300">Canvas Still Loading</canvas>
                        </div>
                    </div>
                </div>
                <div style="margin-left: 30%;margin-top: 10px">
                    <p style="color:black">No camera ? <a href="upload.php" style="color:black">upload instead</a></p>
                </div>
                <div style="margin-left: 45%; margin-top: 10px">
                        <input type="submit" class="booth-capture-button" value="save" id="save">
                </div>
            </div>

            <div class="column" style="margin-left:-100px;width: 400px;">
                <a href="#" id="pepe"><img id="test1" style="width: 15%;margin-bottom: 10%" src="../images/alpha/alphatest1.png"></a>
                <a href="#" id="troll"><img id="test3" style="width: 15%;margin-bottom: 10%" src="../images/alpha/alphatest3.png"></a>
                <a href="#" id="baby"> <img id="test2" style="width: 15%;margin-bottom:10%" src="../images/alpha/alphatest2.png"></a>
            </div>
        </div>

        <script type="text/javascript" src="../js/camera.js"></script>

        <div class="footer">
            <p> juboyer &copy camagru 2019 </p>
        </div>

    </div>


</body>

</html>