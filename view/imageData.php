<?php
session_start();
include 'constant.php';
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{
    // function patch for respecting alpha work find on http://php.net/manual/fr/function.imagecopymerge.php
    $cut = imagecreatetruecolor($src_w, $src_h);
    imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
}

if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = md5(time() + rand());
}
function csrf()
{
    return 'csrf=' . $_SESSION['csrf'];
}
function csrfInput()
{
    return '<input type="hidden" value="' . $_SESSION['csrf'] . '" name="csrf"/>';
}
function checkCsrf()
{
    if((isset($_POST['csrf']) || $_POST['csrf'] != $_SESSION['csrf']) || (isset($_GET['csrf']) || $_GET['csrf'] != $_SESSION['csrf'])) {
        return true;
    }
    header('Location:' . WEBROOT . 'csrf.php');
    die();
}
if (isset($_FILES['myimage']) && isset($_POST['alpha'])) {
    $image = $_FILES['myimage'];
    $caption = $_POST['caption'];
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    if (in_array($extension, array('jpg', 'png'))) {
        $username = $_SESSION['username'];
        $num = rand(10, 10000);
        $image_name = $num . '_' . $username . '.' . $extension;
        move_uploaded_file($image['tmp_name'], IMAGES . '/' . $image_name);
        if ($extension == 'jpg')
            $im = imagecreatefromjpeg(IMAGES . '/' . $image_name);
        else if ($extension == 'png')
            $im = imagecreatefrompng(IMAGES . '/' . $image_name);
        $alpha = imagecreatefrompng("../images/" . 'alpha/' . $_POST['alpha'] . '.png');
        imagecopymerge_alpha($im, $alpha, 0, 0, 0, 0, imagesx($alpha), imagesy($alpha), 100);
        imagepng($im,  IMAGES . '/' . $image_name);
        imagedestroy($im);
        $image = $image_name;
        $sql = "INSERT INTO images (username, imageName, caption) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $image, $caption]);
        header('location: upload.php');
    }
}
