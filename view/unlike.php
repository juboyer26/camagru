<?php
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

if (isset($_GET['imageid']) && isset($_GET['likefrom'])) {

    $imageid = $_GET['imageid'];
    $likefrom = $_GET['likefrom'];
    $check = "SELECT * from likes where imageid=? AND likefrom=?";
    $stmt = $conn->prepare($check);
    $stmt->execute([$imageid, $likefrom]);
    if ($stmt->rowCount() > 0) {
        $query = "DELETE from likes where imageid=? AND likefrom=?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$imageid, $likefrom]);
        $unlike = "UPDATE images set likes=likes - 1 where id=?";
        $stmt = $conn->prepare($unlike);
        $stmt->execute([$imageid]);
        header('Location: gallery.php');
        die();
    }
}
