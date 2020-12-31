<?php
//fetch_comment.php
$connect = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

if (isset($_GET['imageid']) && $_GET['imageid'] !== '') {
    $image_id = $_GET['imageid'];
    $query = "SELECT * FROM comment WHERE parent_comment_id = '0' ORDER BY comment_id DESC";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '';

    foreach ($result as $row) {
        if ($image_id === $row['imageid']) {
            $output .= '
 <div class="panel panel-default" style="background-color: white; margin-bottom: 2%">
  <div class="panel-heading" style="padding: 5px; background-color: lightgray">By <b><span style="color:brown">' . $row["comment_sender_name"] . '</sapn></b> on <i>' . $row["date"] . '</i></div>
  <div class="panel-body" style="padding: 5px;">' . $row["comment"] . '</div>
  
 </div>
 ';
        }
    }
    echo $output;
}
