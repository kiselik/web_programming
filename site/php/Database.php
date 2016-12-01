<?php

/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 26.11.2016
 * Time: 0:55
 */
class Database
{
    private $local_opt, $conn;
    private $defaults = array(
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'root',
        'db' => 'birthday',
    );

    public function __construct($opt = array())
    {
        $this->local_opt = array_merge($this->defaults, $opt); # мержим два массива

        @$this->conn = new mysqli($this->local_opt['host'], $this->local_opt['user'], $this->local_opt['pass'], $this->local_opt['db']);

        if (!$this->conn) die($this->errors = 'Ошибка соединения с MYSQL: ошибка № ' . $this->conn->connect_errno . " " . $this->conn->connect_errno);
    }

    public function Add_User(array $data)
    {
        $flag = $this->Check_login($data['username']); # проверяем, есть ли в бд такой логин
        #var_dump($flag);
        if (!$flag) { //если нет такого логина, то записываем в бд

            $stmt = $this->conn->prepare("INSERT INTO users (login,pass) VALUES (?,?)");
            if (!$stmt) {
                echo('Не удалось подготовить запрос: Ошибка № ' . $stmt->errno . " " . $stmt->error);
            }
            /* подготавливаемый запрос, вторая стадия: привязка и выполнение */
            if (!$stmt->bind_param('ss', $data['username'], $data['password'])) {
                echo("Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error);
            } else {
                $stmt->execute(); # выполняем запрос
                $stmt->store_result();# сохраняем результаты
                $stmt->close(); # закрываем запрос
            }
        } else {

            echo "Пользователь с таким логином уже существует!";
        }

    }

    public function Check_login(string $login)
    {
        $res = -1;
        # mysql> SELECT * FROM [table name] WHERE [field name] = "whatever"
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE login=? ");
        if (!$stmt) {
            echo('Не удалось подготовить запрос: Ошибка № ' . $stmt->errno . " " . $stmt->error);
        }
        /* подготавливаемый запрос, вторая стадия: привязка и выполнение */
        if (!$stmt->bind_param('s', $login)) {
            echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $stmt->execute(); # выполняем запрос
            $stmt->store_result(); # сохраняем результаты
            $res = $stmt->num_rows; # считаем количество строчек, найденных при запросе
            #var_dump($res); # это была проверка

        }
        $stmt->close(); # закрываем запрос
        return $res;
    }

    public function Close()
    {
        $this->conn->close(); # закрываем соединение с MYSQL
    }


}