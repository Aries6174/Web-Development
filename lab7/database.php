<?php
$servername='localhost';
$username = 'username';
$password='';
$dbname = "accounts";
$mysqli = mysqli_connect($servername, $username, $password);

if (!$mysqli) {
    die('Could not connect: ' . mysqli_error());
}

// Check if the database exists
if (!mysqli_select_db($mysqli, $dbname)) {
    // Create the database if it doesn't exist
    $sql = "CREATE DATABASE $dbname";
    if (mysqli_query($mysqli, $sql)) {
        echo "Database created successfully\n";
    } else {
        echo "Error creating database: " . mysqli_error($mysqli) . "\n";
        die();
    }
}

mysqli_select_db($mysqli, $dbname);

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(40) NOT NULL,
    age INT(2) NOT NULL,
    class VARCHAR(40) NOT NULL,
    year INT(1) NOT NULL,
    email VARCHAR(40) NOT NULL,
    graduating TINYINT NOT NULL,
    avatar VARCHAR(60) NOT NULL,
    regdate TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)";

if (mysqli_query($mysqli, $sql)) {
    echo "Table created successfully\n";
} else {
    echo "Error creating table: " . mysqli_error($mysqli) . "\n";
    die();
}

?>
