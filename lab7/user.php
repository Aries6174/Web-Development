<?php
session_start();

include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $user_id = $mysqli->real_escape_string($_GET['id']); // Escape and retrieve user ID
    $result = $mysqli->query("SELECT * FROM users WHERE id='$user_id'");
    if($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "User not found!";
        header("location: index.php");
        exit();
    }
} else {
    $_SESSION['message'] = "Invalid request!";
    header("location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="design.css" type="text/css">
    <title>User Information</title>
</head>
<body>
    <div class="body-content">
        <div class="module">
            <h1>User Information</h1>
            <!-- Display user information -->
            <div class="form">
			    <?php if(isset($row)): ?>
			        <!-- Display avatar -->
			        <img src="<?= $row['avatar'] ?>" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;"><br><br>
			        <!-- User details -->
			        <p>ID: <?= $row['id'] ?></p><br>
			        <p>Username: <?= $row['username'] ?></p><br>
			        <p>Age: <?= $row['age'] ?></p><br>
			        <p>Email: <?= $row['email'] ?></p><br>
			        <p>Year: <?= $row['year'] ?></p><br>
			        <p>Class: <?= $row['class'] ?></p><br>
			        <p>Graduating: <?= $row['graduating'] == 1 ? 'Yes' : 'No' ?></p><br><br>
			        <!-- Button to return to registration form -->
			        <form action="index.php" method="get">
			            <input type="submit" value="Return to Registration Form" class="btn btn-block btn-primary" />
			        </form>
			    <?php else: ?>
			        <p>User not found!</p>
			    <?php endif; ?>
			</div>
        </div>
    </div>
</body>
</html>
