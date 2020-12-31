<?php
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');
if (isset($_GET['imageid']) && isset($_GET['likefrom']) && !empty($_GET['likefrom'])) {

    $imageid = $_GET['imageid'];
    $likefrom = $_GET['likefrom'];
    $check = "SELECT * from likes where imageid=? AND likefrom=?";
    $stmt = $conn->prepare($check);
    $stmt->execute([$imageid, $likefrom]);
  

    if ($stmt->rowCount() > 0) {
        $liked = 1;
        header('Location: gallery.php');
        die();
    }
    if ($liked != 1) {
        $query = "INSERT INTO likes SET imageid=?, likefrom=?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$imageid, $likefrom]);
        $addlike = "UPDATE images set likes=likes + 1 where id=?";
        $stmt = $conn->prepare($addlike);
        $stmt->execute([$imageid]);
        header('Location: gallery.php');
        die();
    }
} else {
    header('Location: gallery.php');
    die();
}
