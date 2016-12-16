<?php

/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 26.11.2016
 * Time: 0:55
 */
class Database
{
    private $local_opt, $conn, $db_errors, $result_data,$result_str;
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
        $this->result_data = array();
        $this->result_str=array();
        @$this->conn = new mysqli($this->local_opt['host'], $this->local_opt['user'], $this->local_opt['pass'], $this->local_opt['db']);

        if (!$this->conn) die($this->errors = 'Ошибка соединения с MYSQL: ошибка № ' . $this->conn->connect_errno . " " . $this->conn->connect_errno);
    }

    //добавить пользователя  в бд
    final public function Add_User(array $data)
    {
        # проверяем, есть ли в бд такой логин
        $this->Check_username($data['username']);

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

    //проверить в бд пользователя
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
            $stmt->bind_result($this->result_data['count'], $this->result_data['name'], $this->result_data['password']);

            # получить найденные значения
            $stmt->fetch();

            # закрываем запрос
            $stmt->close();
        }
    }

    //добавить друга в бд
    final public function Add_Friend(array $data, string $owner)
    {
        #узнаем под каким номером записан владелец в другой таблице
        $this->Check_username($owner);
        # подготовка запроса
        $str = "INSERT INTO friends (Owner,name,day,month,year) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->prepare($str);

        # вторая стадия: привязка параметров
        $stmt->bind_param('sssss', $this->result_data['count'], $data['username'], $data['day'], $data['month'], $data['year']);

        # выполнение запроса
        if (!$stmt->execute()) # выполняем запрос
        {
            $this->db_errors[] = "ошибка" . $stmt->errno . " " . $stmt->error;
        } else {
            $stmt->store_result();# сохраняем результаты
            $stmt->close(); # закрываем запрос
        }


    }

    // посмотреть всех имеющихся друзей
    final public function Show_Friends(string $owner)
    {
        $flag = false;
        unset($this->result_str);
        $this->Check_username($owner);
        # подготовка запроса
        # mysql> SELECT * FROM [table name] WHERE [field name] = "whatever"
        $stmt = $this->conn->prepare("SELECT * FROM friends WHERE Owner=? ");

        # вторая стадия: привязка параметров
        $stmt->bind_param('s', $this->result_data['count']);
        # выполнение запроса
        if (!$stmt->execute()) # выполняем запрос
        {
            $this->db_errors[] = "ошибка выполнения запроса" . $stmt->errno . " " . $stmt->error;
        } else {
            $flag = true;
            //$stmt->store_result();# сохраняем результаты

            # Определить переменные для записи результата
            $stmt->bind_result($id, $owner, $name, $day, $month, $year);

            # получить найденные значения
            while ($stmt->fetch()) {
                $this->result_str[]="$name " . "$day " . "$month " . "$year<br>";
            }
        }
        # закрываем запрос
        $stmt->close();
        return $flag;
    }

    // показать всех, у кого в этом месяце день рождения
    final public function Show_Month(string $owner, string $month)
    {
        $flag = false;
        unset($this->result_str);
        $this->Check_username($owner);
        # подготовка запроса
        # mysql> SELECT * FROM [table name] WHERE [field name] = "whatever"
        $stmt = $this->conn->prepare("SELECT * FROM friends WHERE Owner=?  AND  month=?");

        # вторая стадия: привязка параметров
        $stmt->bind_param('ss', $this->result_data['count'], $month);

        # выполнение запроса
        if (!$stmt->execute()) # выполняем запрос
        {
            $this->db_errors[] = "ошибка выполнения запроса" . $stmt->errno . " " . $stmt->error;
        } else {
            $flag = true;
            //$stmt->store_result();# сохраняем результаты

            # Определить переменные для записи результата
            $stmt->bind_result($id, $owner, $name, $day, $month, $year);

            # получить найденные значения
            while ($stmt->fetch()) {
                $this->result_str[]=" $name " . "$day " . "$month " . "$year<br>";
            }
            
        }
        # закрываем запрос
        $stmt->close();
        return $flag;
    }

    // показать всех, у кого сегодня  или завтра день рождения
    final public function Show_day(string $owner, string $day)
    {
        unset($this->result_str);
        $flag = false;
        $this->Check_username($owner);
        # подготовка запроса
        # mysql> SELECT * FROM [table name] WHERE [field name] = "whatever"
        $stmt = $this->conn->prepare("SELECT * FROM friends WHERE Owner=?  AND  day=?");

        # вторая стадия: привязка параметров
        $stmt->bind_param('ss', $this->result_data['count'], $day);

        # выполнение запроса
        if (!$stmt->execute()) # выполняем запрос
        {
            $this->db_errors[] = "ошибка выполнения запроса" . $stmt->errno . " " . $stmt->error;
        } else {
            $flag = true;
            //$stmt->store_result();# сохраняем результаты

            # Определить переменные для записи результата
            $stmt->bind_result($id, $owner, $name, $day, $month, $year);
            # получить найденные значения
            while ($stmt->fetch()) {
                #echo "I am here";
                $this->result_str[]=" $name " . "$day " . "$month " . "$year<br>";
                #var_dump($name, $day, $month, $year);
            }
        }
        # закрываем запрос
        $stmt->close();
        return $flag;
    }


    // передать хешированный пароль
    public function Get_Password_SQL()
    {
        return ($this->result_data['password']);
    }

    /*    public function Get_Count_SQL()
        {
            return ($this->result_data['count']);
        }*/
    public function Show_Result()
    {

        return ($this->result_str);
    }

    //получить весь массив ошибок
    public function Get_Errors()
    {
        return ($this->db_errors);
    }

    //показать только первую ошибку
    public function Show_Errors()
    {
        return array_shift($this->db_errors);
    }

    # закрываем соединение с MYSQL
    public function Close()
    {
        $this->conn->close();
    }


}