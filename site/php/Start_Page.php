<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reminder</title>
    <base href="http://localhost/Reminder/"> <!-- корень сайта, определенный внутри этого файла -->
    <link rel="stylesheet" type="text/css" href="css/mainStyle.css">
    <!-- Корень сайта - Start_Page.html-->
</head>
<body>
<?php
session_start();
?>

<?php if (isset($_SESSION['user'])):?>
    Привет, <?php echo $_SESSION['user']; ?> !
    </h1><a href="site/php/LogOut.php">Log OUT</a></h1>
<?php else:?>
<h1><a href="site/php/SignUp.php">Sign Up</a><br>
    <a href="site/php/LogIn.php">Log In</a></h1>
<?php endif ;?>


</body>
</html>






