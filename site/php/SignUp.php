<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LogIn</title>
    <base href="http://localhost/Reminder/"> <!-- корень сайта, определенный внутри этого файла -->
    <link rel="stylesheet" type="text/css" href="css/mainStyle.css">
</head>
<body>

<?php

require_once "../classes/Registration.php";

$data = new Registration($_POST);
if (isset($_POST['do_signup'])) # если клавиша "зарегестрировать была нажата, то проведем процесс регистрации
{
    unset($_POST);
    # если есть косяки
    if (!$data->Add_User()) {
        # посмотрим первую замеченную ошибку
        echo '<h1>' . $data->Get_Errors() . '</h1>';
    }
    else
        { # если нет косяков, порадуемся
            echo '<h1> Вы зарегестрированы!<br> Можете перейти на <a href="site/php/Start_Page.php"> главную</a> страницу</h1>';
        }
}
?>
<h2>Ура! пора регистрироваться</h2>
<form method="post" action="site/php/SignUp.php" id="UpSign">
    <fieldset> <!-- заставим форму выглядеть как блок-->
        <strong>Логин: </strong>
        <input type="text" name="username" required value="<?php
        echo @$data->Get_Username(); ?>"> <br>
        <!-- value нужно для того, чтобы при различных ползовательских ошибках правильные поля не приходилось вводить еще раз-->
        <strong>E-mail: </strong>
        <input type="email" name="mail" required value="<?php
        echo @$data->Get_EMail(); ?>"/> <br>
        <strong>Пароль:</strong>
        <input type="password" name="password"><br>
        <strong>Еще раз пароль:</strong>
        <input type="password" name="password_repeat" > <br> <!-- если в процессе регистрации пошло что-то не так, сорри,
                                                            придется подтвердить пароль еще раз. Обещаю подумать над этим пунктом-->
    </fieldset>

    <button type="submit" name="do_signup">Зарегистрироваться</button>

</form>
</body>
</html>
