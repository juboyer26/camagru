<?php
session_start();
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

if (isset($_GET['imageid'])) {

    $imageid = $_GET['imageid'];
    $sql = "SELECT imageName FROM images WHERE id=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$imageid]);
    $user = $stmt->fetch();
    
    $check = "DELETE from images where id=?";
    $stmt = $conn->prepare($check);
    $stmt->execute([$imageid]);

    if ($result = $stmt->execute([$imageid])) {
        // echo "<script>alert('image  has been deleted, redirecting you...')</script>";
        header('location: profile.php');
    }
}
