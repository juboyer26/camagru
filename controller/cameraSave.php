<?php
session_start();
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');
$img = $_POST['img'];
$username = $_SESSION['username'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$data1 = uniqid('', true) . ".png";

//rename($data, $data1);
$dest = "../images/" . $data1;
$caption = ".";

file_put_contents($dest, $data);
$sql = "INSERT INTO images (username, imageName, caption) VALUES (?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$username, $data1, $caption]);
