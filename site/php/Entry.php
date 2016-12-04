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
        $this->local_data = $data;
        $this->errors = array(); # проверим на пользовательские ошибки. Если они есть положим в этот массив
        #unset($data);
    }

    final public function Check_Data()
    {
        $flag = false;
        $this->Check_Username(); # чекаем логин
        $this->Check_Password(); # чекаем пароль
        if (empty($this->errors)) { # если наконец-то все правильно ввели даем добро на регистрацию

            $this->local_data['password']=password_hash($this->local_data['password'], PASSWORD_DEFAULT);
            $flag = true;

        }
        return ($flag);
    }

    final protected function Check_Username() # можно добавить проверку на наличие такого же логина в бд
    {
        if (trim($this->local_data['username']) == '') # trim-функция, обрезающая лишние пробелы
        {
            $this->local_data['username'] = '';
            $this->errors[] = "Введите корректный логин!";
        }
    }

    protected function Check_Password()
    {
        if (trim($this->local_data['password']) == '') {
            $this->local_data['password'] = '';
            $this->errors[] = "Введите пароль!";
        } else {
            $this->local_data['password'] = password_hash($this->local_data['password'], PASSWORD_DEFAULT);
        }
    }

    public function Get_Login()
    {
        return $this->local_data['username'];
    }

    public function Get_Errors()
    { # из всего массива ошибок выводит на экран только первую ошибку, поясняющую, что нужно исправить
        return $this->errors;
    }

    final public function LOGIN_User()
    {
        echo "я работаю";
        $flag = false;
        $this->db = new Database();
        $this->db->Check_login($this->local_data);
        var_dump( "here",$this->db->Check_login($this->local_data));
        if (empty($this->db->Get_Errors())) { # если наконец-то все правильно ввели даем добро на регистрацию

            $flag = true;
            echo "Ура, успешно авторизованы. Скоро здесь будет редирект";
            unset($this->local_data);
            $this->db->Close();
        } else {
            $this->errors += $this->db->Get_Errors();
        }
        return ($flag);
    }


}