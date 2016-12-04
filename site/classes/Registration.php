<?php

/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 30.11.2016
 * Time: 0:39
 */
require_once 'Database.php';

class Registration
{
    private $local_data, $errors;
    private $db;

    public function __construct(array $data)
    {
        if (isset($_POST['do_signup'])) {
            $this->local_data = $data;
            $this->errors = array(); # проверим на пользовательские ошибки. Если они есть положим в этот массив
        }
    }

    private function Check_Data()
    {
        $flag = false;
        $this->Check_Username(); # чекаем логин
        $this->Check_Password(); # чекаем пароль
        if (empty($this->errors)) { # если наконец-то все правильно ввели даем добро на регистрацию

            $this->local_data['password'] = password_hash($this->local_data['password'], PASSWORD_DEFAULT);
            unset($this->local_data['password_repeat']);
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

    private function Check_Password() # можно заставлять юзера придумывать пароль посложнее
    {
        if (trim($this->local_data['password']) == '') {
            $this->local_data['password'] = '';
            $this->local_data['password_repeat'] = '';
            $this->errors[] = "Введите пароль!";
        }
        if ($this->local_data['password'] != $this->local_data['password_repeat']) {
            $this->errors[] = "Пароли не совпадают!";
        }
    }

    public function Get_Username()
    {
        return ($this->local_data['username']);
    }

    public function Get_EMail()
    {
        return ($this->local_data['mail']);
    }

    public function Get_Errors()
    { # из всего массива ошибок выводит на экран только первую ошибку, поясняющую, что нужно исправить
        return (array_shift($this->errors));
    }

   final public function Add_User()
    {
        $flag = false;
# если данные ведены корректно
        if ($this->Check_Data()) {

            # начинаем работу с бд
            $this->db = new Database();
            #  вызываем метод добавления юзера
            $this->db->Add_User($this->local_data);
            # если в этом процессе не нашлось ошибок, то класс, пишем поздавляшки
            if (empty($this->db->Get_Errors())) { # если наконец-то все правильно ввели даем добро на регистрацию

                $flag = true;
                unset($this->local_data);
                $this->db->Close();
            } else { # если нет, то выводим сообщеньку
                $this->errors += $this->db->Get_Errors();
            }
        }
        return ($flag);
    }

}