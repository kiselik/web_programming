<?php

/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 15.12.2016
 * Time: 22:28
 */
require_once "Database.php";
class Friends
{
    private $local_data;
    private $db;

    public function __construct(array $data)
    {
        $this->local_data = array();
        $this->local_data = $data;
        unset($this->local_data['birthday']);
        $this->pars_str($data['birthday']);
        /*var_dump($this->local_data);
        echo date("d m ");*/


    }

    private function pars_str(string $tmp)
    {
        $this->local_data['year'] = substr($tmp, 0, 4);
        $this->local_data['month'] = substr($tmp, 5, 2);
        $this->local_data['day'] = substr($tmp, 8, 2);
    }
    public function Add_Friend(string $owner)
    {
        $this->db=new Database();
        $this->db->Add_Friend($this->local_data, $owner);

    }

}