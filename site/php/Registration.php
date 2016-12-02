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
    private $local_data, $errors, $flag = false;
    private $db;

    public function __construct(array $data)
    {
        if (isset($data['do_signup'])) # если клавиша "зарегестрировать была нажата, то проведем процесс регистрации
        {
            $this->local_data = $data;
            $this->errors = array(); # проверим на пользовательские ошибки. Если они есть положим в этот массив

        }
    }

    public function Check_Data()
    {
        $this->Check_Username(); # чекаем логин
        $this->Check_Password(); # чекаем пароль
        if (empty($this->errors)) { # если наконец-то все правильно ввели даем добро на регистрацию
            $this->local_data['password']=password_hash($this->local_data['password'], PASSWORD_DEFAULT);

            unset($this->local_data['password_repeat']);
            $this->flag = true;

        } else {
            $this->flag = false;
        }
        return ($this->flag);
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

    public function Get_Password()
    {
        return ($this->local_data['password']);
    }

    public function Get_Repeat_Password()
    {
        return ($this->local_data['password_repeat']);
    }

    public function Get_Errors()
    { # из всего массива ошибок выводит на экран только первую ошибку, поясняющую, что нужно исправить
        return (array_shift($this->errors));
    }

    public function Add_User()
    {
        $this->db = new Database();
       /* echo" check <br>";
        var_dump($this->local_data);*/
        $this->db->Add_User($this->local_data);

       /* unset($this->local_data);
        echo" check2 <br>";
        var_dump($this->local_data);*/

        $this->db->Close();

    }

}