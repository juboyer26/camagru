<?php
session_start();

$errors = [];

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: signin.php');
}
$info = $_SESSION['username'];
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

if (isset($_POST['editbtn'])) {
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username required';
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'email required';
    }
    if (empty($_POST['checkbox'])) {
        $notify = "0";
    } else {
        $notify = "1";
    }
    $username = $_POST['username'];
    $email = $_POST['email'];
    $sql = "SELECT * FROM users WHERE email =? or username=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email, $username]);
    $user = $stmt->fetch();
    if ($stmt->rowCount() == 1) {

        if (count($errors) === 0) {
            $query = "UPDATE users SET username=?, email=?, notify=? WHERE username=?";
            $stmt = $conn->prepare($query);

            if ($stmt->execute([$username, $email, $notify, $info])) {
                $query = "UPDATE images SET username=? WHERE username=?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$username, $info]);
                include '../controller/logout.php';
            } else {
                $_SESSION['message'] = "Update failed!";
                $_SESSION['type'] = "alert-danger";
            }
        }
    }
}

$sql = "SELECT * FROM users WHERE username=? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute([$info]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile Update</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="bgImg">
    <div class="topnavi">
        <a href="gallery.php">
            <h3 style="margin:0; color:white">Camagru</h3>
        </a>
        <div style="float:right">
            <a href="gallery.php">Gallery</a>
            <a href="profile.php" class="active">Profile</a>
            <a href="camera.php">Camera</a>
            <a class="nav-link" href="../controller/logout.php">
                Logout
            </a>
        </div>
    </div>

    </div>
    <br><br><br>

    <form method="post">
        <h2 style="color:white">Edit Profile</h2>
        <div class="input-group">
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
        </div>
        <div class="input-group">
            <input type="text" placeholder="Enter Email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="input-group">
            <a href="passwordUD.php" class="" role="button" aria-pressed="true" style="color:black">Change password</a>
        </div>
        <div class="input-group" style="color:black">
           <input type="checkbox" name="checkbox" <?php if ($user['notify'] != 0) {
                                                        echo "checked";
                                                    } ?>>Receive notfications</input>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="editbtn">Submit</button>
        </div>

    </form>
    <div class="footer">
        <p>juboyer &copy camagru 2019 </p>
    </div>
</body>

</html>