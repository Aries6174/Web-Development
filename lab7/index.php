<?php
session_start();
$_SESSION['message'] = ''; // Initialize an empty message variable in the session

include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check if the form has been submitted
    $name = $mysqli->real_escape_string($_POST['username']); // Escape and retrieve username from form
    $age = $mysqli->real_escape_string($_POST['age']); // Escape and retrieve age from form
    $email = $mysqli->real_escape_string($_POST['email']); // Escape and retrieve email from form
    $year = $mysqli->real_escape_string($_POST['year']); // Escape and retrieve year from form
    $class = $mysqli->real_escape_string($_POST['class']); // Escape and retrieve class from form
    $graduating = isset($_POST['graduating']) ? $mysqli->real_escape_string($_POST['graduating']) : '';

    // Define the path to store the avatar image
    $avatar_directory = 'Images/'; // This directory should exist
    $avatar_path = $avatar_directory . $_FILES['avatar']['name'];

    if(preg_match("!image!", $_FILES['avatar']['type'])){
        if(copy($_FILES['avatar']['tmp_name'], $avatar_path)){
            $_SESSION['name'] = $name; // Store username in session
            $_SESSION['avatar'] = $avatar_path; // Store avatar path in session

            // Construct SQL query to insert user data into database
            $sql = "INSERT INTO users (username, age, class, year, email, graduating, avatar) " . 
                   "VALUES ('$name','$age','$class','$year','$email','$graduating','$avatar_path')";

            // Execute SQL query and handle success/failure
            if ($mysqli->query($sql) === true){
                $_SESSION['message'] = "Registration Successful! Added $name to the database!";
                header("location: welcome.php"); // Redirect to welcome page
                exit();
            } else {
                $_SESSION['message'] = "User could not be added to the database!";
            }
        } else {
            $_SESSION['message'] = "Error uploading avatar!";
        }
    } else {
        $_SESSION['message'] = "Please only upload GIF, JPG, or PNG Images!";
    }

    if(isset($_POST['view'])) {
        $search_key = $mysqli->real_escape_string($_POST['search_key']); // Escape and retrieve search key
        $result = $mysqli->query("SELECT * FROM users WHERE id='$search_key' OR username='$search_key'");
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            header("location: user.php?id=" . urlencode($row['id']));
            exit();
        } else {
            $_SESSION['message'] = "User not found!";
            header("location: index.php");
            exit();
        }
    }

    if(isset($_POST['update'])) {
        $search_key = $mysqli->real_escape_string($_POST['search_key']); // Escape and retrieve search key
        $result = $mysqli->query("SELECT * FROM users WHERE id='$search_key' OR username='$search_key'");
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            header("location: update.php?id=" . urlencode($row['id'])); // Redirect to update.php with user ID
            exit();
        } else {
            $_SESSION['message'] = "User not found!";
            header("location: index.php");
            exit();
        }
    }

    if(isset($_POST['remove'])) {
        try {
            // Check if $_POST['search_key'] is set
            if(isset($_POST['search_key'])) {
                $search_key = $mysqli->real_escape_string($_POST['search_key']); // Escape and retrieve search key
                $result = $mysqli->query("DELETE FROM users WHERE username='$search_key' OR id='$search_key'");
                if($result) {
                    $_SESSION['message'] = "User removed successfully!";
                    header("location: index.php");
                    exit();
                } else {
                    $_SESSION['message'] = "Failed to remove user!";
                }
            }
        } catch (Exception $e) {
            // If an exception occurs, print nothing (or handle the error in a different way)
        }
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="design.css" type="text/css">
    <title>Registration Form</title>
</head>
<body>
    <div class="body-content">
        <div class="module">
            <h1>Registration Form</h1>
            <!-- Display message if any -->
            <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
            <!-- Registration form -->
            <form class="form" action="" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="text" placeholder="Name" name="username" required />
                <input type="number" placeholder="Age" name="age" required />
                <input type="email" placeholder="Email" name="email" required />
                <input type="number" placeholder="Year Level" name="year" required />
                <input type="text" placeholder="Course" name="class" required /> <!-- Added course input field -->
                <h3>Graduating? </h3>
                <input type="checkbox" value="1" name="graduating" />
                <div class="avatar"><label>Select your avatar: </label><input type="file" name="avatar" accept="image/*" required /></div>
                <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" /> <br><br><br>
            </form>
            <hr>
            <h1>Search or Edit a User </h1>
            <!-- Add search and action buttons -->
            <form class="form" action="" method="post">
                <input type="text" placeholder="Enter Username or ID" name="search_key" required /><br>
                <input type="submit" value="View" name="view" class="btn btn-block btn-primary" /><br>
                <input type="submit" value="Update" name="update" class="btn btn-block btn-primary" /><br>
                <input type="submit" value="Remove" name="remove" class="btn btn-block btn-primary" /><br>
            </form>
        </div>
    </div>
</body>
</html>