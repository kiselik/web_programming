<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reminder</title>
    <base href="http://localhost/Reminder/"> <!-- корень сайта, определенный внутри этого файла -->
    <!-- Корень сайта - Start_Page.html-->
    <link rel="stylesheet" type="text/css" href="css/mainStyle.css">
</head>
<body>
<?php
session_start();
?>
<?php if (isset($_SESSION['user'])): ?>
    <?php
    echo "Привет, " . $_SESSION['user'] . "!";
    header('Location: New_Friends.php');
    ?>

<?php else: ?>
    <h1><a href="site/php/SignUp.php">Sign Up</a><br>
        <a href="site/php/LogIn.php">Log In</a></h1>
<?php endif; ?>
</body>
</html>






