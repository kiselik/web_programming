<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LogIn</title>
    <base href="http://localhost/Reminder/">
    <link rel="stylesheet" type="text/css" href="css/mainStyle.css">
</head>
<body>

<?php

require_once "../classes/Entry.php";

$data_lg = new Entry($_POST);
if (isset($_POST['do_login'])) # если клавиша "зарегестрировать была нажата, то проведем процесс регистрации
{
    unset($_POST);
    # если есть косяки
    if (!$data_lg->LOGIN_User()) {

        # посмотрим первую замеченную ошибку
        echo '<h1>' . $data_lg->Get_Errors() . '</h1>';
    } else {
        session_start();
        $_SESSION['user'] = $data_lg->Get_Login();
        header('Location: New_Friends.php');
        # echo '<h1> Вы авторизованы!<br> Можете перейти на <a href="site/php/Start_Page.php"> главную</a> страницу</h1>';

    }
}
?>
<h2>Ура! пора авторизоваться</h2>
<form method="post" action="site/php/Login.php" id="LOGIN">
    <fieldset> <!-- заставим форму выглядеть как блок-->
        <strong>Логин: </strong>
        <input type="text" name="username" required value="<?php
        echo @$data_lg->Get_Login(); ?>"> <br>
        <!-- value нужно для того, чтобы при различных ползовательских ошибках правильные поля не приходилось вводить еще раз-->
        <strong>Пароль:</strong>
        <input type="password" name="password"><br>
    </fieldset>

    <button type="submit" name="do_login"> Войти</button>

</form>
</body>
</html>
