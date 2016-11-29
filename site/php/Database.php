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

        //var_dump( $this->local_opt);

        $this->openConnection();

    }

    private function openConnection() # процедура посоединения к бд
    {
        @$this->conn = mysqli_connect($this->local_opt['host'], $this->local_opt['user'], $this->local_opt['pass'], $this->local_opt['db']);
        if (!$this->conn) die('Ошибка соединения с MYSQL: ошибка № '.mysqli_connect_errno()." " . mysqli_connect_error());
        echo 'Успешно соединились';
    }

    public function Add_User(array $date)
    {


    }


}