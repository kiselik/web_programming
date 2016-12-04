<?php

/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 02.12.2016
 * Time: 15:01
 */
require_once 'Database.php';

class Entry
{
    private $local_data, $errors;
    private $db;

    public function __construct(array $data)
    {
        if (isset($_POST['do_login'])) {
            $this->local_data = $data;
            $this->errors = array(); # проверим на пользовательские ошибки. Если они есть положим в этот массив
        }
    }

    public function Get_Login()
    {
        return ($this->local_data['username']);
    }

    public function Get_Errors()
    { # из всего массива ошибок выводит на экран только первую ошибку, поясняющую, что нужно исправить
        return (array_shift($this->errors));
    }

    final public function LOGIN_User()
    {
        $flag = false;
        # если данные ведены корректно
        if ($this->Check_Data()) {
            # быстренько подключаемся к бд
            $this->db = new Database();

            # проверяем, есть ли запись с таким же логином и паролем(его хэшем) в бд
            $this->db->Check_username($this->local_data['username']);
            // если что-то нашли в бд, то продолжаем проверку

            $tmp2 = password_verify($this->local_data['password'], $this->db->Get_Password_SQL());
            if(!$tmp2)
            {
                $this->errors[] = " Неправильно набран логин или пароль!";
            }

            #  если ошибок нет И хэши паролей совпали, то ура
            if (empty($this->db->Get_Errors()) && ($tmp2)) {
                $flag = true;
                $this->db->Close();
            } else {
                $this->errors += $this->db->Get_Errors();
            }
        }
        return $flag;

    }

    private function Check_Data()
    {
        $flag = false;
        $this->Check_Username(); # чекаем логин
        $this->Check_Password(); # чекаем пароль
        if (empty($this->errors)) { # если наконец-то все правильно ввели даем добро на регистрацию

            $flag = true;

        }
        return ($flag);
    }

    private function Check_Username() # можно добавить проверку на наличие такого же логина в бд
    {
        if (trim($this->local_data['username']) == '') # trim-функция, обрезающая лишние пробелы
        {
            $this->local_data['username'] = '';
            $this->errors[] = "Введите корректный логин!";
        }
    }

    private function Check_Password()
    {
        if (trim($this->local_data['password']) == '') {
            $this->local_data['password'] = '';
            $this->errors[] = "Введите пароль!";
        }
    }
}