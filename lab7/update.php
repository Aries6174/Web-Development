<?php
include 'database.php';
session_start(); // Start the session

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $username = $_POST['username'];
    $age = $_POST['age'];
    $class = $_POST['class'];
    $year = $_POST['year'];
    $graduating = isset($_POST['graduating']) ? $_POST['graduating'] : 0;
    $email = $_POST['email']; // Retrieve email from form

    // Handle file upload for avatar
    $avatar = '';
    if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $avatar_temp = $_FILES['avatar']['tmp_name'];
        $avatar_path = 'Images/' . basename($_FILES['avatar']['name']);
        if(move_uploaded_file($avatar_temp, $avatar_path)) {
            $avatar = $avatar_path;
        }
    }

    // Update the user record in the database
    $sql = "UPDATE users SET username='$username', age='$age', class='$class', year='$year', graduating='$graduating', email='$email'";
    if(!empty($avatar)) {
        $sql .= ", avatar='$avatar'";
    }
    $sql .= " WHERE id=$id";
    
    if(mysqli_query($mysqli, $sql)){
        $_SESSION['message'] = "Record updated successfully!";
        header("location: index.php"); // Redirect to index.php
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($mysqli);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="design.css"> <!-- Link your design.css file -->
</head>
<body>
<div class="module">
    <h1 >Update User</h1>
    <?php
    // Retrieve user data from the database based on the ID passed in the URL
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $result = mysqli_query($mysqli, "SELECT * FROM users WHERE id=$id");

        // Display the user data in a form for updating
        while($row = mysqli_fetch_array($result)){
            ?>
            <form method="post" action="update.php" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>"><br>
                Username: <input type="text" name="username" value="<?php echo $row['username']; ?>"><br><br>
                Age: <input type="text" name="age" value="<?php echo $row['age']; ?>"><br><br>
                Course: <input type="text" name="class" value="<?php echo $row['class']; ?>"><br><br>
                Year Level: <input type="text" name="year" value="<?php echo $row['year']; ?>"><br><br>
                Graduating: <input type="checkbox" name="graduating" value="1" <?php if($row['graduating'] == 1) echo 'checked'; ?>><br><br>
                Email: <input type="email" name="email" value="<?php echo $row['email']; ?>"><br><br><!-- Add email input -->
                Avatar: <input type="file" name="avatar"><br><br><!-- Add avatar input -->
                <input type="submit" name="update" value="Update"><br>
            </form>
            <form action="index.php">
                <input type="submit" value="Return to Index">
            </form>
            <?php
        }
    }
    ?>
</div>
</body>
</html>

