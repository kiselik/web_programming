<?php

/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 26.11.2016
 * Time: 0:55
 */
class Database
{
    private $local_opt, $conn, $db_errors, $result_data;
    private $defaults = array(
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'root',
        'db' => 'birthday',
    );

    public function __construct($opt = array())
    {
        $this->local_opt = array_merge($this->defaults, $opt); # мержим два массива

        $this->db_errors = array();
        $this->result_data=array();

        @$this->conn = new mysqli($this->local_opt['host'], $this->local_opt['user'], $this->local_opt['pass'], $this->local_opt['db']);

        if (!$this->conn) die($this->errors = 'Ошибка соединения с MYSQL: ошибка № ' . $this->conn->connect_errno . " " . $this->conn->connect_errno);
    }

    public function Add_User(array $data)
    {
        # проверяем, есть ли в бд такой логин
        $flag = $this->Check_username($data['username']);

        # если количество найденных в бд записей с выбранным логином ноль, т.е. такого пользователя еще нет...
        if (!$this->result_data['count']) {
            # вставим его в бд
            # подготовка запроса
            $stmt = $this->conn->prepare("INSERT INTO users (login,pass) VALUES (?,?)");

            # вторая стадия: привязка параметров
            $stmt->bind_param('ss', $data['username'], $data['password']);

            # выполнение запроса
            if (!$stmt->execute()) # выполняем запрос
            {
                $this->db_errors[] = "ошибка" . $stmt->errno . " " . $stmt->error;
            } else {

                $stmt->store_result();# сохраняем результаты
                $stmt->close(); # закрываем запрос
            }
        } else {

            $this->db_errors[] = "Пользователь с таким логином уже существует!";
        }

    }

    final public function Check_username(string $login)
    {
        # подготовка запроса
        # mysql> SELECT * FROM [table name] WHERE [field name] = "whatever"
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE login=? ");

        # вторая стадия: привязка параметров
        $stmt->bind_param('s', $login);

        # выполнение запроса
        if (!$stmt->execute()) # выполняем запрос
        {
            $this->db_errors[] = "ошибка выполнения запроса" . $stmt->errno . " " . $stmt->error;
        } else {

            $stmt->store_result();# сохраняем результаты

            # Определить переменные для записи результата
            $stmt->bind_result($this->result_data['count'],$this->result_data['username'],$this->result_data['password']);

            # получить найденные значения
            $stmt->fetch();

            # закрываем запрос
            $stmt->close();
        }
    }

    public  function Get_Password_SQL()
    {
        return($this->result_data['password']);
    }
    public  function Get_Count_SQL()
    {
        return($this->result_data['count']);
    }

    public
    function Get_Errors()
    {
        return ($this->db_errors);
    }

    public
    function Close()
    {
        $this->conn->close(); # закрываем соединение с MYSQL
    }


}