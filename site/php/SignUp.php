<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LogIn</title>
    <base href="http://localhost/Reminder/"> <!-- корень сайта, определенный внутри этого файла -->
    <link rel="stylesheet" type="text/css" href="css/mainStyle.css">
</head>
<body>


<h2>Ура! пора регистрироваться</h2>
<form method="post" action="SignUp.php" id="LOGIN">
    <fieldset> <!-- заставим форму выглядеть как блок-->
        <strong>Логин: </strong>
        <input type="text" name="username" size="15" required value=""> <br>
        <strong>E-mail: </strong>
        <input type="email" name="mail" required/> <br>
        <strong>Пароль:</strong>
        <input type="password" name="password"><br>
        <strong>Еще раз пароль:</strong>
        <input type="password" name="password_repeat"><br>
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
    <button type="submit" name="do_signup">Зарегестрироваться</button>
</form>
</body>
</html>
