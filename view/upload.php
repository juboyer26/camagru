<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: signin.php');
}
include 'constant.php';
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{
    // function patch for respecting alpha work find on http://php.net/manual/en/function.imagecopymerge.php
    $cut = imagecreatetruecolor($src_w, $src_h);
    imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
}

if (isset($_FILES['image']) && isset($_POST['alpha'])) {
    $image = $_FILES['image'];
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    if (in_array($extension, array('jpg', 'png', 'jpeg'))) {
        $username = $_SESSION['username'];
        $num = rand(10, 10000);
        $image_name = $num . '_' . $username . '.' . $extension;
        move_uploaded_file($image['tmp_name'], IMAGES . '/' . $image_name);
        if ($extension == 'jpg')
            $im = imagecreatefromjpeg(IMAGES . '/' . $image_name);
        else if ($extension == 'png')
            $im = imagecreatefrompng(IMAGES . '/' . $image_name);
        else if ($extension == 'jpeg')
            $im = imagecreatefromjpeg(IMAGES . '/' . $image_name);
        $alpha = imagecreatefrompng(IMAGES . '/' . 'alpha/' . $_POST['alpha'] . '.png');
        imagecopyresized($im, $alpha, 0, 0, 0, 0, 100, 100,  imagesx($alpha), imagesy($alpha));
        imagepng($im,  IMAGES . '/' . $image_name);
        imagedestroy($im);
        $image = $image_name;
        $sql = "INSERT INTO images (username, imageName) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $image]);
        header('location: gallery.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body class="bgImg">
    <div class="topnavi" id="myTopnav">
        <a href="gallery.php">
            <h3 style="margin:0; color:white">Camagru</h3>
        </a>
        <div style="float:right">
            <a href="gallery.php">Gallery</a>
            <a href="camera.php" class="active">Camera</a>
            <a class="nav-link" href="../controller/logout.php">
                Logout
            </a>
        </div>
    </div>
    <div class="container">
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="radio" style="background-color:lightgray; padding:40px">
                <div>
                    <label class="radio-inline"><input type="hidden" name="alpha" value="alphatest4" checked="checked"></label>
                    <label class="radio-inline"><img style="width: 100px;" src="<?php echo WEBROOT; ?>images/alpha/alphatest1.png"><input type="radio" name="alpha" value="alphatest1"></label>
                    <label class="radio-inline"><img style="width: 100px;" src="<?php echo WEBROOT; ?>images/alpha/alphatest2.png"><input type="radio" name="alpha" value="alphatest2"></label>
                    <label class="radio-inline"><img style="width: 100px;" src="<?php echo WEBROOT; ?>images/alpha/alphatest3.png"><input type="radio" name="alpha" value="alphatest3"></label>
                    <div>
                        <input class="booth-capture-button" type="file" name="image">
                    </div>

                    <div>
                        <input id="cpt_1" type="hidden" name="cpt_1">
                    </div>
                    <br>
                    <button class="booth-capture-button" id="submit" type="submit">POST</button>
                </div>
            </div>


        </form>


        <div class="footer">
            <p>juboyer &copy camagru 2019 </p>
        </div>
    </div>
</body>

</html>