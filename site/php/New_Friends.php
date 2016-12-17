<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Reminder</title>
    <base href="http://localhost/Reminder/"> <!-- корень сайта, определенный внутри этого файла -->
    <!-- Корень сайта - Start_Page.html-->
    <link rel="stylesheet" type="text/css" href="css/mainStyle.css">
</head>

<body>
</h1><a href="site/php/LogOut.php">Log OUT </a><br></h1>
<?php
require_once "../classes/Friends.php";
session_start();
echo "Привет, " . $_SESSION['user'] . "!";
?>

<h2> Какой сегодня день? Что нового?</h2>
<form method="get" action="site/php/New_Friends.php" id="SHOW">
    <button type="submit" name="do_show_month"> Дни рождения этого месяца</button>
    <button type="submit" name="do_show_day"> Ближайшие дни рождения</button>
    <br><br>
</form>
<!-- если решили посмотреть у кого в ближайший месяц др -->
<?php
if (isset($_GET['do_show_month'])) {
    $show = new Database();
    if ($show->Show_Month($_SESSION['user'], date("m"))) {
        if ($show->Show_Result()) {
            foreach ($show->Show_Result() as $value)
                echo $value;

            unset($_GET['do_show_month']);
        } else {
            echo "Сначала нужно добавить друзей<br>";
        }
    } else {
        echo '<h3>' . $show->Show_Errors() . '</h3>';
    }
}
?>
<!-- если решили посмотреть у кого сегодня либо завтра др -->
<?php
if (isset($_GET['do_show_day'])) {
    $show_day = new Database();
// на сегодня
    if ($show_day->Show_day($_SESSION['user'], date("d"))) {

        if ($show_day->Show_Result()) {
            echo "Не забудь сегодня позвонить и поздравить:  <br>";
            foreach ($show_day->Show_Result() as $value)
                echo $value;
            echo "<br>";
        } else {
            echo "Сначала нужно добавить друзей<br>";
        }
    } else {
        echo '<h3>' . $show_day->Show_Errors() . '</h3>';
    }
// на завтра
    if ($show_day->Show_day($_SESSION['user'], date("d") + 1)) {
        if ($show_day->Show_Result()) {
            echo "А завтра звякнуть:  <br>";
            foreach ($show_day->Show_Result() as $value)
                echo $value;
            echo "<br>";
            unset($_GET['do_show_day']);
        } /*else {
            echo "Сначала нужно добавить друзей<br>";
        }*/
    } else {
        echo '<h3>' . $show_day->Show_Errors() . '</h3>';
    }
}

?>


<form>
    <br>
    <button type="submit" name="do_add"> Добавить друзей!</button>
    <!--<button type="submit" name="do_edit"> Pедактировать!</button>-->
    <button type="submit" name="do_show"> Посмотреть всех друзей</button>
    <br><br>

</form>
<!-- если решили добавить друзей в список на напоминание -->
<?php
if (isset($_POST['do_friends'])) {
    $add = new Friends($_POST);
    if ($add->Add_Friend($_SESSION['user'])) {
        echo "Ура, получилось! Добавь еще больше своих друзей!";
        unset($_POST['do_friends']);
    } else {
        echo '<h3>' . $add->Get_Errors() . '</h3>';
    }
}
?>

<!-- если решили посмотреть всех своих друзей -->
<?php
if (isset($_GET['do_show'])) {
    $show = new Database();
    if ($show->Show_Friends($_SESSION['user'])) {
        if ($show->Show_Result()) {
            echo "<br>";
            foreach ($show->Show_Result() as $value)
                echo $value;;
            unset($_GET['do_show']);
        } else {
            echo "Сначала нужно добавить друзей<br>";
        }
    } else {
        echo '<h3>' . $show->Show_Errors() . '</h3>';
    }
}
?>


<!-- если указали все данные о друзьях и нажали "добавить"-->
<?php if (isset($_GET['do_add'])): ?>

    </form>
    <table>
        <tr>
            <td>
                <form method="post" action="site/php/New_Friends.php" id="Show_month">
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
    </form>

<?php endif; ?>


</body>
</html>
