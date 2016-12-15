<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reminder</title>
    <base href="http://localhost/Reminder/"> <!-- корень сайта, определенный внутри этого файла -->
    <!-- Корень сайта - Start_Page.html-->
    <link rel="stylesheet" type="text/css" href="css/mainStyle.css">
</head>
<?php
session_start();
unset($_SESSION['user']);
header('Location: Start_Page.php');
?>
</body>
</html>



