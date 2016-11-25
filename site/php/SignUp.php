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
$link = mysqli_connect('localhost', 'root', 'root')or die('Ошибка соединения: ' . mysqli_error());

echo 'Успешно соединились';
$data = $_POST;
if (isset($data['do_signup'])) # если клавиша "зарегестрировать была нажата, то проведем процесс регистрации
{
    $errors = array(); # проверим на пользовательские ошибки. Если они есть положим в этот массив
    if (trim($data['username']) == '') # trim-функция, обрезающая лишние пробелы
    {
        $data['username']='';
        $errors[] = "Введите корректный логин!";
    }
    if (trim($data['password']) == '')
    {
        $data['password']='';
        $data['password_repeat']='';
        $errors[] = "Введите пароль!";
    }
    if ($data['password'] != $data['password_repeat']) {
        $errors[] = "Пароли не совпадают!";
    }
    if (empty($errors)) {
        //процесс записи данных в бд, но его пока нет

    } else {
        echo '<h1>' . array_shift($errors) . '</h1>'; # берем первый элемент массива, показываем и изымаем
    }


}

?>
<h2>Ура! пора регистрироваться</h2>
<form method="post" action="site/php/SignUp.php" id="LOGIN">
    <fieldset> <!-- заставим форму выглядеть как блок-->
        <strong>Логин: </strong>
        <input type="text" name="username" required value="<?php
        echo @$data['username']; ?>"> <br>
        <strong>E-mail: </strong>
        <input type="email" name="mail" required value="<?php
        echo @$data['mail']; ?>"/> <br>
        <strong>Пароль:</strong>
        <input type="password" name="password" value="<?php
        echo @$data['password']; ?>""><br>
        <strong>Еще раз пароль:</strong>
        <input type="password" name="password_repeat" value="<?php
        echo @$data['password_repeat']; ?>""><br>
    </fieldset>
    <fieldset>
        Имя:
        <input type="text" name="first_name"><br>
        Фамилия:
        <input type="text" name="last_name"/><br>
        Пол:
        <input type="radio" name="gender" value="female" checked> Male
        <input type="radio" name="gender" value="male"> Female<br>
    </fieldset>
    <button type="submit" name="do_signup">Зарегистрироваться</button>

</form>
</body>
</html>
