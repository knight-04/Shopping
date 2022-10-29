<?php 
    session_start();
    include('server.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="header">
        <h2>Admin</h2>
    </div>
    <form action="admin_db.php" method="post">
        
        <?php if(isset($_SESSION['error'])) : ?>
            <div class="error">  
                <h3>
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
      
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <button type="submit" name="admin_user" class="btn">Login</button>
        </div>
        <p>I am not Admin <a href="register.php">Sign Up</a></p>
        
    </form>

</body>
</html>
