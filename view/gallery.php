<?php
session_start();
$username = !empty($_SESSION['username']);
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

$next = 0;
$prev = 0;
$images_per_page = 3;
$results = "SELECT * FROM images";
$stmt = $conn->prepare($results);
$stmt->execute();
$number_of_images = $stmt->rowCount();
// $page = 1;

$number_of_pages = ceil($number_of_images / $images_per_page);

if (isset($_GET['page'])) {
    $page = intval($_GET['page']);
    $next = $page + 1;
    $prev = $page - 1;
    if ($page > $number_of_pages) {
        $page = $number_of_pages;
    } elseif ($page < 1) {
        $page = 1;
    }
} else {
    $page = 1;
}
$start_limit = ($page - 1) * $images_per_page;
$results = "SELECT * FROM images";
$stmt = $conn->prepare($results);
$stmt->execute();

$results = $conn->prepare("SELECT * FROM images ORDER BY id DESC LIMIT " . $start_limit . ',' . $images_per_page);
$results->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gallery</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .pagination {
            display: inline-flex;
            padding-left: 11px;
            /* margin: 20px 0; */
            border-radius: 4px;

        }

        .column {
            float: left;
            width: 33.33%;
            padding: 5px;
        }
    </style>
</head>

<body class="bgImg">
    <div class="topnavi" id="">
        <a href="gallery.php">
            <h3 style="margin:0; color:white">Camagru</h3>
        </a>
        <div style="float:right; padding: 5px">
            <a href="#" class="active">Gallery</a>
            <a href="profile.php">Profile</a>
            <a href="camera.php">Camera</a>
            <?php if (isset($_SESSION['username'])) { ?>
                <a class="" href="../controller/logout.php">
                    Logout
                </a>
            <?php } else { ?>
                <a class="" href="signin.php">
                    Login
                </a>
            <?php } ?>
        </div>
    </div>

    <br>
    <!-- gallary begins -->

    <div class="container" style="margin-top: 10%;">
        <div class="row" style="margin-bottom: 10%;">
            <?php foreach ($results as $result) : $imageid = $result['id'] ?>
                <div class="col-lg-4 col-sm-6" style="margin-bottom: 10px; ">
                    <div style="background:white; padding:10px">
                        <p style="color:black"><?php echo $result['username'] ?></p>
                        <div>
                            <a href="photo.php?imageid=<?php echo $result['id'] ?>"><img class="thumbnail" src="../images/<?php echo $result['imageName'] ?>" width="100%" height="250px" /></a>
                        </div>
                        <?php
                        $stmt = $conn->prepare("SELECT * from images WHERE id=?");
                        $stmt->execute([$imageid]);
                        $data =  $stmt->fetch();
                        ?>
                        <div>
                            <?php if ($data['likes'] === 1) { ?>
                                <p class="likes"><?php echo $data['likes'] ?> like </p>
                            <?php } else { ?>
                                <p class="likes"><?php echo $data['likes'] ?> likes </p>
                            <?php } ?>
                            <!-- <p> <?php echo $result['caption'] ?> </p> -->
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM likes WHERE imageid=? AND likefrom=?");
                            $stmt->execute([$imageid, $username]);
                            $likes =  $stmt->fetch();
                            ?>
                        </div>
                        <div>
                            <?php if ($stmt->rowCount() > 0) { ?>
                                <a href="unlike.php?imageid=<?php echo $result['id'] ?>&likefrom=<?php echo $username ?>" class="action-icons"><i style="color: red" class="fa fa-heart"></i></a>
                            <?php } else { ?>
                                <a href="likes.php?imageid=<?php echo $result['id'] ?>&likefrom=<?php echo $username ?>" class="action-icons"><i class="fa fa-heart-o"></i></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row">
            <div class="pagination">
                <?php
                if ($page == 1 && $number_of_pages != 1) {
                    $next = $page + 1;
                    echo '<a href="gallery.php?page=' . $next . '">' . '<img src="../images/alpha/next.png">' . '</a> ';
                } else if ($page == $number_of_pages && $page > 1) {
                    echo '<a href="gallery.php?page=' . $prev . '">' . '<img src="../images/alpha/prev.png">' . '</a> ';
                } 
                if($page < $number_of_pages && $page > 1) {
                    echo '<a href="gallery.php?page=' . $prev . '">' . '<img src="../images/alpha/prev.png">' . '</a> ';
                    echo '<a href="gallery.php?page=' . $next . '">' . '<img src="../images/alpha/next.png">' . '</a> ';
                }
                ?>
            </div>
        </div>
        <div class="footer">
            juboyer &copy camagru 2019
        </div>
    </div>



</body>

</html>