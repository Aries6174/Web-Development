<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="design.css"> 
    <title>Welcome</title>
    <style>
        .user img {
            width: 100px;
            height: 100px; 
            border-radius: 50%; 
        }
    </style>
</head>
<body>
    <div class="body content">
        <div class="welcome">
            <!-- Display message if any -->
            <div class="alert alert-success"><?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?></div>
            <!-- Display user avatar -->
            <?php if(isset($_SESSION['avatar'])): ?>
                <span class="user"><img src="<?= $_SESSION['avatar'] ?>" alt="User Avatar" /></span>
            <?php endif; ?>
            <!-- Display welcome message with username -->
            <?php if(isset($_SESSION['name'])): ?>
                Welcome <span class="user"><?= $_SESSION['name'] ?></span>.
            <?php endif; ?>

            <!-- Add a button to go back to the registration form -->
            <form action="index.php" method="get">
                <input type="submit" value="Go Back" class="btn btn-block btn-primary" />
            </form>
        </div>
    </div>
</body>
</html>
