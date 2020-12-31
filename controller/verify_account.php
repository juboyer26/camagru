<?php
session_start();

include '../config/database.php';

$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = "SELECT * FROM users WHERE token=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    if ($user) {
        $query = "UPDATE users SET verification=1 WHERE token=?";
        $stmt = $conn->prepare($query);
        if ($stmt->execute([$token])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = true;
            $_SESSION['message'] = "Your email address has been verified successfully";
            $_SESSION['type'] = 'alert-success';
            header('location: ../view/gallery.php');
            exit(0);
        }
    } else {
        echo "User not found!";
    }
} else {
    echo "No token provided!";
}
