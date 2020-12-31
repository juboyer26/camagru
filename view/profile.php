<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: signin.php');
}
$username = $_SESSION['username'];

$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');
$stmt = $conn->prepare("SELECT * FROM images where username=? ");
$stmt->execute([$username]);
$results = $stmt->fetchAll();
$post = $stmt->rowCount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        :root {
            font-size: 10px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }
    </style>
</head>

<body class="bgImg">
    <div class="topnavi" id="">
         <a href="gallery.php">
            <h3 style="margin:0; color:white">Camagru</h3>
        </a>
        <div style="float:right; padding: 5px">
            <a href="gallery.php">Gallery</a>
            <a href="#" class="active">Profile</a>
            <a href="camera.php">Camera</a>
            <a class="nav-link" href="../controller/logout.php">
                Logout
            </a>
        </div>
    </div>

    <br>
    <header>
        <div class="container">
            <div class="profile">
                <div class="profile-user-settings">
                    <h1 class="profile-user-name"><?php echo $_SESSION['username']; ?></h1>
                    <a href="profileUpdate.php" class="" role="button"> <button class="btn profile-edit-btn">Edit Profile</button></a>
                </div>
                <div class="profile-stats">
                    <ul>
                        <li style="color: white"><span class="profile-stat-count"><?php echo  $post; ?></span> Pictures posted</li>

                    </ul>
                </div>
            </div>
            <!-- End of profile section -->
        </div>
        <!-- End of container -->
    </header>


    <main>
        <div class="container">
            <div class="gallery">
                <?php foreach ($results as $result) : $imageid = $result['id'] ?>
                    <div>
                        <a href="photo.php?imageid=<?php echo $imageid; ?>">
                            <div class=" gallery-item" tabindex="0">

                                <?php
                                $sql = "SELECT * from images WHERE id=?";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute([$imageid]);
                                $data = $stmt->fetch();
                                ?>
                                <img src="../images/<?php echo $result['imageName'] ?>" class="gallery-image" />
                                <div class="gallery-item-info">
                                    <ul>
                                        <li class="gallery-item-likes"><span class="visually-hidden"></span><i class="fa fa-heart" aria-hidden="true"></i> <?php echo $data['likes']; ?></li>
                                        <?php
                                        $sql = "SELECT * from comment WHERE imageid=?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute([$imageid]);
                                        $comments = $stmt->rowCount();
                                        ?>
                                        <li class="gallery-item-comments"><span class="visually-hidden"></span><i class="fa fa-comment" aria-hidden="true"></i> <?php echo $comments; ?></li>

                                    </ul>

                                </div>

                            </div>
                        </a>
                        <a class="btn profile-edit-btn" style="border-radius: 0; margin-left:0; background-color: red" href="deleteImage.php?imageid=<?php echo $imageid; ?>">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </div>

                <?php endforeach; ?>
            </div>
            <!-- End of gallery -->
        </div>
        <!-- End of container -->
    </main>

    <div class="footer">
        <p> juboyer &copy camagru 2019 </p>
    </div>


</body>

</html>