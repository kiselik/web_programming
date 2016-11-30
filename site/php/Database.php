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
        /* var_dump($opt);
         echo"<br>";
         var_dump($this->defaults);
         echo"<br>";*/

        // может быть здесь место для проверки
        $this->local_opt = array_merge($this->defaults, $opt); # мержим два массива

        @$this->conn = new mysqli($this->local_opt['host'], $this->local_opt['user'], $this->local_opt['pass'], $this->local_opt['db']);

        if (!$this->conn) die('Ошибка соединения с MYSQL: ошибка № ' . $this->conn->connect_errno . " " . $this->conn->connect_errno);
        echo 'Успешно соединились';
    }


    public function Add_User(array $data)
    {
        //var_dump($this->conn);
        /* подготавливаемый запрос, первая стадия: подготовка */
        //$this->conn->stmt_init();
        var_dump($data);
        $stmt = $this->conn->prepare("INSERT INTO users (login,pass) VALUES (?,?)");
        if (!$stmt) {
            echo('Не удалось подготовить запрос: Ошибка № ' .$stmt->errno . " " . $stmt->error);
        }
        /* подготавливаемый запрос, вторая стадия: привязка и выполнение */
        if (!$stmt->bind_param('ss', $data['username'],$data['password']))
            {
            echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
    }

        if (!$stmt->execute()) {
            echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
        }
        else{ echo "tip vse rabotaet";}

        /* рекомендуется явно закрывать запросы */
        $stmt->close();
    }

}