<?php
include 'database.php';

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
    $sql = "CREATE DATABASE camagru";
    // use exec() because no results are returned
    $conn->exec($sql);
} catch (PDOException $e) { }

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "CREATE TABLE users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(200) NOT NULL,
        email VARCHAR(250) NOT NULL,
        password VARCHAR(250) NOT NULL,
        token VARCHAR(255) DEFAULT NULL,
        verification int(6) DEFAULT 0,
        notify int(6) DEFAULT 1
        )";

    // use exec() because no results are returned
    $conn->exec($sql);  
} catch (PDOException $e) { }

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "CREATE TABLE images (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            imageName VARCHAR(255) NOT NULL,
            caption VARCHAR(255) NOT NULL,
            likes int(6) DEFAULT 0
            )";

    // use exec() because no results are returned
    $conn->exec($sql);
} catch (PDOException $e) { }

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "CREATE TABLE likes (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            imageid INT(30) NOT NULL,
            likefrom VARCHAR(255) NOT NULL
            )";

    // use exec() because no results are returned
    $conn->exec($sql);
} catch (PDOException $e) { }


try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "CREATE TABLE comment (
        comment_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        parent_comment_id int(11) NOT NULL,
        comment VARCHAR(250) NOT NULL,
        comment_sender_name VARCHAR(250) NOT NULL,
        date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        imageid int(11) NOT NULL
        )";

    // use exec() because no results are returned
    $conn->exec($sql);
} catch (PDOException $e) { }
    //$conn = null;
