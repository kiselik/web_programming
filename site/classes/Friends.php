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
    private $db, $errors;

    public function __construct(array $data)
    {
        $this->local_data = array();
        $this->errors = array();
        $this->local_data = $data;
        unset($this->local_data['birthday']);
        $this->pars_str($data['birthday']);
    }

    private function pars_str(string $tmp)
    {
        $this->local_data['year'] = substr($tmp, 0, 4);
        $this->local_data['month'] = substr($tmp, 5, 2);
        $this->local_data['day'] = substr($tmp, 8, 2);
    }

    public function Add_Friend(string $owner)
    {
        $flag = false;
        $this->db = new Database();
        //пытаемся добавить, если все хорошо
        $this->db->Add_Friend($this->local_data, $owner);
        if (empty($this->db->Get_Errors())) {
            $flag = true;
            $this->db->Close();
        } else {
            $this->errors = $this->db->Get_Errors();
        }
        return $flag;

    }

    public function Show_Friends(string $owner)
    {
        $flag = false;
        $this->db = new Database();
        //пытаемся добавить, если все хорошо

        $this->db->Show_Friends($owner);
        if (empty($this->db->Get_Errors())) {
            $flag = true;
            $this->db->Close();
        } else {
            $this->errors = $this->db->Get_Errors();
        }
        return $flag;

    }

    public function Get_Errors()
    {
        return ($this->errors[0]);
    }

}