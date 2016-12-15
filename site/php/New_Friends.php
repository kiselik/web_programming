<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reminder</title>
    <base href="http://localhost/Reminder/"> <!-- корень сайта, определенный внутри этого файла -->
    <!-- Корень сайта - Start_Page.html-->
    <link rel="stylesheet" type="text/css" href="css/mainStyle.css">
</head>

<body>
</h1><a href="LogOut.php">Log OUT </a><br></h1>
<?php
require_once "../classes/Friends.php";
session_start();
echo "Привет, ". $_SESSION['user']."!";
?>

    <h2> Какой сегодня день? Что нового?</h2>
<form method="get" action="site/php/New_Friends.php" id="ADD">

    <button type="submit" name="do_add"> Добавить друзей!</button>
    <button type="submit" name="do_show"> Посмотреть всех друзей</button> <br>

</form>
<?php if (isset($_GET['do_add'])): ?>

    <table>
        <tr>
            <td>
                <form method="post" action="site/php/New_Friends.php" id="ADD_Friends">
                    <fieldset>
                        <strong>Имя: </strong>
                        <input type="text" name="username" required> <br>
                        <strong>Дата рождения:</strong><br>

                        <input type="date" name="birthday" required><br>

                    </fieldset>

                    <button type="submit" name="do_friends"> Добавить</button>

                </form>
            </td>
        </tr>
    </table>
<?php endif; ?>

<?php
if (isset($_POST['do_friends']))

{
    $db=new Friends($_POST);
    $db->Add_Friend($_SESSION['user']);
}




 ?>



</body>
</html>
