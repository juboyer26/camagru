<?php
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

$imageid = $_GET['imageid'];

$getUsername = "SELECT username FROM images WHERE id=?";
$stmt = $conn->prepare($getUsername);
$stmt->execute([$imageid]);
$sendTo = $stmt->fetch();
echo $user2 = $sendTo['username'];
$getemail = "SELECT email FROM users WHERE username=? AND notify=1";
$stmt = $conn->prepare($getemail);
$stmt->execute([$user2]);
$emailTo  = $stmt->fetch();
$msg = "Hi there,you have recieved a new comment";
$headers = "From: info@camagru.com";
mail($emailTo['email'], "Comment recieved", $msg, $headers);
