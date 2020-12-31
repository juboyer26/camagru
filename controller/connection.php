<?php
session_start();
$username = "";
$email = "";
$errors = [];
include '../view/constant.php';

$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

//SIGN UP USER

if (isset($_POST['signupbtn'])) {
    if (empty($_POST['username'])) {
        $error = '<p class="text-danger">Username is required</p>';
        echo '<script>alert("Username is required")</script>';
    }
    if (empty($_POST['email'])) {
        $error = '<p class="text-danger">Email is required</p>';
        echo '<script>alert("Email is required")</script>';
    }
    if (empty($_POST['password'])) {
        $error = '<p class="text-danger">Password is required or password not strong enough</p>';
        echo '<script>alert("Password is required")</script>';
    }
    if (isset($_POST['password']) && $_POST['psw-repeat'] !== $_POST['password']) {
        $error = '<p class="text-danger">Passwords dont Match </p>';
        echo '<script>alert("Passwords dont Match ")</script>';
    }
    $password = $_POST['password'];
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        $error = 'password should be 8 characters long, a number, lower and uppercase characters';
        echo '<script>alert("password should be 8 characters long, a number, lower and uppercase characters")</script>';
    } else {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $token = bin2hex(random_bytes(50)); // generate unique token
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //encrypt password
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email =? or username=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email, $username]);
        $user = $stmt->fetch();
        if ($user) {
            $error = '<p class="text-danger">email already exists</p>';
            echo '<script>alert("email / username already exists")</script>';
        } else {
            if (empty($error)) {
                $query = "INSERT INTO users (username, email, token, password) ValUES (:username, :email, :token, :password)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':password', $password);
                $stmt->execute();
                $msg = "Hi there, click on this <a href=\"http://127.0.0.1:8080" . WEBROOT . "controller/verify_account.php?token=" . $token . "\">link</a> to verify your email";

                $headers = "From: info@camagru.com";
                mail($email, "Verify your email", $msg, $headers);

                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                header('location: ../index.php');
            }
        }
    }
}


//Login user

if (isset($_POST['login-btn'])) {
    $_SESSION['message'] = "";
    if (empty($_POST['username'])) {
        $error = 'Username or email required';
        echo '<script>alert("Username required")</script>';
    }
    if (empty($_POST['password'])) {
        $error = 'Password required';
        echo '<script>alert("Password required")</script>';
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (count($errors) === 0) {
        $query = "SELECT * FROM users WHERE verification = 1 AND username=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if (!empty($user['username'])) {
            if (password_verify($password, $user['password'])) { // if password matches
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['verified'] = $user['verified'];
                $_SESSION['message'] = 'You are logged in!';
                $_SESSION['type'] = 'alert-success';
                header('location: ../view/gallery.php');
                exit(0);
            } else { // if password does not match
                $error = 'Wrong password';
                echo '<script>alert("Wrong password")</script>';
            }
        } else {
            echo '<script>alert("Username does not exist.")</script>';
            $error = 'no user by that username';
        }
    }
    $data = array(
        'error'  => $error
    );

    //echo json_encode($data);
}


//forgot password
if (isset($_POST['resetpswd'])) {
    if (empty($_POST['username'])) {
        $error['username'] = 'Username required';
    } else {
        //header("location: ../index.php");

        $info = $_POST['username'];

        if (count($errors) === 0) {
            $query = "SELECT * FROM users WHERE username=? OR email=? LIMIT 1";
            $stmt = $conn->prepare($query);

            if ($stmt->execute([$info, $info])) {
                $user = $stmt->fetch();
                $msg = "Hi there, click on this <a href=\"http://127.0.0.1:8080" . WEBROOT . "view/forgotpass.php?token=" . $user['token'] . "\">link</a> to reset your password on our site";
                $email = $user['email'];
                $headers = "From: info@camagru.com";
                mail($email, "Reset your password", $msg, $headers);

                //sett{}
                $_SESSION['message'] = "An email has been sent to you on how to reset password";
                header("location: ../view/signin.php");
            }
        }
    }
}
